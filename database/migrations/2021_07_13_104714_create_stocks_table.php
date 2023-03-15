<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->string('tran_id', 64)->index()->nullable();
            $table->bigInteger('inv_id')->nullable();
            $table->tinyInteger('stock_type')->comment('1=store,2=bulk');
            $table->tinyInteger('type')->comment('1=cash,3=credit,4=sample,11=production');
            $table->bigInteger('challan_no')->nullable();
            $table->foreignId('product_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('product_pack_size_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->integer('quantity');
            $table->integer('bonus')->nullable();
            $table->integer('net_weight')->nullable();
            $table->integer('use_weight')->nullable();
            $table->decimal('amt',12,2)->nullable();
            $table->decimal('dis',12,2)->nullable();
            $table->decimal('net_amt',12,2)->nullable();
            $table->date('date')->nullable();
            $table->boolean('inv_cancel')->default(0);
            $table->boolean('stock_close')->default(0);
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
        Schema::dropIfExists('stocks');
    }
}
