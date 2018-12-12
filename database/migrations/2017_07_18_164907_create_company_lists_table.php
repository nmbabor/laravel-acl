<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (Schema::hasTable('company_list')==false) {
            Schema::create('company_list', function (Blueprint $table) {
                $table->increments('id');
                $table->string('company_name',255);
                $table->string('logo',60);
                $table->string('address',255);
                $table->string('shipping_address',255);
                $table->string('mobile_no',20);
                $table->string('email',70);
                $table->string('favicon',50)->nullable();
                $table->tinyInteger('status',false,1);
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
        Schema::dropIfExists('company_lists');
    }
}
