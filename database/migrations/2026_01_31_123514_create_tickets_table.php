<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // morphs خودش index می‌سازه
            $table->morphs('creator');

            $table->foreignId('admin_id')->nullable()->constrained('admins')->nullOnDelete();

            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();

            $table->string('title');
            $table->longText('description')->nullable();

            $table->string('status')->default('new');
            $table->unsignedTinyInteger('priority')->default(2);

            $table->timestamp('seen_at')->nullable();
            $table->boolean('star')->default(false);

            $table->softDeletes();
            $table->timestamps();

            $table->index(['status', 'priority']);
            $table->index(['department_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
