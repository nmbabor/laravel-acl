<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryPurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_purchase_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vendor_id',false,11)->comment('Order to vendor');
            $table->foreign('vendor_id')->references('id')->on('inventory_vendors');
            $table->string('purchase_order_no',100);
            $table->timestamp('date_of_purchase_order')->nullable();
            $table->timestamp('date_of_shipment')->nullable();
            $table->text('billing_address')->nullable();
            $table->text('shipping_address')->nullable();
            $table->float('order_qty',8,2)->nullable();
            $table->float('sub_total',12,2)->nullable();
            $table->float('vat',8,2)->nullable();
            $table->float('shipping_charge',8,2)->nullable();
            $table->float('grand_total',12,2)->nullable();
            $table->float('paid_amount',12,2)->nullable();
            $table->float('due_amount',12,2)->nullable();
            $table->tinyInteger('order_status',false,2)->default(1)->comment('1=Pending, 2=cancel,3=Approved 4=On the way, 5=Total Received, 6=Partial Received ,7=Partial Paid,8=Totally Paid ');
            $table->text('item_specification')->nullable();
            $table->tinyInteger('priority',false,1)->default(3)->comment('1=High,2=Medium,3=Normall');
            $table->text('notes')->nullable()->comment('Purchase order notes');
            $table->string('reference',150)->nullable();
            $table->string('order_qr_code',250)->nullable();
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
        Schema::dropIfExists('inventory_purchase_orders');
    }
}
