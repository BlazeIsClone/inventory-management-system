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
        Schema::create('raw_product_finish_products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('raw_product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('finish_product_id')->constrained()->cascadeOnDelete();
            $table->integer('raw_product_quantity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('finish_product_raw_products');
    }
};
