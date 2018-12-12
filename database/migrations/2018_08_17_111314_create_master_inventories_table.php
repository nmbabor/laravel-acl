<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_inventories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('item_id',false,10);
            $table->foreign('item_id')->references('id')->on('inventory_items');
            $table->integer('model_id',false,10)->nullable();
            $table->float('available_qty',10,2)->nullable();
            $table->float('cost_price',10,2)->nullable();
            $table->float('sale_price',10,2)->nullable();
            $table->integer('storage_id',false,10)->nullable();
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
        Schema::dropIfExists('master_inventories');
    }
}
