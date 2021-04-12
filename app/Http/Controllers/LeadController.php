<?php

namespace App\Http\Controllers;

use App\Http\Controllers\inc\FooterController;
use App\Http\Controllers\inc\HeaderController;
use App\Http\Controllers\inc\SidebarController;
use App\Models\Cities;
use App\Models\LeadModel;
use App\Models\OrdersModel;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use App\Models\LidCity;
use Illuminate\Support\Facades\DB;


class LeadController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['header'] = (new HeaderController)->index('Лиды');
        $data['footer'] = (new FooterController)->index();
        $data['sidebar'] = (new SidebarController)->index();

        ini_set('max_execution_time', 900);
        $lids = DB::table('leads');

        if($request->has('filter_clear'))
        {
            return redirect()->route('leads');}
            else{

                if ($request->has('sStatus')) {
                    if($request->sStatus!=1000) {
                        $lids->where('id_status', $request->sStatus);
                    }
                    $stat = $request->sStatus;
                }
                else{$stat = 1000;}

                if ($request->has('sWay')) {
                    if($request->sWay!=1000) {
                        $lids->where('way', $request->sWay);
                    }
                    $way = $request->sWay;
                }
                else{$way = 1000;}

                if ($request->has('sSum')) {

                    if($request->sSum==0)
                    {
                        $lids->where('sum','<=' ,299999)->where('sum','>=',50000);
                    }
                    if($request->sSum==1)
                    {
                        $lids->where('sum','>=' ,300000);
                    }
                    $sum = $request->sSum;
                }
                else{$sum = 100;}
                if ($request->has('sCity')) {
                    if($request->sCity!=0)
                    {
                        $lids->where('city',$request->sCity);
                        $sCity = $request->sCity;
                    }
                    else
                    {
                        $sCity = 0;
                    }
                }
                else{$sCity = false;}

                if ($request->has('dataCreate')) {
                    if($request->dataCreate!='' && $request->dataCreate!=0)
                    {
                        $lids->where('leads.created_at', '>=',$request->dataCreate.' 00:00:00')
                            ->where('leads.created_at', '<=',$request->dataCreate.' 23:59:59');
                        $dataCreate = $request->dataCreate;
                    }
                    else{
                        $dataCreate = '';
                    }
                } else {
                    $dataCreate = false;
                }

                $data['leads'] = $lids->orderBy('id','DESC')->paginate(50);
                $role = auth()->user()->role;
                view()->share('dataCreate', $dataCreate);
                view()->share('sCity',$sCity);
                view()->share('stat',$stat);
                view()->share('way',$way);
                view()->share('s', $sum);
                view()->share('role', $role);
                /*$data['leads'] = LeadModel::get();*/
                return view('leads.all', $data);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       /* $data = $request->all();

        if(!empty($data['fullname']) && !empty($data['city']) && !empty($data['telephone']) && !empty($data['sum'])) {
            $data['id_manager'] = auth()->user()->id;

            $orders = OrdersModel::getOrdersAllActiveDesc();

            if(!empty($orders)) {
                foreach ($orders as $order) {
                    $order_lead = LeadModel::getLeadsByOrder($order['id']);

                    if(count($order_lead) < $order['quantity']) {
                        if($request->input('way') == $order['way']) {

                            $order_regions = explode(', ', $order['regions']);
                            $region_lock = false;

                            foreach ($request->input('region') as $region) {
                                if(in_array($region, $order_regions)) {
                                    $region_lock = true;
                                    break;
                                }
                            }

                            if($region_lock) {
                                $sumLead = 0;

                                if((int)$request->input('sum')>= 100000 && (int)$request->input('sum')>= 299999) $sumLead=0;
                                if((int)$request->input('sum')<= 300000) $sumLead=1;
                                if((int)$request->input('sum')> 300000 && (int)$request->input('sum')<= 500000) $sumLead=2;
                                if((int)$request->input('sum') > 500000) $sumLead=3;

                                if($sumLead == $order['sum']) {

                                    $data['orderid'] = $order['id'];
                                    $data['id_partner'] = $order['id_creator'];
                                    LeadModel::addLeadWithOrder($data);
                                    break;
                                } else {
                                    LeadModel::addLead($data);
                                }
                            } else {
                                LeadModel::addLead($data);
                            }

                        } else {
                            LeadModel::addLead($data);
                        }
                    } else {
                        LeadModel::addLead($data);
                    }
                }
            }
        }

        return response()->json(['success' => 200]);*/
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeAjax(Request $request)
    {
        $data = $request->all();

        if(!empty($data['fullname']) && !empty($data['city']) && !empty($data['telephone']) && !empty($data['sum'])) {
            $data['id_manager'] = auth()->user()->id;
            $partner = OrdersModel::getOrder($data['orderid']);
            $data['id_partner'] = $partner[0]['id_creator'];

            LeadModel::addLeadWithOrder($data);
        }

        return response()->json(['success' => 200]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        LeadModel::addLeadToOrder($request->input('order_id'),$id);

        return back()->with('status', 'Лид добавлен к заказу.');
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
