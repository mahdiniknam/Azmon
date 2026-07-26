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
        Schema::create('blocked_ips', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 45)->unique(); // پشتیبانی از IPv4 و IPv6
            $table->enum('type', ['temporary', 'permanent'])->default('temporary');
            $table->text('description')->nullable();
            $table->timestamp('starts_at')->useCurrent();
            $table->timestamp('expires_at')->nullable(); // برای دائمی‌ها NULL می‌ماند
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // ایندکس برای سرعت بالاتر در جستجوی ای‌پی‌ها
            $table->index(['ip_address', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blocked_ips');
    }
};
