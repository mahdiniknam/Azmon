<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();

            // Polymorphic relation
            $table->morphs('fileable'); // fileable_id + fileable_type

            // File info
            $table->string('disk')->default('public');
            $table->string('path'); // storage path (مثلاً: uploads/tickets/xx.jpg)
            $table->string('original_name')->nullable();
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('size')->nullable();

            // Optional meta
            $table->string('collection')->nullable(); // مثلا: avatar, attachment, gallery
            $table->unsignedInteger('sort_order')->default(0);

            // uploader (اختیاری ولی خیلی کاربردی)
            $table->nullableMorphs('uploaded_by'); // uploaded_by_id + uploaded_by_type

            $table->timestamps();

            $table->index(['fileable_type', 'fileable_id', 'collection']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};

