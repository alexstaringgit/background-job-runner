<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BackgroundJobController;
use App\Models\BackgroundJob;
Route::get('/', function () {
    return view('welcome');
});

Route::get('/run-job', function () {
    runBackgroundJob(App\Jobs\SampleJob::class, 'executeJob', ['Hello, World!'], 3);

    return 'Job dispatched!';
});


Route::prefix('background-jobs')->name('background_jobs.')->group(function() {
    Route::get('/', [BackgroundJobController::class, 'index'])->name('index');
    Route::get('{job}', [BackgroundJobController::class, 'show'])->name('show');
    Route::post('{job}/retry', [BackgroundJobController::class, 'retry'])->name('retry');
    Route::delete('{job}', [BackgroundJobController::class, 'cancel'])->name('cancel');
});
