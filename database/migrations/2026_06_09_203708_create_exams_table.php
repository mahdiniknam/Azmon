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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();

            $table->enum('type', ['single', 'multi'])->default('single');

            $table->integer('duration');

            $table->date('start_date');
            $table->time('start_time');
            $table->date('end_date');
            $table->time('end_time');

            $table->float('negative_score')->default(0.33);

            $table->boolean('shuffle_questions')->default(true);
            $table->boolean('shuffle_options')->default(true);

            $table->nullableMorphs('created_by');

            $table->string('price')->default(0); // هزینه به تومان/ریال
            $table->enum('payment_type', ['student', 'creator'])->default('student');
            $table->integer('max_participants')->nullable(); // سقف شرکت‌کنندگان
            $table->boolean('is_paid')->default(false); // آیا هزینه آزمون توسط استاد پرداخت شده؟ (اگر نوع پرداخت creator باشد)
            $table->boolean('is_public')->default(true);

            $table->foreignId('teacher_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
