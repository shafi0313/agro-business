<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipmentPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment_purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onUpdate('cascade');
            $table->unsignedBigInteger('supplier_id');
            $table->foreign('supplier_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('size')->comment('Weight/id');;
            $table->foreign('size')->references('id')->on('product_pack_sizes')->onUpdate('cascade')->onDelete('cascade');
            // $table->string('size')->comment('Weight/id');
            $table->string('invoice_no')->nullable();
            $table->string('challan_no')->nullable();
            $table->tinyInteger('type')->comment('1=Label');
            $table->tinyInteger('status');
            $table->tinyInteger('tracking')->nullable();
            $table->string('batch_no')->nullable();
            $table->integer('quantity')->default(0);
            $table->integer('bonus')->nullable();
            $table->decimal('rate_per_qty',14,2)->nullable();
            $table->decimal('net_weight',14,2)->nullable();
            $table->decimal('amt',14,2)->default(0);
            $table->date('invoice_date');
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
        Schema::dropIfExists('equipment_purchases');
    }
}
