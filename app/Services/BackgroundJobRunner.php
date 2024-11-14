<?php

namespace App\Services;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Exception;

class BackgroundJobRunner
{
    public function run($className, $methodName, $parameters = [], $retryAttempts = 0)
    {
        // Check if the class is allowed
        // if (!in_array($className, Config::get('background_jobs.allowed_classes'))) {
        //     throw new Exception("Unauthorized class: {$className}");
        // }
        try {
            // Validate class and method
            if (!class_exists($className) || !method_exists($className, $methodName)) {
                throw new Exception("Invalid class or method: {$className}::{$methodName}");
            }

            // Instantiate the class
            $object = new $className();

            // Execute the method with parameters
            $result = call_user_func_array([$object, $methodName], $parameters);

            // Log success
            Log::channel('background_jobs')->info("Job executed successfully", [
                'class' => $className,
                'method' => $methodName,
                'parameters' => $parameters,
                'status' => 'success'
            ]);

            return $result;
        } catch (Exception $e) {
            Log::channel('background_jobs_errors')->error("Job failed", [
                'class' => $className,
                'method' => $methodName,
                'parameters' => $parameters,
                'error' => $e->getMessage(),
                'status' => 'failed'
            ]);

            if ($retryAttempts > 0) {
                // Retry the job if retries are available
                return $this->run($className, $methodName, $parameters, $retryAttempts - 1);
            }
        }

        return false;
    }
}
