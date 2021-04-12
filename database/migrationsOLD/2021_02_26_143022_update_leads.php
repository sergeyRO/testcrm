<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class UpdateLeads extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $arr=[];

        $d=DB::table('leads')->get();
        foreach ($d as $d)
        {
            $arr[] = $d->id_manager;
            $arr1[] =  $d->id_partner;
        }

        Schema::table('leads', function ($table) {
            $table->dropColumn('id_manager');
        });
        Schema::table('leads', function ($table) {
            $table->dropColumn('id_partner');
        });
        Schema::table('leads', function ($table) {
            $table->unsignedInteger('id_manager')->nullable();
        });
        Schema::table('leads', function ($table) {
            $table->unsignedInteger('id_partner')->nullable();
        });
        Schema::table('leads', function ($table) {
            $table->unsignedInteger('id_status')->nullable()->default(1);
        });
        $d=DB::table('leads')->get();
        foreach ($d as $d)
        {
            DB::table('leads')->where('id',$d->id)->update(['id_manager'=>$arr[$d->id-1],'id_partner'=>$arr1[$d->id-1]]);
        }

        Schema::table('leads', function (Blueprint $table) {
            $table->foreign('id_manager')->references('id')->on('users');
        });
        Schema::table('leads', function (Blueprint $table) {
            $table->foreign('id_partner')->references('id')->on('users');
        });
        Schema::table('leads', function (Blueprint $table) {
            $table->foreign('id_status')->references('id')->on('status_lids');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropForeign(['id_manager']);
            $table->dropForeign(['id_partner']);
            $table->dropForeign(['id_status']);
            $table->dropColumn('id_status');
        });
    }
}
