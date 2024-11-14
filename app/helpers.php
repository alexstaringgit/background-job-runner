<?php

use App\Services\BackgroundJobRunner;

function runBackgroundJob($className, $methodName, $parameters = [], $retryAttempts = 0)
{
    $runner = new BackgroundJobRunner();
    $runner->run($className, $methodName, $parameters, $retryAttempts);
}
