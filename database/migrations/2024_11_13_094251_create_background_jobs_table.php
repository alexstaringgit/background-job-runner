<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('background_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('class_name');
            $table->string('method_name');
            $table->json('parameters')->nullable();
            $table->string('status')->default('pending'); // pending, running, completed, failed
            $table->integer('retry_count')->default(0);
            $table->timestamps();
            $table->softDeletes(); // Soft delete jobs if needed
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('background_jobs');
    }
};
