<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\OrdersModel;

class UpdateTableOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $order = OrdersModel::get();
        foreach ($order as $a)
        {
            $sum=0;

            if($a->sum >= 100000 && $a->sum <= 299999) $sum = 0;
            if($a->sum <= 300000 && $a->sum < 499999) $sum = 1;
            if($a->sum <= 500000) $sum = 2;

            OrdersModel::where('id',$a->id)->update(['sum' => $sum]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $order = OrdersModel::get();
        foreach ($order as $a)
        {
            $sum=0;
            if($a->sum == 0) $sum = 100000;
            if($a->sum == 1) $sum = 300000;
            if($a->sum == 2) $sum = 500000;

            OrdersModel::where('id',$a->id)->update(['sum' => $sum]);
        }
    }
}
