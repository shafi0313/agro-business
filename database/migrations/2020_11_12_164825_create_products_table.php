<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cat_id')->nullable();
            $table->foreign('cat_id')->references('id')->on('product_cats')->onUpdate('cascade')->onDelete('cascade');
            // $table->foreignId('product_cat_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->tinyInteger('type')->comment('1=product,2=raw');
            $table->string('name',100)->nullable();
            $table->string('generic',100)->nullable();
            $table->longText('indications')->nullable();
            // $table->text('dosage')->nullable();
            // $table->string('quantity')->nullable();
            // $table->string('origin')->nullable();
            $table->string('image')->nullable();
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
        Schema::dropIfExists('products');
    }
}
