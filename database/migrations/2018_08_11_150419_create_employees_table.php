<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_employees', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id',false);
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('photo',50)->nullable();
            $table->string('designation',20);
            $table->string('employee_id',20)->unique();
            $table->unsignedInteger('section_id',false);
            $table->foreign('section_id')->references('id')->on('hrm_employee_sections');
            $table->float('basic_pay');
            $table->float('house_rent')->nullable();
            $table->float('medical_allowance')->nullable();
            $table->tinyInteger('status',false)->default(1);
            $table->author();
            $table->companyBranch();
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
        Schema::dropIfExists('employees');
    }
}
