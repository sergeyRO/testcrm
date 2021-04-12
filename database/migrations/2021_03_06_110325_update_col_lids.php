<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\LeadModel;

class UpdateColLids extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leads', function (Blueprint $table) {
        $table->date('receipt_date1')->after('id_status')->nullable();
    });

        $t=LeadModel::get();
        foreach ($t as $t) {
            LeadModel::where('id', $t->id)->update(['receipt_date1' => date('Y-m-d',(strtotime($t->receipt_date)))/*'2011-01-01'*/]);
        }
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn('receipt_date');
        });

        Schema::table('leads', function (Blueprint $table) {
            $table->date('receipt_date')->after('id_status')->nullable();
        });

        $t=LeadModel::get();
        foreach ($t as $t) {
            LeadModel::where('id', $t->id)->update(['receipt_date' => date('Y-m-d',(strtotime($t->receipt_date1)))/*'2011-01-01'*/]);
        }
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn('receipt_date1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*date('Y-m-d',(strtotime($t->receipt_date)))*/
    }
}
