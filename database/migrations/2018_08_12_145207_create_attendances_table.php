<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_attendances', function (Blueprint $table) {
            $table->increments('id');
            $table->date('attendance_date');
            $table->tinyInteger('attendance')->comment('1=Present, 0=Absence, 2=Leave')->default(0);
            $table->tinyInteger('day_status')->comment('1=Working Day, 0=Off Day')->default(1);
            $table->time('in_time')->nullable();
            $table->time('out_time')->nullable();
            $table->string('late_in')->nullable();
            $table->string('early_out')->nullable();
            $table->string('late')->nullable();
            $table->string('overtime')->nullable();
            $table->unsignedInteger('employee_id',false);
            $table->foreign('employee_id')->references('id')->on('hrm_employees');
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
        Schema::dropIfExists('attandances');
    }
}
