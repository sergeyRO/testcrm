<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCascade extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropForeign(['id_partner']);
            $table->dropForeign(['id_manager']);
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['id_creator']);
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('id_creator')->references('id')->on('users')->onUpdate('cascade');
        });
        Schema::table('leads', function (Blueprint $table) {
            $table->foreign('id_partner')->references('id')->on('users')->onUpdate('cascade');
            $table->foreign('id_manager')->references('id')->on('users')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
