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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->enum('payment_method', ['bank_transfer', 'online_transfer']);
            
            // For bank transfer
            $table->string('receipt_pdf')->nullable();
            
            // For online transfer
            $table->string('card_number')->nullable();
            $table->string('exp_date')->nullable();
            $table->string('cvv')->nullable();
            $table->string('card_holder_name')->nullable();
            
            $table->enum('status', ['pending', 'confirmed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
