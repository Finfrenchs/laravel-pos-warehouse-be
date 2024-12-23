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
        Schema::create('order_draft_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_draft_id');
            $table->foreign('order_draft_id')->references('id')->on('order_drafts')->onDelete('cascade');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            //quantity of product
            $table->integer('quantity');
            //price of product
            $table->decimal('price', 15, 2);
            //total price of product
            $table->decimal('total', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_draft_items');
    }
};
