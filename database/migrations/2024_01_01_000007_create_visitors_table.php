<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('page_url');
            $table->string('referrer_url')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('region')->nullable();
            $table->string('browser')->nullable();
            $table->string('device_type')->nullable(); // desktop, mobile, tablet
            $table->string('os')->nullable();
            $table->integer('time_spent')->nullable(); // in seconds
            $table->boolean('is_bounce')->default(true); // single page visit
            $table->boolean('is_returning')->default(false);
            $table->timestamp('visited_at');
            $table->timestamps();
            
            $table->index(['session_id']);
            $table->index(['visited_at']);
            $table->index(['page_url']);
            $table->index(['country', 'city']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
}; 