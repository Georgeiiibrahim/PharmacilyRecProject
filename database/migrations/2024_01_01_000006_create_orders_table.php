<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->onDelete('set null');
            $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('set null');
            $table->foreignId('site_id')->nullable()->constrained('sites')->onDelete('set null');
            $table->integer('units')->default(1);
            $table->decimal('revenue', 12, 2)->nullable();
            $table->string('type')->nullable(); // Product type/category
            $table->date('order_date')->nullable();
            $table->string('month')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('region')->nullable(); // Redundant, but for fast queries
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
}; 