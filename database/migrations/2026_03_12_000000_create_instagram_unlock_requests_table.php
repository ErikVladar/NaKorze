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
        Schema::create('instagram_unlock_requests', function (Blueprint $table) {
            $table->id();
            $table->string('unlock_token', 64)->unique();
            $table->string('status', 30)->default('pending');
            $table->string('email')->nullable();
            $table->string('instagram_username')->nullable();
            $table->string('igsid')->nullable();
            $table->boolean('is_following')->nullable();
            $table->timestamp('last_event_at')->nullable();
            $table->timestamp('unlocked_at')->nullable();
            $table->json('meta_payload')->nullable();
            $table->timestamps();

            $table->index(['status', 'unlocked_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instagram_unlock_requests');
    }
};
