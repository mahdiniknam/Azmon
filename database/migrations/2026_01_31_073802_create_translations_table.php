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
        Schema::create('translations', function (Blueprint $table) {
            $table->id();

            // مدل/آیتمی که ترجمه بهش وصل میشه (پلی‌مورفیک)
            $table->string('translatable_type'); // مثل App\Models\Department
            $table->unsignedBigInteger('translatable_id');

            // کدام فیلد ترجمه میشه؟
            $table->string('field'); // مثل title, description, body

            // زبان
            $table->string('locale', 10); // fa, en, ar ...

            // مقدار ترجمه
            $table->longText('value')->nullable();

            $table->timestamps();

            $table->index(['translatable_type', 'translatable_id']);
            $table->unique(['translatable_type', 'translatable_id', 'field', 'locale'], 'uniq_translation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('translations');
    }
};
