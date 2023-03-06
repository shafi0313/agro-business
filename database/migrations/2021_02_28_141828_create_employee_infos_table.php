<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('status',4)->nullable();
            $table->string('f_name',100);
            $table->string('m_name',100);
            $table->foreignId('employee_main_cat_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('job_loc',155)->nullable();
            $table->date('d_o_b');
            $table->bigInteger('nid');
            $table->string('blood',8)->nullable();
            $table->enum('m_status',['1','2'])->comment('1=marid,2=unmarid');
            $table->string('c_phone',30)->nullable();

            $table->foreignId('bank_list_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('ac_name',80);
            $table->string('ac_no',80);
            $table->string('cheque_no',80)->nullable();
            $table->string('branch',100);

            $table->date('j_date');
            $table->string('place',100)->nullable();
            $table->string('g_name',100)->nullable();
            $table->bigInteger('g_phone')->nullable();
            $table->string('relation',100)->nullable();
            $table->string('p_address')->nullable();

            $table->decimal('basic_pay',8,2)->nullable();
            $table->decimal('house_rent',8,2)->nullable();
            $table->decimal('medical_a',8,2)->nullable();
            $table->decimal('p_i_bill',8,2)->nullable();
            $table->decimal('e_bonus',8,2)->nullable();
            $table->decimal('o_l_maintain',8,2)->nullable();
            $table->decimal('dearness_a',8,2)->nullable();
            $table->decimal('travel_a',8,2)->nullable();
            $table->decimal('ad_salary',8,2)->nullable();
            $table->decimal('insentive',8,2)->nullable();
            $table->decimal('festival_bonus',8,2)->nullable();
            $table->decimal('total',8,2)->nullable();
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
        Schema::dropIfExists('employee_infos');
    }
}
