<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_brands', function (Blueprint $table) {
            $table->increments('id');
            $table->string('brand_name')->nullable();
            $table->text('brand_description')->nullable();
            $table->tinyInteger('brand_status',false,1)->default(1);
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
        Schema::dropIfExists('inv_brands');
    }
}
