<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseOrderTermsConditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_order_terms_conditions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('inventory_purchase_order_id',false,10);
            $table->integer('terms_conditions_id',false,10)->nullable();
            $table->foreign('terms_conditions_id')->references('id')->on('company_terms_and_conditions');
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
        Schema::dropIfExists('purchase_order_terms_conditions');
    }
}
