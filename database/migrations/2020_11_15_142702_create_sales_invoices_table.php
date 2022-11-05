<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesInvoicesTable extends Migration
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
            $table->foreignId('user_id')->nullable()->constrained()->onUpdate('cascade');
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('invoice_no');
            $table->string('challan_no');
            $table->tinyInteger('inv_cancel')->default(0)->comment('1=Cancel,2=Reinvoice');
            $table->tinyInteger('type')->comment('1=Cash,3=Credit,5=sample');
            $table->tinyInteger('r_type')->nullable()->comment('1=expired,2=unsold,3=damage');
            $table->unsignedBigInteger('size')->comment('Weight/id');;
            $table->foreign('size')->references('id')->on('product_pack_sizes')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('quantity')->default(0);
            $table->integer('bonus')->nullable();
            $table->float('pro_dis')->nullable();
            $table->decimal('rate_per_qty',14,2);
            $table->decimal('amt',14,2)->default(0);
            $table->date('invoice_date');
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
        Schema::dropIfExists('sales_invoices');
    }
}
