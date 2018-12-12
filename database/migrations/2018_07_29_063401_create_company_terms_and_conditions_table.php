<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyTermsAndConditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_terms_and_conditions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('condition_type',false,4)->comment('1=purchase order,2=purchase return, 3=sales,4=sales return,5=hr, 6=payroll,7=Transfer Item');
            $table->string('condition_title',200);
            $table->text('condition_details')->nullable();
            $table->string('condition_status')->default(1)->comment('1=Active, 0=Inactive');
            $table->author();
            $table->unsignedInteger('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('company_list');
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
        Schema::dropIfExists('company_terms_and_conditions');
    }
}
