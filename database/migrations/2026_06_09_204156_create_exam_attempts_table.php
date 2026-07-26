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
        Schema::create('exam_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained();
            $table->foreignId('user_id')->constrained();

            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();

            $table->float('score')->nullable();

            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();

            $table->enum('status', ['in_progress', 'finished'])->default('in_progress');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_attempts');
    }
};
