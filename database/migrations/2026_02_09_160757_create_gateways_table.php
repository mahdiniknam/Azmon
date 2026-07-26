<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('gateways', function (Blueprint $table) {
            $table->id();

            $table->string('title', 191);
            $table->string('driver', 50); // zarinpal / idpay / ...
            $table->json('config')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes('deleted_at');

            $table->index(['driver', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gateways');
    }
};
