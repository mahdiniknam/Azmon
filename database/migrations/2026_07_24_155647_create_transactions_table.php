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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->morphs('user'); // استاد یا دانشجو (پلیمورفیک)
            $table->string('amount');
            $table->enum('type', ['deposit', 'withdraw']); // واریز به کیف پول یا برداشت برای خرید آزمون
            $table->string('tracking_code')->nullable(); // کد پیگیری درگاه
            $table->foreignId('exam_id')->nullable()->constrained()->onDelete('set null');
            $table->string('gateway')->nullable(); // مثلا Zarinpal, Mellat
            $table->boolean('status')->default(false); // موفق یا ناموفق
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
