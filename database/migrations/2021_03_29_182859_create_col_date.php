<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\OrdersModel;
use App\Models\LeadModel;
class CreateColDate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function ($table) {
            $table->timestamp('created_at')->nullable();
        });
        $order = OrdersModel::all();
        foreach($order as $order)
        {
            OrdersModel::where('id', '=', $order->id)->update([
                'created_at' => $order->last_update]);
        }
        Schema::table('leads', function ($table) {
            $table->timestamp('created_at')->nullable();
        });
        $lid = LeadModel::all();
        foreach($lid as $lid)
        {
            LeadModel::where('id', '=', $lid->id)->update([
                'created_at' => $lid->receipt_date.' 00:00:00']);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('created_at');
        });
        Schema::table('leads', function (Blueprint $table) {
        $table->dropColumn('created_at');
    });
    }
}
