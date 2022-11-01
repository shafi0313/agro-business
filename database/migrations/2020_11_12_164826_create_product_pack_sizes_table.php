<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductPackSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_pack_sizes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            // $table->unsignedBigInteger('size')->comment('Weight/id');;
            // $table->foreign('size')->references('id')->on('pack_sizes')->onUpdate('cascade')->onDelete('cascade');
            $table->tinyInteger('type');
            $table->string('size');
            $table->decimal('purchase',8,2)->nullable();
            $table->decimal('cash',8,2)->nullable();
            $table->decimal('credit',8,2)->nullable();
            $table->decimal('trade_price',8,2)->nullable();
            $table->decimal('mrp',8,2)->nullable();
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
        Schema::dropIfExists('product_pack_sizes');
    }
}
