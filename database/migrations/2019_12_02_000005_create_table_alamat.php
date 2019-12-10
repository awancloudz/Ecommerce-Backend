<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAlamat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alamat', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_users')->unsigned();
            $table->integer('id_kota')->unsigned();
            $table->string('namaalamat');
            $table->string('nama');
            $table->text('alamat');
            $table->string('kodepos');
            $table->string('nohp');
            $table->enum('utama',['1','2']);
            $table->timestamps();
        });
        Schema::table('transaksipenjualan', function(Blueprint $table) {
            $table->foreign('id_alamat')
                ->references('id')
                ->on('alamat')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaksipenjualan', function(Blueprint $table) {
            $table->dropForeign('transaksipenjualan_id_alamat_foreign');
        });
        Schema::drop('alamat');
    }
}
