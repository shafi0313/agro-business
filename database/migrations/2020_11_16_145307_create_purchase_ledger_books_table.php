<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseLedgerBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_ledger_books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onUpdate('cascade');
            $table->unsignedBigInteger('supplier_id');
            $table->foreign('supplier_id')->references('id')->on('users')->onUpdate('cascade');
            $table->unsignedBigInteger('prepared_id');
            $table->foreign('prepared_id')->references('id')->on('users')->onUpdate('cascade');
            $table->unsignedBigInteger('account_id')->nullable();
            $table->foreign('account_id')->references('id')->on('accounts')->onUpdate('cascade');
            $table->tinyInteger('type')->comment('1=Cash,3=Credit,5=Pmt');
            $table->string('invoice_no')->nullable();
            $table->string('challan_no')->nullable();
            $table->decimal('purchase_amt',14,2)->default(0);
            $table->decimal('discount',6,2)->nullable();
            $table->decimal('net_amt',14,2)->nullable();
            $table->decimal('payment',14,2)->nullable();
            $table->string('user_type')->nullable();
            $table->date('invoice_date')->nullable();
            $table->date('payment_date')->nullable();
            $table->date('delivery_date')->nullable();
            $table->unsignedBigInteger('production_id');
            $table->boolean('inv_cancel')->default(0);
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
        Schema::dropIfExists('purchase_ledger_books');
    }
}
