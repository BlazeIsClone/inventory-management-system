<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_bill_raw_products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('raw_product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('purchase_bill_id')->constrained()->cascadeOnDelete();
            $table->integer('product_quantity');
            $table->integer('product_price');
            $table->integer('product_total');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_bill_raw_products');
    }
};
