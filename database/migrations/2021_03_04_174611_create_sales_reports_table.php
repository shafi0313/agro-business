<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_reports', function (Blueprint $table) {
            $table->id();
            $table->enum('type',['1','2'])->nullable();
            $table->foreignId('sales_ledger_book_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->tinyInteger('inv_type')->nullable()->comment('1=Cash,3=Credit');
            $table->boolean('pay_type')->default(0)->comment('1=cash,3=credit');
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate();
            $table->unsignedBigInteger('zsm_id')->nullable();
            $table->foreign('zsm_id')->references('id')->on('users')->onUpdate('cascade');
            $table->unsignedBigInteger('sso_id')->nullable();
            $table->foreign('sso_id')->references('id')->on('users')->onUpdate('cascade');
            $table->unsignedBigInteger('so_id')->nullable();
            $table->foreign('so_id')->references('id')->on('users')->onUpdate('cascade');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->date('invoice_date')->nullable();
            $table->decimal('amt',14,2)->nullable();
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
        Schema::dropIfExists('sales_reports');
    }
}
