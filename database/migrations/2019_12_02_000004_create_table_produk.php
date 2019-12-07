<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProduk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kodeproduk', 50)->unique();
            $table->string('namaproduk', 50);
            $table->text('deskripsi');
            $table->string('foto')->nullable;
            $table->string('link');
            $table->integer('stok');
            $table->integer('berat');
            $table->double('hargabeli');
            $table->double('hargajual');
            $table->double('hargagrosir');
            $table->integer('dilihat');
            $table->integer('terjual');
            $table->timestamps();
        });
        Schema::table('keranjang', function(Blueprint $table) {
            $table->foreign('id_produk')
                ->references('id')
                ->on('produk')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        Schema::table('detailpenjualan', function(Blueprint $table) {
            $table->foreign('id_produk')
                ->references('id')
                ->on('produk')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        Schema::table('fotoproduk', function(Blueprint $table) {
            $table->foreign('id_produk')
                ->references('id')
                ->on('produk')
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
        Schema::table('keranjang', function(Blueprint $table) {
            $table->dropForeign('keranjang_id_produk_foreign');
        });
        Schema::table('detailpenjualan', function(Blueprint $table) {
            $table->dropForeign('detailpenjualan_id_produkr_foreign');
        });
        Schema::table('fotoproduk', function(Blueprint $table) {
            $table->dropForeign('fotoproduk_id_produk_foreign');
        });
        Schema::drop('produk');
    }
}
