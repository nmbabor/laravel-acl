<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvtMasterReceivedItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invt_master_received_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('voucher_no',150);
            $table->integer('purchase_order_id',false,10);
            $table->foreign('purchase_order_id')->references('id')->on('inventory_purchase_orders');
            $table->float('received_qty',9,2)->nullable();
            $table->float('sub_total',12,2)->nullable();
            $table->float('vat',8,2)->nullable();
            $table->float('shipping_charge',8,2)->nullable();
            $table->float('grand_total',12,2)->nullable();
            $table->timestamp('received_date')->nullable();
            $table->text('notes')->nullable();
            $table->string('reference',15)->nullable();
            $table->string('received_img',200)->nullable();
            $table->integer('received_by',false,10)->nullable();
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
        Schema::dropIfExists('invt_master_received_items');
    }
}
