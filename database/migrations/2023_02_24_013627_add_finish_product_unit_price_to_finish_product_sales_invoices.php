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
        Schema::table('finish_product_sales_invoices', function (Blueprint $table) {
            $table->integer('finish_product_unit_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('finish_product_sales_invoices', function (Blueprint $table) {
            $table->dropColumn('finish_product_unit_price');
        });
    }
};
