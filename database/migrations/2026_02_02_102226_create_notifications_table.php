<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('admin_id')->nullable()->constrained('admins')->nullOnDelete();

            // type ها: ["sms","email","internal"]
            $table->json('type')->nullable();

            $table->string('status')->default('active'); // active/inactive
            $table->boolean('read')->default(false);
            $table->timestamp('read_at')->nullable();

            $table->string('section')->default('normal'); // normal/tape/pop_up (اگر خواستی)

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
