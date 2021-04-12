<?php

namespace App\Http\Controllers;

use App\Http\Controllers\inc\FooterController;
use App\Http\Controllers\inc\HeaderController;
use App\Http\Controllers\inc\SidebarController;
use App\Models\LeadModel;
use App\Models\OrdersModel;
use Illuminate\Http\Request;
use App\Models\OrderCity;
use App\Models\Cities;
use App\Models\Regions;
use App\Models\LidCity;
use App\Models\Options;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Echo_;
use Carbon\Carbon;
use App\Models\SendLid;

class OrdersController extends Controller
{
    public $arrReg;

    public $way;
    public $leads;
    public $limit_lid;
    public $city;
    public $sum;
    public $quantity;

    public $id;
    public $fio;
    public $phone;
    public $comment;

    public $list;

    public $switch;
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->switch = $request->input('switch');
        $this->arrReg = $request->input('arrReg');

        $this->list = $request->input('list');

        $this->id = $request->input('id');
        $this->quantity = $request->input('quantity');
        $this->way = $request->input('way');
        $this->leads = $request->input('leads');
        $this->limit_lid = $request->input('limit_lid');
        $this->city = $request->input('city');
        $this->sum = $request->input('sum');

        $this->fio = $request->input('fio');
        $this->phone = $request->input('phone');
        $this->comment = $request->input('comment');
    }

    public function switchS()
    {
        switch ($this->switch) {
            case 'regions':
                $this->regions();
                break;
            case 'RegionCity':
                $this->RegionCity($this->arrReg);
                break;
            case 'addOrders':
                $this->addOrders($this->way, $this->leads, $this->limit_lid, $this->city, $this->sum);
                break;
            case 'addLids':
                $this->addLids($this->id, $this->way, $this->fio, $this->city, $this->sum, $this->comment, $this->phone);
                break;
            case 'addLidsNull':
                $this->addLidsNull($this->way, $this->fio, $this->city, $this->sum, $this->comment, $this->phone);
                break;

            case 'updateOrderInf':
                $this->updateOrderInf($this->id);
                break;

            case 'updateOrder':
                $this->updateOrder($this->id, $this->limit_lid, $this->city, $this->quantity, $this->way);
                break;
            case 'updateOrderLimitLid':
                $this->updateOrderLimitLid($this->id, $this->limit_lid);
                break;

            case 'del_lid':
                $this->del_lid($this->id);
                break;

            case 'del_order':
                $this->del_order($this->id);
                break;

            case 'bitrix':
                $this->bitrix($this->id);
                break;

            case 'lid_adopted':
                $this->lid_adopted($this->id);
                break;

            case 'all_region':
                $this->all_region($this->id,$this->list);
                break;

            case 'all_city':
                $this->all_city($this->id,$this->list);
                break;
        }
    }

    public function all_city($id,$list)
    {

        $html ='';
        $city = \App\Models\OrderCity::join('cities','order_city.id_city','=','cities.id')
            ->join('orders','order_city.id_order','=','orders.id')->
            where('id_order',$id)->select('cities.name as name');
        if($list==1)
        {
            $city=$city->get();
        }
        if($list==0)
        {
            $city = $city->limit(3)->get();
        }
        foreach ($city as $city)
        {
            $html .= $city->name.'<br>';
        }
        echo $html;
    }

    public function all_region($id,$list)
    {
        $html ='';
        $region = \App\Models\Regions::
        join('cities','regions.id','=','cities.id_region')->
        join('order_city','order_city.id_city','=','cities.id')->
        where('order_city.id_order',$id)->distinct('regions.id')->
        select('regions.name');
        if($list==1)
        {
            $region=$region->get();
        }
        if($list==0)
        {
            $region = $region->limit(3)->get();
        }
        foreach ($region as $region)
        {
            $html .= $region->name.'<br>';
        }
        echo $html;
    }

    public function lid_adopted($id)
    {
        LeadModel::where('id', $id)
            ->update([
                'adopted' => 1,
            ]);
        return true;
    }
    public function bitrix($id)
    {
        $lid=LeadModel::where('id',$id)->first();
        $city=Cities::where('id',$lid->city)->first();

        switch ($lid->way){
            case 1: $lid->way = 'Банкротство';
                break;
            case 2: $lid->way = 'Кредитование';
                break;
        }

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
            'id_lid' => $id,
            'log' => $result
        ]);
    }

    public function del_order($id)
    {
        OrderCity::where('id_order', $id)->delete();

        $lid = LeadModel::where('order_id',$id)->get();
        if($lid && count($lid)>0)
        {
            foreach ($lid as $lid)
            {
                if($lid->date_end < date('Y-m-d', (strtotime(Carbon::now()))))
                {
                    LeadModel::where('id', $lid->id)
                        ->update([
                            'order_id' => null,
                            'id_status' => 4,
                            'id_partner' => null,
                            'receipt_date' => date('Y-m-d', (strtotime(Carbon::now()))),
                        ]);

                }
                if($lid->date_end >= date('Y-m-d', (strtotime(Carbon::now()))))
                    {
                        $orders = OrderCity::join('cities', 'order_city.id_city', '=', 'cities.id')
                            ->join('orders', 'order_city.id_order', '=', 'orders.id')
                            ->select('orders.*')
                            ->where('cities.id', $lid->city)
                            ->where('orders.way', $lid->way)
                            ->where('orders.status', 1)->orderBy('orders.last_update', 'ASC')
                            ->get();
                        if(count($orders) != 0)
                        {
                            foreach ($orders as $order)
                            {
                                $order_lead_To = LeadModel::where('order_id', '=', $order->id)->where('receipt_date', date('Y-m-d', (strtotime(Carbon::now()))))->get();
                                if ($order->limit_lid > count($order_lead_To))
                                {
                                    $sumLead = -1;
                                    if ((int)$lid->sum >= 50000 && (int)$lid->sum <= 299999) $sumLead = 0;
                                    if ((int)$lid->sum >= 300000) $sumLead = 1;

                                    if ($sumLead == $order->sum) {
                                        LeadModel::where('id', $lid->id)
                                            ->update([
                                                'order_id' => $order->id,
                                                'id_status' => 3,
                                                'id_partner' => $order->id_creator,
                                                'receipt_date' => date('Y-m-d', (strtotime(Carbon::now()))),
                                            ]);
                                        if($order->id_creator==32)
                                        {
                                            $this->bitrix($lid->id);
                                        }
                                        OrdersModel::where('id', $order->id)
                                            ->update(['last_update' => date('Y-m-d H:i:s')]);
                                        break;
                                    }
                                }
                            }
                        }
                    }
            }
            LeadModel::where('order_id', $id)
                ->update([
                    'order_id' => null,
                    'id_status' => 2,
                    'id_partner' => null,
                    'receipt_date' => date('Y-m-d', (strtotime(Carbon::now()))),
                ]);
        }
        OrdersModel::destroy($id);
    }

    public function del_lid($id)
    {
        LeadModel::destroy($id);
    }


    public function updateOrderLimitLid($id, $limit_lid)
    {
        OrdersModel::where('id', $id)
            ->update(['limit_lid' => $limit_lid, 'last_update' => date('Y-m-d H:i:s')]);
    }

    public function updateOrder($id, $limit_lid, $city, $quantity, $way)
    {
        if (!empty($id) && $city != 'null' && !empty($limit_lid)) {
            $arr = explode(",", $city);
            if (count($arr) > 0 && $arr != null) {
                OrderCity::where('id_order', $id)->delete();
                for ($i = 0; $i < count($arr); $i++) {
                    OrdersModel::where('id', $id)
                        ->update(['limit_lid' => $limit_lid, 'last_update' => date('Y-m-d H:i:s'),
                            'quantity' => $quantity,
                            'way' => $way,
                            ]);
                    OrderCity::insert([
                        'id_order' => $id,
                        'id_city' => $arr[$i],
                    ]);

                    $ord = OrdersModel::where('id', $id)->where('status', 1)->first();
                    if ($ord) {
                        $prov = LeadModel::where('city', $arr[$i])->where('way', $ord->way)
                            ->whereIn('id_status', [1, 2])->whereNull('order_id')->get();
                        if (count($prov) != 0) {
                            foreach ($prov as $prov) {
                                $provLim = LeadModel::where('receipt_date', date('Y-m-d', (strtotime(Carbon::now()))))
                                    ->where('order_id', $id)->count();
                                if ($provLim < $ord->limit_lid) {
                                    $sumLead = -1;
                                    if ((int)$prov->sum >= 50000 && (int)$prov->sum <= 299999) $sumLead = 0;
                                    if ((int)$prov->sum >= 300000) $sumLead = 1;
                                    if ($sumLead == $ord->sum) {

                                        LeadModel::where('id', $prov->id)
                                            ->update([
                                                'order_id' => $id,
                                                'id_status' => 3,
                                                'id_partner' => $ord->id_creator,
                                                'receipt_date' => date('Y-m-d', (strtotime(Carbon::now()))),
                                            ]);
                                        if($ord->id_creator==32)
                                        {
                                            $this->bitrix($prov->id);
                                        }
                                    }
                                } else break;
                            }
                        }
                    } else break;
                }
            }
        } else {
            echo "error";
        }
    }

    public function updateOrderInf($id)
    {
        $dOrder = OrdersModel::where('id', $id)->first();

        $reg = Regions::get();
        $regionList = '';
        foreach ($reg as $reg) {
            $regionList .= "<option value = '" . $reg->id . "'>" . $reg->name . "</option>";
        }

        $arrRegSel = [];
        $reg = DB::select('select distinct(regions.id) as id from regions
inner join cities on regions.id = cities.id_region
inner join order_city on cities.id = order_city.id_city
where order_city.id_order=' . $id);
        foreach ($reg as $reg) {
            array_push($arrRegSel, $reg->id);
        }

        $city = Cities::whereIn('id_region', $arrRegSel)->get();
        $cityList = '';
        foreach ($city as $city) {
            $cityList .= "<option value = '" . $city->id . "'>" . $city->name . "</option>";
        }

        $arrCitySel = [];
        $city = OrderCity::where('id_order', $id)->get();
        foreach ($city as $city) {
            array_push($arrCitySel, $city->id_city);
        }

        echo json_encode(array('limit_lid' => $dOrder->limit_lid, 'regionList' => $regionList, 'regSel' => $arrRegSel,
            'cityList' => $cityList, 'citySel' => $arrCitySel,'way'=>$dOrder->way,'quantity'=>$dOrder->quantity));
        return false;
    }

    public function addLids($id, $way, $fio, $city, $sum, $comment, $phone)
    {
        /*$maxDateLid=Options::where('id',1)->first();*/
        $ff = 15;
        $order = OrdersModel::where('id', $id)->first();

        if (!empty($fio) && $city != 'null' && !empty($phone) && !empty($sum)) {
            $arr = explode(",", $city);
            if (count($arr) > 0 && $arr != null) {
                for ($i = 0; $i < count($arr); $i++) {
                    $idLid = LeadModel::insertGetId([
                        'way' => $way,
                        'order_id' => $id,
                        'fullname' => $fio,
                        'sum' => $sum,
                        /*'region' => 0,*/
                        'city' => $arr[$i],
                        'telephone' => $phone,
                        'id_manager' => auth()->user()->id,
                        'id_partner' => $order->id_creator,
                        'comment' => $comment,
                        'created_at' => date('Y-m-d H:i:s', (strtotime(Carbon::now()))),
                        'receipt_date' => date('Y-m-d', (strtotime(Carbon::now()))),
                        'date_end' => date('Y-m-d', strtotime('+' . $ff/*$maxDateLid->MaxStorageLid*/ . ' day'))
                    ]);
                    if($order->id_creator==32)
                    {
                        $this->bitrix($idLid);
                    }
                    /* LidCity::insert(['id_lid' => $idLid, 'id_city' => $arr[$i]]);*/
                }
                OrdersModel::where('id', '=', $id)->update([
                    'last_update' => date('Y-m-d H:i:s')
                ]);
            }
        } else {

            echo "error";
        }

    }

    public function regions()
    {
        $reg = Regions::get();
        $html = '';
        foreach ($reg as $reg) {
            $html .= "<option value = '" . $reg->id . "'>" . $reg->name . "</option>";
        }
        echo json_encode(array('html' => $html));
        return false;
    }

    public function RegionCity($arrReg)
    {
        $html = '';
        $arr = explode(",", $arrReg);
        for ($i = 0; $i < count($arr); $i++) {
            $city = Cities::where('id_region', $arr[$i])->get();
            foreach ($city as $city) {
                $html .= '<option value="' . $city->id . '">' . $city->name . '</option>';
            }

        }
        echo json_encode(array('html' => $html));
        return false;
    }

    public function addOrders($way, $leads, $limit_lid, $city, $sum)
    {

        if ($city != 'null') {
            $arr = explode(",", $city);

            if (count($arr) > 0 && $arr != null) {
                $idOrder = OrdersModel::insertGetId([
                    'id_creator' => auth()->user()->id,
                    'regions' => 0,
                    'way' => $way,
                    'quantity' => $leads,
                    'sum' => $sum,
                    'status' => 0,
                    'created_at' => date('Y-m-d H:i:s', (strtotime(Carbon::now()))),
                    'limit_lid' => $limit_lid
                ]);

                for ($i = 0; $i < count($arr); $i++) {
                    OrderCity::insert(['id_order' => $idOrder, 'id_city' => $arr[$i]]);
                }
                /*return redirect()->route('personal_orders')->with('status', 'Заказ добавлен.');*/
                /*Redirect::back();*/
            }
        } else {
            echo "error";
        }

    }


    public function addLid($way, $fio, $sum, $phone, $id_manager, $comment, $city)
    {
        $ff = 15;
        /*$maxDateLid=Options::where('id',1)->first();*/
        $arr = explode(",", $city);
        for ($i = 0; $i < count($arr); $i++) {
            $idLid = LeadModel::insertGetId([
                'way' => $way,
                'fullname' => $fio,
                'sum' => $sum,
                /*'region' => 0,*/
                'city' => $arr[$i],
                'telephone' => $phone,
                'id_manager' => $id_manager,
                'comment' => $comment,
                'created_at' => date('Y-m-d H:i:s', (strtotime(Carbon::now()))),
                'receipt_date' => date('Y-m-d', (strtotime(Carbon::now()))),
                'date_end' => date('Y-m-d', strtotime('+' . $ff/*$maxDateLid->MaxStorageLid*/ . ' day'))
            ]);
            /* LidCity::insert(['id_lid' => $idLid, 'id_city' => $arr[$i]]);*/
        }
    }

    public function addLeadWithOrder($way, $fio, $sum, $phone, $id_manager, $comment, $cityOne, $orderid, $id_partner)
    {
        $ff = 15;
        /*$maxDateLid=Options::where('id',1)->first();*/
        $idLid = LeadModel::insertGetId([
            'way' => $way,
            'order_id' => $orderid,
            'fullname' => $fio,
            'sum' => $sum,
            /*'region' => 0,*/
            'city' => $cityOne,
            'telephone' => $phone,
            'id_status' => 3,
            'id_manager' => $id_manager,
            'id_partner' => $id_partner,
            'comment' => $comment,
            'created_at' => date('Y-m-d H:i:s', (strtotime(Carbon::now()))),
            'receipt_date' => date('Y-m-d', (strtotime(Carbon::now()))),
            'date_end' => date('Y-m-d', strtotime('+' . $ff/*$maxDateLid->MaxStorageLid*/ . ' day'))
        ]);
        if($id_partner==32)
        {
            $this->bitrix($idLid);
        }
        /*LidCity::insert(['id_lid' => $idLid, 'id_city' => $cityOne]);*/
        DB::table('orders')->where('id', '=', $orderid)->update([
            'last_update' => date('Y-m-d H:i:s')
        ]);

    }

    public function addLidsNull($way, $fio, $city, $sum, $comment, $phone)
    {
        if (!empty($fio) && $city != 'null' && !empty($phone) && !empty($sum)) {
            $id_manager = auth()->user()->id;
            $arr = explode(",", $city);
            $newArrCity = [];
            $arrCity = [];
            for ($i = 0; $i < count($arr); $i++) {
                $orders = OrderCity::join('cities', 'order_city.id_city', '=', 'cities.id')
                    ->join('orders', 'order_city.id_order', '=', 'orders.id')
                    ->select('orders.*')
                    ->where('cities.id', $arr[$i])
                    ->where('orders.way', $way)
                    ->where('orders.status', 1)->orderBy('orders.last_update', 'ASC')
                    ->get();
                if (count($orders) != 0) {
                    foreach ($orders as $order) {
                        $order_lead_To = LeadModel::where('order_id', '=', $order->id)->where('receipt_date', date('Y-m-d', (strtotime(Carbon::now()))))->get();
                        if ($order->limit_lid > count($order_lead_To)) {
                            $order_lead = LeadModel::where('order_id', '=', $order->id)->where('id_status', '!=', 4)->get();
                            if (count($order_lead) < $order->quantity) {
                                $sumLead = -1;
                                if ((int)$sum >= 50000 && (int)$sum <= 299999) $sumLead = 0;
                                if ((int)$sum >= 300000) $sumLead = 1;
                                /*if ((int)$sum >= 100000 && (int)$sum <= 299999) $sumLead = 0;
                                if ((int)$sum >= 300000 && (int)$sum <= 499999) $sumLead = 1;
                                if ((int)$sum >= 500000) $sumLead = 2;*/
                                if ($sumLead == $order->sum) {
                                    $orderid = $order->id;
                                    $id_partner = $order->id_creator;
                                    $cityOne = $arr[$i];
                                    array_push($arrCity, $arr[$i]);
                                    $this->addLeadWithOrder($way, $fio, $sum, $phone, $id_manager, $comment, $cityOne, $orderid, $id_partner);
                                    break;
                                } //NOT SUM
                                else  array_push($newArrCity, $arr[$i]);
                            } //Lids = OrderQuantity
                            else  array_push($newArrCity, $arr[$i]);
                        } //NOT limit_lid
                        else  array_push($newArrCity, $arr[$i]);
                    }
                } //NOT order
                else  array_push($newArrCity, $arr[$i]);
            }
            $result = array_unique(array_diff($newArrCity, $arrCity));
            if (count($result) > 0) {
                $city = implode(",", $result);
                $this->addLid($way, $fio, $sum, $phone, $id_manager, $comment, $city);
            }
        } else {
            echo "error";
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['header'] = (new HeaderController)->index('Заказы');
        $data['footer'] = (new FooterController)->index();
        $data['sidebar'] = (new SidebarController)->index();
        ini_set('max_execution_time', 900);
        $orders = DB::table('orders')
            ->join('order_city','orders.id','=','order_city.id_order')
            ->join('cities','order_city.id_city','=','cities.id')
            ->join('regions','cities.id_region','=','regions.id')
            ->leftJoin('users', 'orders.id_creator', '=', 'users.id')
            ->distinct('orders.id')
            ->select('orders.id as id','orders.created_at as created_at','orders.last_update as last_update','orders.quantity as quantity','orders.way as way',
                'orders.sum as sum','orders.status as status',
                'users.login','users.email');
        if($request->has('filter_clear'))
        {
            return redirect()->route('orders');}
        else {
            if ($request->has('sRegion')) {
                if($request->sRegion!=0)
                {
                    $orders->where('regions.id',$request->sRegion);
                    $sRegion = $request->sRegion;
                }
                else
                {
                    $sRegion = 0;
                }
            }
            else{$sRegion = false;}

            if ($request->has('sCity')) {
                if($request->sCity!=0)
                {
                    $orders->where('order_city.id_city',$request->sCity);
                    $sCity = $request->sCity;
                }
                else
                {
                    $sCity = 0;
                }
            }
            else{$sCity = false;}

            if ($request->has('sStatus')) {
                if($request->sStatus!=1000)
                {
                    $orders->where('orders.status', $request->sStatus);
                }
                $stat = $request->sStatus;
            } else {
                $stat = 1000;
            }

            if ($request->has('sWay')) {
                if($request->sWay!=1000)
                {
                    $orders->where('orders.way', $request->sWay);
                }
                $way = $request->sWay;
            } else {
                $way = 1000;
            }

            if ($request->has('sSum')) {

                if ($request->sSum == 0) {
                    $orders->where('orders.sum', 0);
                }
                if ($request->sSum == 1) {
                    $orders->where('orders.sum', 1);

                }
                $sum = $request->sSum;
            } else {
                $sum = 100;
            }

            if ($request->has('dataCreate')) {
                if($request->dataCreate!='' && $request->dataCreate!=0)
                {
                    $orders->where('orders.created_at', '>=',$request->dataCreate.' 00:00:00')
                        ->where('orders.created_at', '<=',$request->dataCreate.' 23:59:59');
                    $dataCreate = $request->dataCreate;
                }
                else{
                    $dataCreate = '';
                }
            } else {
                $dataCreate = false;
            }


            if ($request->has('dataUp')) {
                if($request->dataUp!='' && $request->dataUp!=0)
                {
                    $orders->where('orders.last_update', '>=',$request->dataUp.' 00:00:00')
                        ->where('orders.last_update', '<=',$request->dataUp.' 23:59:59');
                    $dataUp = $request->dataUp;
                }
                else{
                    $dataUp = '';
                }
            } else {
                $dataUp = false;
            }


            $data['orders'] = $orders
                ->orderBy('orders.last_update', 'DESC')->paginate(50);
            $role = auth()->user()->role;

            view()->share('sRegion',$sRegion);
            view()->share('sCity',$sCity);
            view()->share('dataCreate', $dataCreate);
            view()->share('dataUp', $dataUp);
            view()->share('stat', $stat);
            view()->share('way', $way);
            view()->share('s', $sum);
            view()->share('role', $role);

            return view('orders.admin.orders', $data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['header'] = (new HeaderController)->index('Лиды заказ №' . $id);
        $data['footer'] = (new FooterController)->index();
        $data['sidebar'] = (new SidebarController)->index();

        $data['leads'] = LeadModel::getLeadsByOrder($id);
        $role = auth()->user()->role;
        view()->share('role', $role);
        return view('orders.admin.orders_leads', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function updateStatus(Request $request)
    {
        //OrdersModel::updateStatus($request->input('order'), $request->input('status'));
        $status = $request->input('status');
        $id = $request->input('order');
            OrdersModel::where('id', '=', $id)->update([
                'status' => $status
            ]);
            $prSt = OrdersModel::where('id', $id)->where('status', 1)->first();
            if ($prSt) {
                $cityOrd = OrderCity::where('id_order', $id)->get();
                foreach ($cityOrd as $city) {
                    $prov = LeadModel::where('city', $city->id_city)->where('way', $prSt->way)
                        ->whereIn('id_status', [1, 2])->whereNull('order_id')->get();
                    if (count($prov) != 0) {
                        foreach ($prov as $prov) {
                            $provLim = LeadModel::where('receipt_date', date('Y-m-d', (strtotime(Carbon::now()))))
                                ->where('order_id', $id)->count();
                            if ($provLim < $prSt->limit_lid) {
                                $sumLead = -1;

                                if ((int)$prov->sum >= 50000 && (int)$prov->sum <= 299999) $sumLead = 0;
                                if ((int)$prov->sum >= 300000) $sumLead = 1;
                                /*if ((int)$prov->sum >= 100000 && (int)$prov->sum <= 299999) $sumLead = 0;
                                if ((int)$prov->sum >= 300000 && (int)$prov->sum <= 499999) $sumLead = 1;
                                if ((int)$prov->sum >= 500000) $sumLead = 2;*/
                                if ($sumLead == $prSt->sum) {

                                    LeadModel::where('id', $prov->id)
                                        ->update([
                                            'order_id' => $id,
                                            'id_status' => 3,
                                            'id_partner' => $prSt->id_creator,
                                            'receipt_date' => date('Y-m-d', (strtotime(Carbon::now()))),
                                        ]);
                                    if($prSt->id_creator==32)
                                    {
                                        $this->bitrix($prov->id);
                                    }
                                }
                            } else break;
                        }
                    }
                }
            }
    }
}