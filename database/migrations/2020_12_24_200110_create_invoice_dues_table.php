<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceDuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_dues', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no');
            $table->date('inv_date');
            $table->decimal('inv_amt',14,2);
            $table->decimal('inv_payment',14,2);
            $table->decimal('inv_total',14,2);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_dues');
    }
}
