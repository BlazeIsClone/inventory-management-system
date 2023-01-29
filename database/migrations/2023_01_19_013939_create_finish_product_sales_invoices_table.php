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
        Schema::create('finish_product_sales_invoices', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('sales_invoice_id')->constrained()->cascadeOnDelete();
            $table->foreignId('finish_product_id')->constrained()->cascadeOnDelete();
            $table->integer('finish_product_quantity');
            $table->integer('finish_product_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('finish_product_sales_invoices');
    }
};
