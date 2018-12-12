<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('users')==false) {
            Schema::create('users', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('email')->unique();
                $table->string('password');
                $table->string('phone_number',20)->unique();
                $table->string('address',255)->nullable();
                $table->unsignedInteger('company_id')->nullable();
                $table->unsignedInteger('branch_id')->nullable();
                $table->foreign('company_id')->references('id')->on('company_list');
                $table->foreign('branch_id')->references('id')->on('company_branches');
                $table->unsignedInteger('created_by')->nullable();
                $table->tinyInteger('status')->default('1');
                $table->rememberToken();
                $table->timestamps();

            });
        }
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
