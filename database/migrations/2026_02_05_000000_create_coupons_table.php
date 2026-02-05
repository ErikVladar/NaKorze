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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->decimal('discount_amount', 8, 2)->default(0);
            $table->integer('discount_percent')->default(10); // 10% default
            $table->date('valid_from');
            $table->date('valid_until');
            $table->boolean('is_redeemed')->default(false);
            $table->timestamp('redeemed_at')->nullable();
            $table->foreignId('personal_information_id')->constrained('personal_information')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
