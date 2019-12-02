<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('nohp')->unique();
            $table->string('password');
            $table->text('alamat');
            $table->integer('id_kota')->unsigned();
            $table->rememberToken();
            $table->timestamps();
        });
        Schema::table('keranjang', function(Blueprint $table) {
            $table->foreign('id_users')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        Schema::table('transaksipenjualan', function(Blueprint $table) {
            $table->foreign('id_users')
                ->references('id')
                ->on('users')
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
            $table->dropForeign('keranjang_id_users_foreign');
        });
        Schema::table('transaksipenjualan', function(Blueprint $table) {
            $table->dropForeign('transaksipenjualan_id_users_foreign');
        });
        Schema::drop('users');
    }
}
