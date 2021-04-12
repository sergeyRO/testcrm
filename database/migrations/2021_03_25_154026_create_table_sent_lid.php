<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSentLid extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sent_lid', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('id_lid')->nullable();
        });
        Schema::table('sent_lid', function (Blueprint $table) {
            $table->foreign('id_lid')->references('id')->on('leads');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sent_lid', function (Blueprint $table) {
            $table->dropForeign(['id_lid']);
        });
        Schema::dropIfExists('sent_lid');
    }
}
