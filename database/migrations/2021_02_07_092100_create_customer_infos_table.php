<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->tinyInteger('type');
            $table->string('business_name')->nullable();
            $table->integer('credit_limit')->nullable();
            $table->string('nominee_name')->nullable();
            $table->integer('nominee_phone')->nullable();
            $table->string('relation')->nullable();
            $table->text('shop_address')->nullable();
            $table->decimal('opening_bl',12,2)->nullable();
            $table->string('note')->nullable();
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
        Schema::dropIfExists('customer_infos');
    }
}
