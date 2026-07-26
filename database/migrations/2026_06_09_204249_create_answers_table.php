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
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_attempt_id')->constrained()->cascadeOnDelete();

            $table->foreignId('question_id')->constrained();

            $table->foreignId('option_id')->nullable()->constrained();

            $table->boolean('is_correct')->nullable();

            $table->integer('time_taken')->nullable(); // ثانیه
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};
