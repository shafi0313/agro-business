<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesLedgerBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_ledger_books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onUpdate('cascade');
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('users')->onUpdate('cascade');
            $table->unsignedBigInteger('prepared_id');
            $table->foreign('prepared_id')->references('id')->on('users')->onUpdate('cascade');
            $table->unsignedBigInteger('account_id')->nullable();
            $table->foreign('account_id')->references('id')->on('accounts')->onUpdate('cascade');
            $table->tinyInteger('type');
            $table->tinyInteger('inv_cancel')->default(0)->comment('1=Cancel,2=Reinvoice');
            $table->tinyInteger('r_type')->nullable()->comment('1=expired,2=unsold,3=damage');
            $table->string('invoice_no')->nullable();
            $table->string('challan_no')->nullable();
            $table->decimal('sales_amt',14,2)->default(0);
            $table->decimal('discount',6,2)->default(0)->nullable();
            $table->decimal('discount_amt',8,2)->default(0)->nullable();
            $table->decimal('net_amt',14,2)->default(0)->nullable();
            // $table->tinyInteger('p_status')->default(0);
            $table->tinyInteger('c_status')->default(0);
            // $table->boolean('inv_type')->default(0)->comment('1=cash,3=credit');
            $table->boolean('pay_type')->default(0)->comment('1=cash,3=credit');
            $table->decimal('payment',14,2)->nullable();
            $table->string('user_type')->nullable();
            $table->date('invoice_date')->nullable();
            $table->date('payment_date')->nullable();
            $table->date('delivery_date')->nullable();
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
        Schema::dropIfExists('sales_ledger_books');
    }
}
