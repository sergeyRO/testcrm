<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusLid extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_lids', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });
        DB::table('status_lids')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'name' => "Новый",
                ),
            1 =>
                array (
                    'id' => 2,
                    'name' => "Не присвоен",
                ),
            2 =>
                array (
                    'id' => 3,
                    'name' => "Присвоен",
                ),
            3 =>
                array (
                    'id' => 4,
                    'name' => "Просрочен",
                ),
        ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('status_lids');
    }
}
