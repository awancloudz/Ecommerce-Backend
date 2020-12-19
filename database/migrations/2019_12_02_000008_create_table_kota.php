<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableKota extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kota', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_provinsi')->unsigned();
            $table->string('namakota');
            $table->timestamps();
        });
        Schema::table('alamat', function(Blueprint $table) {
            $table->foreign('id_kota')
                ->references('id')
                ->on('kota')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        Schema::table('kecamatan', function(Blueprint $table) {
            $table->foreign('id_kota')
                ->references('id')
                ->on('kota')
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
        Schema::table('alamat', function(Blueprint $table) {
            $table->dropForeign('alamat_id_kota_foreign');
        });
        Schema::table('kecamatan', function(Blueprint $table) {
            $table->dropForeign('kecamatan_id_kota_foreign');
        });
        Schema::drop('kota');
    }
}
