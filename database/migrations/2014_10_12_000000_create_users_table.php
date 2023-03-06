<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('tmm_so_id',80)->nullable();
            $table->string('name',100)->nullable();
            $table->string('email')->unique()->nullable();
            $table->tinyInteger('role')->default(0)->comment('1=Admin,2=Customer,3=Supplier	');
            $table->tinyInteger('is_')->default(0)->comment('1=Admin');
            $table->tinyInteger('age')->nullable();
            $table->string('phone',30)->nullable();
            $table->string('business_name')->nullable();
            $table->text('address')->nullable();
            $table->text('shop_address')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            // $table->foreignId('current_team_id')->nullable();
            $table->text('profile_photo_path')->nullable();
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
        Schema::dropIfExists('users');
    }
}
