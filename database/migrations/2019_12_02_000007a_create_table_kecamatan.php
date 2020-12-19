<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableKecamatan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kecamatan', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_kota')->unsigned();
            $table->string('namakecamatan');
            $table->timestamps();
        });
        Schema::table('alamat', function(Blueprint $table) {
            $table->foreign('id_kecamatan')
                ->references('id')
                ->on('kecamatan')
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
            $table->dropForeign('alamat_id_kecamatan_foreign');
        });
        Schema::drop('kecamatan');
    }
}
