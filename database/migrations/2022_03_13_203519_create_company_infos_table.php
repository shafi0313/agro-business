<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_infos', function (Blueprint $table) {
            $table->id();
            $table->string('name',100);
            $table->string('phone',191);
            $table->string('email',191)->nullable();
            $table->string('address',255)->nullable();
            $table->string('web',80);
            $table->string('logo',30)->nullable();
            $table->string('favicon',30)->nullable();
            $table->boolean('email_service')->default(0)->comment('1=Enable');
            $table->boolean('sms_service')->default(0)->comment('1=Enable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_infos');
    }
}
