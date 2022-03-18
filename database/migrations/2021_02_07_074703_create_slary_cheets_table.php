<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlaryCheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slary_cheets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('employee_info_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->decimal('basic_pay',12,2);
            $table->decimal('house_rent',8,2);
            $table->decimal('medical_a',8,2);
            $table->decimal('p_i_bill',8,2);
            $table->decimal('e_bonus',8,2)->nullable();
            $table->decimal('o_l_main',8,2)->nullable();
            $table->decimal('g_salary',12,2);
            $table->decimal('f_main',8,2)->nullable();
            $table->decimal('da',8,2)->nullable();
            $table->decimal('d_salary',12,2)->nullable();
            $table->decimal('net_pay',12,2);
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
        Schema::dropIfExists('slary_cheets');
    }
}
