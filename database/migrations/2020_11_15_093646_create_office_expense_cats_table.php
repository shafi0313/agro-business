<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficeExpenseCatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('office_expense_cats', function (Blueprint $table) {
            $table->id();
            $table->boolean('type')->comment('1=Expense,2=Income');
            $table->boolean('exp_or_in_type')->comment('1=Office,2=Author,3=Other');
            $table->string('name');
            $table->string('parent_id')->default(0);
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
        Schema::dropIfExists('office_expense_cats');
    }
}
