<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductionCalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('production_cals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('size');
            $table->foreign('size')->references('id')->on('product_pack_sizes')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('pur_inv_id')->references('id')->on('purchase_invoices')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('pur_inv_id');
            $table->unsignedBigInteger('production_id');
            $table->string('challan_no')->nullable();
            $table->integer('quantity');
            $table->unsignedBigInteger('production_id');
            $table->integer('use_weight')->nullable();
            $table->boolean('inv_cancel')->default(0);
            $table->date('date')->nullable();
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
        Schema::dropIfExists('production_cals');
    }
}
