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
        Schema::create('purchase_bills', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('vendor_id')->constrained()->cascadeOnDelete();
            $table->foreignId('raw_product_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('price');
            $table->date('purchase_date');
            $table->string('payment_bill')->nullable();
            $table->string('payment_bill_note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_bills');
    }
};
