<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('tmm_so_id')->nullable();
            $table->foreign('tmm_so_id')->references('id')->on('users')->onUpdate('cascade');
            $table->unsignedBigInteger('user_bank_ac_id')->nullable();
            $table->boolean('exp_type')->nullable()->comment('1=Office,2=auhor,3=other,exp/income');
            $table->foreignId('office_expense_cat_id')->comment('exp/income')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->enum('type',['1','2'])->comment('1=cash,2=Bank');
            $table->enum('ac_type',['1','2'])->comment('1=debit,2=credit');
            $table->tinyInteger('trn_type')->comment('1=pymnt,2=rec');
            $table->boolean('pay_type')->default(0)->comment('1=cash,3=credit');
            $table->decimal('debit',14,2)->default(0);
            $table->decimal('credit',14,2)->default(0);
            $table->string('note')->nullable();
            $table->string('payment_by',80)->nullable();
            $table->date('m_r_date')->nullable();
            $table->integer('m_r_no')->nullable();
            $table->integer('cheque_no')->nullable();
            $table->date('date');
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
        Schema::dropIfExists('accounts');
    }
}
