<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropLidCity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lid_city', function (Blueprint $table) {
            $table->dropForeign(['id_lid']);
            $table->dropForeign(['id_city']);
        });

        Schema::dropIfExists('lid_city');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('lid_city', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_lid');
            $table->unsignedInteger('id_city');
        });
        Schema::table('lid_city', function (Blueprint $table) {
            $table->foreign('id_lid')->references('id')->on('leads');
            $table->foreign('id_city')->references('id')->on('cities');
        });

    }
}
