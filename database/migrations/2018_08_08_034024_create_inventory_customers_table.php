<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_customers', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('customer_is',false,1);
            $table->string('customer_name',150);
            $table->string('customer_id',100)->unique();
            $table->string('gender',20)->nullable();
            $table->tinyInteger('customer_type',false,2)->nullable()->comment('1=Regular, 2=Irregular');
            $table->string('religion',25)->nullable();
            $table->text('present_address')->nullable();
            $table->text('permanent_address')->nullable();
            $table->text('shipping_address')->nullable();
            $table->string('mobile',12)->unique();
            $table->string('phone',12)->nullable();
            $table->string('email',150)->nullable();
            $table->string('facebook',150)->nullable();
            $table->string('nit_no',40)->nullable();
            $table->string('city',50)->nullable();
            $table->string('region',150)->nullable();
            $table->string('zip_code',50)->nullable();
            $table->string('customer_img',200)->nullable();
            $table->string('nid_img',200)->nullable();
            $table->tinyInteger('status',false,1)->default(1);
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
        Schema::dropIfExists('inventory_customers');
    }
}
