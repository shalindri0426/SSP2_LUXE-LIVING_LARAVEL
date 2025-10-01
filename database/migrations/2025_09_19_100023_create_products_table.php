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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId('category_id')
                ->constrained('categories')   // references id on categories table
                ->onDelete('cascade');   //deletes if the category is deleted
            $table->string('product_name');
            $table->string('image');
            $table->decimal('price');
            //$table->decimal('discount')->default(0);
            $table->text('description')->nullable();
            $table->string('material')->nullable();
            $table->string('colour')->nullable();
            $table->integer('stock')->default(0);
            //$table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
