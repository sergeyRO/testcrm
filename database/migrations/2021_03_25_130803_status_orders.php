<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StatusOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_orders', function (Blueprint $table) {
            $table->/*increments('id')*/unsignedInteger('id')->nullable();;
            $table->string('name');
        });
        DB::table('status_orders')->insert(array (
            0 =>
                array (
                    'id' => 0,
                    'name' => "Созданный",
                ),
            1 =>
                array (
                    'id' => 1,
                    'name' => "Активный",
                ),
            2 =>
                array (
                    'id' => 2,
                    'name' => "Закрытый",
                ),
        ));
        Schema::table('status_orders', function ($table) {
            $table->primary('id');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('status_orders');
    }
}
