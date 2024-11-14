<?php

// Example: app/Console/Commands/RunSampleJob.php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RunSampleJob extends Command
{
    protected $signature = 'job:run-sample';
    protected $description = 'Run SampleJob in the background';

    public function handle()
    {
        runBackgroundJob(App\Jobs\SampleJob::class, 'executeJob', ['Hello, World!'], 3);

        $this->info('Sample job has been dispatched in the background.');
    }
}
