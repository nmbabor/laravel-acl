<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('item_name');
            $table->string('item_code')->unique();
            $table->integer('category_id',false,10)->nullable();
            $table->foreign('category_id')->references('id')->on('item_categories');
            $table->integer('brand_id',false,10)->nullable();
            $table->foreign('brand_id')->references('id')->on('inv_brands');
            $table->integer('item_unite_id',false,10)->nullable();
            $table->foreign('item_unite_id')->references('id')->on('inventory_small_units');
            $table->integer('vendor_id',false,10)->nullable();
            $table->foreign('vendor_id')->references('id')->on('inventory_vendors');
            $table->float('cost_price',10,2)->comment('Default Cost Price')->nullable();
            $table->float('sale_price',10,2)->comment('Default Sale Price')->nullable();
            $table->integer('reorder_level',false,5)->nullable();
            $table->string('item_color',200)->nullable();
            $table->text('item_details')->nullable();
            $table->string('item_main_img')->nullable();
            $table->string('item_secondary_img')->nullable();
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
        Schema::dropIfExists('inventory_items');
    }
}
