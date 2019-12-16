<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableKonfirmasi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('konfirmasi', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_transaksipenjualan')->unsigned();
            $table->string('nama');
            $table->string('bank');
            $table->string('norekening');
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
        Schema::drop('konfirmasi');
    }
}
