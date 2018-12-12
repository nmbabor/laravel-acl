<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSelfOfStorageBlocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('self_of_storage_blocks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('storage_block_id',false,10);
            $table->foreign('storage_block_id')->references('id')->on('storage_blocks');
            $table->string('self_of_block',100);
            $table->tinyInteger('status',false,1)->default(1);
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
        Schema::dropIfExists('self_of_storage_blocks');
    }
}
