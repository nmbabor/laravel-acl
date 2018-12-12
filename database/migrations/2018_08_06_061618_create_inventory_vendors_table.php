<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_vendors', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('vendor_is',false,1)->comment('1=Company, 2=Person');
            $table->string('vendor_name',200);
            $table->string('vendorid',100)->unique();
            $table->tinyInteger('vendor_type',false,1)->nullable()->comment('General / Special Vendor');
            $table->integer('category_id',false,5)->nullable()->comment('Product/Item category determine vendor category');
            $table->string('nid_no',50)->nullable();
            $table->string('trade_licence_no',50)->nullable();
            $table->string('vat_id',50)->nullable();
            $table->string('income_tax_id',50)->nullable();
            $table->string('primary_item',200)->nullable();
            $table->string('secondary_item',200)->nullable();
            $table->text('supply_item_details')->nullable();
            $table->text('office_address')->nullable();
            $table->text('storage_address')->nullable();
            $table->string('mobile_1',20)->unique();
            $table->string('mobile_2',20)->nullable();
            $table->string('phone',20)->nullable();
            $table->string('fax',50)->nullable();
            $table->string('email_1',150)->nullable();
            $table->string('email_2',150)->nullable();
            $table->string('Skype',100)->nullable();
            $table->string('facebook',200)->nullable();
            $table->string('representative_name',150)->nullable();
            $table->string('representative_designation',150)->nullable();
            $table->string('representative_mobile',20)->nullable();
            $table->string('representative_phone',20)->nullable();
            $table->string('representative_email',20)->nullable();
            $table->string('representative_skype',100)->nullable();
            $table->tinyInteger('status',false,1)->default(1);
            $table->string('vendor_img',200)->nullable();
            $table->string('nid_img',200)->nullable();
            $table->string('trade_licence_img',200)->nullable();
            $table->string('vat_img',200)->nullable();
            $table->string('income_tax_img',200)->nullable();
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
        Schema::dropIfExists('inventory_vendors');
    }
}
