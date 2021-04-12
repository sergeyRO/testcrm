<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColLid extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leads', function($table)
        {
            $table->dropColumn('region');
            $table->dropColumn('city');
        });
        Schema::table('leads', function($table)
        {
            $table->unsignedInteger('city')->nullable();
        });
        Schema::table('leads', function (Blueprint $table) {
            $table->foreign('city')->references('id')->on('cities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leads', function($table)
        {
            $table->unsignedInteger('region')->nullable();
        });
        Schema::table('leads', function (Blueprint $table) {
            $table->dropForeign(['city']);
        });
    }
}
