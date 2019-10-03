<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('header_id');
            $table->string('item_name','255');
            $table->integer('order_num');
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
        Schema::table('t_items', function (Blueprint $table) {
            Schema::dropIfExists('t_items');
        });
    }
}
