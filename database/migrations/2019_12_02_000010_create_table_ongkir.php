<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableOngkir extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ongkir', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('destination');
            $table->string('cityname');
            $table->string('service');
            $table->double('costs');
            $table->string('estimate');
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
        Schema::drop('ongkir');
    }
}
