<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTransaksipenjualan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksipenjualan', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kodetransaksi',30)->unique();
            $table->integer('id_users')->unsigned();
            $table->integer('id_alamat')->unsigned();
            $table->date('tanggal');
            $table->double('totaldiskon');
            $table->double('totalbelanja');
            $table->double('totalongkir');
            $table->double('subtotal');
            $table->string('kurir');
            $table->string('layanan');
            $table->enum('status',['order','konfirm','proses','kirim','selesai']);
            $table->enum('jenis',['retail','grosir']);
            $table->timestamps();
        });
        Schema::table('detailpenjualan', function(Blueprint $table) {
            $table->foreign('id_transaksipenjualan')
                ->references('id')
                ->on('transaksipenjualan')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        Schema::table('konfirmasi', function(Blueprint $table) {
            $table->foreign('id_transaksipenjualan')
                ->references('id')
                ->on('transaksipenjualan')
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
        Schema::table('detailpenjualan', function(Blueprint $table) {
            $table->dropForeign('detailpenjualan_id_transaksipenjualan_foreign');
        });
        Schema::table('konfirmasi', function(Blueprint $table) {
            $table->dropForeign('konfirmasi_id_transaksipenjualan_foreign');
        });
        Schema::drop('transaksipenjualan');
    }
}
