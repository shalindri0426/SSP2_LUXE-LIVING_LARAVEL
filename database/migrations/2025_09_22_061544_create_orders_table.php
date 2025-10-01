<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('products'); // Store cart items as JSON text
            $table->decimal('total_amount', 10, 2);
            $table->text('delivery_address');
            $table->string('delivery_phone');
            $table->string('delivery_name');
            $table->text('special_instructions')->nullable();
            $table->enum('order_status', ['order pending', 'confirmed'])->default('order pending');
            $table->enum('payment_status', ['pending', 'payment confirmed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
