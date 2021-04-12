<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\OrdersModel;

class AddColumnStatusTableOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function ($table) {
            $table->unsignedInteger('id_status');
        });
        $orders = DB::table('orders')->get();
        foreach ($orders as $orders)
        {
            if($orders->status==1)
            {
                $count_lid=DB::table('leads')->where('order_id',$orders->id)->where('id_status',3)->count();

                    if($count_lid==$orders->quantity)
                    {
                        OrdersModel::where('id',$orders->id)
                            ->update(['id_status' => 2,
                                'last_update' => $orders->last_update]);
                    }
                    if($count_lid!=$orders->quantity)
                    {
                        OrdersModel::where('id',$orders->id)
                            ->update(['id_status' => 1,
                                'last_update' => $orders->last_update]);
                    }
            }
            if($orders->status==0)
            {
                OrdersModel::where('id',$orders->id)
                    ->update(['id_status' => 0,
                        'last_update' => $orders->last_update]);
            }
        }
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table('orders', function ($table) {
            $table->unsignedInteger('status');
        });
        $orders1 = DB::table('orders')->get();
        foreach ($orders1 as $orders1)
        {
            OrdersModel::where('id',$orders1->id)
                ->update(['status' => $orders1->id_status,
                    'last_update' => $orders1->last_update]);
        }
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('id_status');
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('status')->references('id')->on('status_orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['status']);
        });
    }
}
