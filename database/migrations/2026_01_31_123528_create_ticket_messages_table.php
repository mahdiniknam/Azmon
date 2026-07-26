<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ticket_messages', function (Blueprint $table) {
            $table->id();

            $table->foreignId('ticket_id')->constrained()->cascadeOnDelete();

            // فرستنده پیام (admin یا user)
            $table->morphs('user'); // user_type + user_id

            $table->longText('message');

            $table->string('status')->default('not_seen');
            $table->timestamp('seen_at')->nullable();

            $table->string('from')->nullable(); // admin/user (برای UI)

            $table->softDeletes();
            $table->timestamps();

            $table->index(['ticket_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_messages');
    }
};
