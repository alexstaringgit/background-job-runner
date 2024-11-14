<?php

namespace App\Jobs;

use Exception;
use Illuminate\Support\Facades\Log;

class BackgroundJobRunner
{
    protected $className;
    protected $methodName;
    protected $parameters;

    public function __construct($className, $methodName, $parameters)
    {
        $this->className = $className;
        $this->methodName = $methodName;
        $this->parameters = $parameters;
    }

    public function handle()
    {
        try {
            // Validate class and method names to avoid executing harmful code
            if (!$this->isValidClass($this->className)) {
                throw new Exception("Unauthorized class: " . $this->className);
            }

            if (!method_exists($this->className, $this->methodName)) {
                throw new Exception("Method not found: " . $this->methodName);
            }

            // Instantiate the class and execute the method
            $class = new $this->className;
            $result = call_user_func_array([$class, $this->methodName], $this->parameters);

            // Log success
            Log::info("Background Job Success: $this->className@$this->methodName", [
                'status' => 'success',
                'parameters' => $this->parameters
            ]);

        } catch (Exception $e) {
            // Log failure
            Log::error("Background Job Error: $this->className@$this->methodName", [
                'status' => 'failed',
                'error' => $e->getMessage(),
                'parameters' => $this->parameters
            ]);
        }
    }

    private function isValidClass($className)
    {
        // Define an array of approved classes that can be executed
        $approvedClasses = [
            'App\\Services\\ValidClass1',
            'App\\Services\\ValidClass2',
            // Add more allowed classes here
        ];

        return in_array($className, $approvedClasses);
    }
}
