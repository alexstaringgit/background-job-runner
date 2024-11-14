<?php

namespace App\Jobs\Middleware;

use Closure;

class SampleJobMiddleware
{
    /**
     * Process the queued job.
     *
     * @param  \Closure(object): void  $next
     */
    public function handle(object $job, Closure $next): void
    {
        $next($job);
    }
}
