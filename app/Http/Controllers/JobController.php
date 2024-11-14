<?php

// Example: app/Http/Controllers/JobController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JobController extends Controller
{
    public function runSampleJob()
    {
        // Trigger the background job
        runBackgroundJob(App\Jobs\SampleJob::class, 'executeJob', ['Hello, World!'], 3);

        return response()->json(['message' => 'Job started in the background']);
    }
}
