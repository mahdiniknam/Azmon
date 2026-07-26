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
        Schema::create('otps', function (Blueprint $table) {
            $table->id();
            
            // تغییر از user_id به authenticatable (Polymorphic)
            $table->unsignedBigInteger('authenticatable_id');
            $table->string('authenticatable_type'); // App\Models\User یا App\Models\Admin
            
            $table->string('code');
            $table->string('type'); // register, login, forgetpass, admin_login, etc.
            $table->timestamp('expires_at');
            $table->boolean('used')->default(false);
            $table->timestamps();

            // ایندکس برای جستجوی سریع‌تر
            $table->index(['authenticatable_type', 'authenticatable_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('otps');
    }
};
