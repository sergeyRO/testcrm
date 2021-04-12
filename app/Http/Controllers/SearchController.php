<?php

namespace App\Http\Controllers;
use App\Http\Controllers\inc\FooterController;
use App\Http\Controllers\inc\HeaderController;
use App\Http\Controllers\inc\SidebarController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Regions;
use App\Models\Cities;
use App\Models\OrdersModel;
use App\Models\LeadModel;

class SearchController extends Controller
{
    public function index($find)
    {
        $data['header'] = (new HeaderController)->index('Заказы');
        $data['footer'] = (new FooterController)->index();
        $data['sidebar'] = (new SidebarController)->index();
        /*$result = '';
        $res_count = 0;
        $i=0;

        $region = DB::table('regions')->where('show_site',1)->where('region', 'like', '%'.$find.'%')->get();
        $count_region = count($region);

        $city = DB::table('cities')
            ->join('regions','cities.region_id','=','regions.id')
            ->where('cities.show_site',1)
            ->where('regions.show_site',1)->where('city', 'like', '%'.$find.'%')
            ->select('cities.code as code','cities.city as city','cities.subdomen as subdomen','cities.code as cityCode')
            ->get();
        $count_city = count($city);

        $smi = DB::table('smis')
            ->join('cities','smis.id_city','=','cities.id')
            ->join('regions','cities.region_id','=','regions.id')
            ->where('cities.show_site',1)
            ->where('regions.show_site',1)
            ->where('smis.show_site',1)->where('name', 'like', '%'.$find.'%')
            ->select('smis.code as code','smis.name as name','cities.subdomen as subdomen','cities.code as cityCode')
            ->get();
        $count_smi = count($smi);

        $res_count = $count_city+$count_region+$count_smi;

        if($count_city!=0){
            foreach ($city as $city)
            {
                $result .= '
	<div class="mosearchresult" id="mosearchresult-">
		<a href="'.$this->subdomain($city->subdomen,$city->cityCode,'gorod','','','').'">'.$city->city.' (Город) </a>
	</div>';
                $i++;
                if($i==10)
                {
                    break;}
            }
        }
        if($i<10)
        {
            if($count_region!=0)
            {
                foreach ($region as $region)
                {
                    $result .= '
	<div class="mosearchresult" id="mosearchresult-">
		<a href="'.$this->subdomain('','','region','','',$region->code).'">'.$region->region.' (Регион)</a>
	</div>';
                    $i++;
                    if($i==10)
                    {
                        break;}
                }
            }
        }
        if($i<10)
        {
            if($count_smi!=0){
                foreach ($smi as $smi)
                {
                    $result .= '
	<div class="mosearchresult" id="mosearchresult-">
		<a href="'.$this->subdomain($smi->subdomen,$smi->cityCode,'smi','',$smi->code,'').'">'.$smi->name.' (СМИ)</a>
	</div>';
                    $i++;
                    if($i==10)
                    {
                        break;}
                }
            }
        }

        // Далее формируем красивую форму
        $result	.= '
	<div class="mosearchresulttotal">
		<p>всего найдено: '.$res_count.'</p>
		<p><a href="/search/'.$find.'">Все результаты сайта по запросу "'.$find.'"</a></p>
	</div>';
        echo $result;*/
        return view('search.index', $data);
    }

    public function detail($find)
    {
        $data['header'] = (new HeaderController)->index('ПОИСК');
        $data['footer'] = (new FooterController)->index();
        $data['sidebar'] = (new SidebarController)->index();
        $result=[];
        $i=0;
        $user = auth()->user()->id;
        $region_lid = Regions::
        join('cities','regions.id','=','cities.id_region')
            ->join('leads','cities.id','=','leads.city')
            ->where('regions.name','like','%'.$find.'%')
            ->orWhere('cities.name','like','%'.$find.'%')
            ->select('regions.name as regions','cities.name as city','leads.sum as sum','leads.id_status as status','leads.id as id')->get();
        $count_region_lid = count($region_lid);

        $region_order = Regions::
        join('cities','regions.id','=','cities.id_region')
            ->join('order_city','cities.id','=','order_city.id_city')
            ->join('orders','order_city.id_order','=','orders.id')
            ->where('regions.name','like','%'.$find.'%')
            ->orWhere('cities.name','like','%'.$find.'%')
            ->select('regions.name as regions','cities.name as city','orders.sum as sum','orders.id as id')->get();
        $count_region_order = count($region_order);

        if($count_region_lid!=0){
            foreach ($region_lid as $reg_lid)
            {
                $i++;
                $result[] = array('type' => 'lid','region'=>$reg_lid->regions,'city' => $reg_lid->city, 'sum' => $reg_lid->sum, 'id' => $reg_lid->id, 'status' => $reg_lid->status);
            }
        }

        if($count_region_order!=0)
        {
            foreach ($region_order as $reg_ord)
            {
                $i++;
                $result[] = array('type' => 'order','region'=>$reg_ord->regions,'city' => $reg_ord->city, 'sum' => $reg_ord->sum, 'id' => $reg_ord->id);
            }
        }
        $data['find'] = $find;
        $data['result'] = $result;

        return view('search.extend', $data);
    }

}
