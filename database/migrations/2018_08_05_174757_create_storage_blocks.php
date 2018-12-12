<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStorageBlocks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storage_blocks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('storage_id',false,10);
            $table->foreign('storage_id')->references('id')->on('storages');
            $table->string('block_name',150)->unique();
            $table->text('details')->nullable();
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
        //
    }
}
