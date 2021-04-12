<?php

namespace App\Http\Controllers;

use App\Http\Controllers\inc\FooterController;
use App\Http\Controllers\inc\HeaderController;
use App\Http\Controllers\inc\SidebarController;
use App\Models\LeadModel;
use Illuminate\Http\Request;
use App\Models\OrdersModel;
use Illuminate\Support\Facades\DB;

class PersonalOrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /*$data['header'] = (new HeaderController)->index('Мои заказы');
        $data['footer'] = (new FooterController)->index();
        $data['sidebar'] = (new SidebarController)->index();

        $orders = OrdersModel::getOrders(auth()->user()->id);

        foreach ($orders as $order) {
            $lead = LeadModel::getLeadsByOrder($order->id);
            $order->count_lead = count($lead);

            if($order->sum == 0) $order->sum = 'от 50000 до 299999';
            if($order->sum == 1) $order->sum = 'от 300000 и выше';
        }

        $data['orders'] = $orders;

        return view('orders.personal_orders', $data);*/
        //$orders = OrdersModel::where('id_creator', '=', auth()->user()->id)->orderBy('last_update', 'DESC')->paginate(50);
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
            ->where('id_creator', '=', auth()->user()->id)
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
            view()->share('sCity', $sCity);
            view()->share('dataCreate', $dataCreate);
            view()->share('dataUp', $dataUp);
            view()->share('stat', $stat);
            view()->share('way', $way);
            view()->share('s', $sum);
            view()->share('role', $role);

            /*return view('orders.admin.orders', $data);*/
            return view('orders.personal_orders', $data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['header'] = (new HeaderController)->index('Добавление заказа');
        $data['footer'] = (new FooterController)->index();
        $data['sidebar'] = (new SidebarController)->index();

        return view('orders.add_order', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        OrdersModel::addOrder($request->all(), auth()->user()->id);
        return redirect()->route('personal_orders')->with('status', 'Заказ добавлен.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
