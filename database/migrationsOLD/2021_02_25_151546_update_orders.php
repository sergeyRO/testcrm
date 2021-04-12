<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class UpdateOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $arrU=[];
        $U=DB::table('users')->get();
        foreach ($U as $u)
        {
            $arrU[] = $u->id;
        }

        Schema::table('users', function ($table) {
            $table->dropColumn('id');
        });

        Schema::table('users', function ($table) {
           $table->increments('id')->first();
        });


        $user=DB::table('users')->get();
        foreach ($user as $us)
        {
            DB::table('users')->where('id',$us->id)->update(['id'=>'1000'.$arrU[$us->id-1]]);
        }
        $per=DB::table('users')->get();
        foreach ($per as $per)
        {
            $f=substr($per->id, 4, 5);
            DB::table('users')->where('id',$per->id)->update(['id'=>$f]);
        }


        $arr=[];
        $d=DB::table('orders')->get();
        foreach ($d as $d)
        {
            $arr[] = $d->id_creator;
        }

        Schema::table('orders', function ($table) {
            $table->dropColumn('id_creator');
        });
        Schema::table('orders', function ($table) {
            $table->unsignedInteger('id_creator')->after('id')->nullable();
        });
        $d=DB::table('orders')->get();
        foreach ($d as $d)
        {
            DB::table('orders')->where('id',$d->id)->update(['id_creator'=>$arr[$d->id-1]]);
        }
        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('id_creator')->references('id')->on('users');
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
            $table->dropForeign(['id_creator']);
        });
    }
}
