<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvtReceivedItemHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invt_received_item_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('master_received_id',false,10);
            $table->foreign('master_received_id')->references('id')->on('invt_master_received_items');
            $table->integer('inventory_id',false,10)->nullable();
            $table->foreign('inventory_id')->references('id')->on('master_inventories');

            $table->integer('item_id',false,10);
            $table->foreign('item_id')->references('id')->on('inventory_items');

            $table->float('received_qty',8,2)->nullable();
            $table->float('cost_price',9,2)->nullable();
            $table->float('item_total',10,2)->nullable();

            $table->integer('storage_id',false,10);
            $table->foreign('storage_id')->references('id')->on('storages');

            $table->integer('storage_block_id',false,10);
            $table->foreign('storage_block_id')->references('id')->on('storage_blocks');

            $table->integer('storage_block_self_id',false,10);
            $table->foreign('storage_block_self_id')->references('id')->on('self_of_storage_blocks');
            $table->float('available_qty',10,2)->nullable();
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
        Schema::dropIfExists('invt_received_item_histories');
    }
}
