<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProvinsi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provinsi', function (Blueprint $table) {
            $table->increments('id');
            $table->string('namaprovinsi');
            $table->timestamps();
        });
        Schema::table('kota', function(Blueprint $table) {
            $table->foreign('id_provinsi')
                ->references('id')
                ->on('provinsi')
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
        Schema::table('kota', function(Blueprint $table) {
            $table->dropForeign('kota_id_provinsi_foreign');
        });
        Schema::drop('provinsi');
    }
}
