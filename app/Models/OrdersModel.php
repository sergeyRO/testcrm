<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cities;
use App\Models\OrderCity;
class OrdersModel extends Model
{
    use HasFactory;

    protected $table = "orders";
    public $timestamps = false;

    public static function addOrder($data, $id) {
       echo $data['city'];
       /*$d= explode(',',$data['city']);
       foreach ($d as $d)
       {
           dd($d);
       }*/

       /* $city = explode(',',$data['city']);
        if($city.length>0)
        {
            $idOrder = OrdersModel::insertGetId([
                'id_creator' => $id,
                'regions' => 0,
                'way' => $data['way'],
                'quantity' => $data['leads'],
                'sum' => $data['sum'],
                'status' => 0,
                'limit_lid' => $data['limit_lid']
            ]);
            $i=0;
foreach ($city as $city)
{
    OrderCity::insert(['id_order' => $idOrder,'id_city' => [$city[$i++]]]);
}

        }*/


        /*if(!empty($data['city']))
        {
            foreach ($data['city'] as $s)
            {
                OrderCity::insert(['id_order' => $idOrder,'id_city' => $s]);
            }
        }
        else
        {
            $city = '';
        }*/
    }

    public static function getOrders($id) {
        return OrdersModel::where('id_creator', '=', $id)->orderBy('last_update', 'DESC')->paginate(50)/*->get()*/;
    }

    public static function getOrder($id) {
        return OrdersModel::where('id', '=', $id)->get()->toArray();
    }

    public static function getOrdersAll() {
        return OrdersModel::select('orders.*', 'users.login', 'users.email')->leftJoin('users', 'orders.id_creator', '=', 'users.id')->orderBy('orders.last_update','DESC')->paginate(50)/*->get()*/;
    }

    public static function getOrdersAllActiveDesc() {
        return OrdersModel::select('orders.*', 'users.login', 'users.email')->leftJoin('users', 'orders.id_creator', '=', 'users.id')->where('orders.status', '=', 1)->orderBy('last_update', 'ASC')->get()->toArray();
    }

    public static function getOrdersAllActive() {
        return OrdersModel::select('orders.*', 'users.login', 'users.email')->leftJoin('users', 'orders.id_creator', '=', 'users.id')->where('orders.status', '=', 1)->get();
    }

    public static function updateStatus($id, $status) {
        OrdersModel::where('id', '=', $id)->update([
            'status' => $status
        ]);
    }
}
