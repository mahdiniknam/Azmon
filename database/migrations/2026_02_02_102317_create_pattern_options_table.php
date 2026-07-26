<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pattern_options', function (Blueprint $table) {
            $table->id();

            $table->string('key')->index();                // مثلا: ticket_created
            $table->enum('type', ['sms', 'email'])->index();
            $table->string('locale', 10)->default('fa')->index(); // fa/en
            $table->longText('value')->nullable();         // متن template
            $table->string('description')->nullable();     // توضیح برای ادمین

            $table->timestamps();

            $table->unique(['key', 'type', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pattern_options');
    }
};
