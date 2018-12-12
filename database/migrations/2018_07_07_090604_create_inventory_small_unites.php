<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventorySmallUnites extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_small_units', function (Blueprint $table) {
            $table->increments('id');
            $table->string('unit_name',200)->nullable();
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('inventory_small_units');
    }
}
