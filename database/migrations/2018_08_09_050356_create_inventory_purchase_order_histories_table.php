<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryPurchaseOrderHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_purchase_order_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('inventory_purchase_order_id',false,10);
            $table->foreign('inventory_purchase_order_id','purchase_order_id_with_order_history')->references('id')->on('inventory_purchase_orders');
            $table->integer('inventory_item_id',false,10);
            $table->foreign('inventory_item_id')->references('id')->on('inventory_items');
            $table->text('item_specification')->nullable();
            $table->float('item_order_qty',8,2)->nullable();
            $table->float('item_price',10,2)->nullable();
            $table->float('item_total',10,2)->nullable();
            $table->float('received_qty',8,2)->default(0)->comment('This field used(update) for item received');
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
        Schema::dropIfExists('inventory_purchase_order_histories');
    }
}
