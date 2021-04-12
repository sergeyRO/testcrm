<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\LeadModel;
use App\Models\SendLid;
use App\Models\Cities;


class CreateColumnSentlid extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sent_lid', function ($table) {
            $table->text('log')->nullable()->default(Null)->comment('Лог отправки в Api');
        });

        $lid=LeadModel::where('id_partner',32)->get();

        if($lid)
        {
            foreach ($lid as $lid)
            {
                if($lid->id!=1038)
                {
                    $prov = \App\Models\SendLid::where('id_lid',$lid->id)->first();
                    if(!$prov)
                    {
                        switch ($lid->way){
                            case 1: $lid->way = 'Банкротство';
                                break;
                            case 2: $lid->way = 'Кредитование';
                                break;
                        }
                        $city=Cities::where('id',$lid->city)->first();
                        $queryUrl = 'https://bankirromsk.ru/rest/261/039shfiqti93optk/crm.lead.add.json';
                        $queryData = http_build_query(array(
                            'fields' => array(
                                'TITLE' => 'Лид №'.$lid->id,
                                'NAME' => $lid->fullname,
                                'COMMENTS' => 'Направление: '.$lid->way.'. Сумма: '.$lid->sum.'. Город: '.$city->name.'. Комментарий: '.$lid->comment,
                                'SOURCE_ID' => 53,
                                'PHONE' => array(
                                    array(
                                        "VALUE" => $lid->telephone,
                                        "VALUE_TYPE" => "WORK"
                                    )
                                )
                            ),
                            'params' => array("REGISTER_SONET_EVENT" => "Y")
                        ));
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_SSL_VERIFYPEER => 0,
                            CURLOPT_POST => 1,
                            CURLOPT_HEADER => 0,
                            CURLOPT_RETURNTRANSFER => 1,
                            CURLOPT_URL => $queryUrl,
                            CURLOPT_POSTFIELDS => $queryData,
                        ));
                        $result = curl_exec($curl);
                        curl_close($curl);

                        SendLid::insert([
                            'id_lid' => $lid->id,
                            'log' => $result
                        ]);
                    }
                }

        }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sent_lid', function (Blueprint $table) {
            $table->dropColumn('log');
        });
    }
}
