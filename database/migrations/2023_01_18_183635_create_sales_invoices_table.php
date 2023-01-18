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
        Schema::create('sales_invoices', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('invoice_number');
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->dateTime('date');
            $table->string('payment_type');
            $table->string('payment_status');
            $table->integer('discount')->nullable();
            $table->string('receipt')->nullable();
            $table->longText('invoice_notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_invoices');
    }
};
