<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDetailpenjualan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detailpenjualan', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_transaksipenjualan')->unsigned();
            $table->integer('id_produk')->unsigned();
            $table->integer('jumlah');
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
        Schema::drop('detailpenjualan');
    }
}
