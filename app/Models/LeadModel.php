<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LeadModel extends Model
{
    use HasFactory;

    protected $table = "leads";
    public $timestamps = false;

    public static function addLead($data) {
        if(!empty($data['region'])) {
            if(count($data['region']) > 1) {
                $regions = implode(', ', $data['region']);
            } else {
                $regions = implode('', $data['region']);
            }
        } else {
            $regions = '';
        }

        LeadModel::insert([
            'way' => $data['way'],
            'fullname' => $data['fullname'],
            'sum' => $data['sum'],
            'region' => $regions,
            'city' => $data['city'],
            'telephone' => $data['telephone'],
            'id_manager' => $data['id_manager'],
            'comment' => $data['comment'],
        ]);
    }

    public static function addLeadWithOrder($data) {
        if(!empty($data['region'])) {
            if(count($data['region']) > 1) {
                $regions = implode(', ', $data['region']);
            } else {
                $regions = implode('', $data['region']);
            }
        } else {
            $regions = '';
        }

        LeadModel::insert([
            'way' => $data['way'],
            'order_id' => $data['orderid'],
            'fullname' => $data['fullname'],
            'sum' => $data['sum'],
            'region' => $regions,
            'city' => $data['city'],
            'telephone' => $data['telephone'],
            'id_manager' => $data['id_manager'],
            'id_partner' => $data['id_partner'],
            'comment' => $data['comment'],
        ]);

        DB::table('orders')->where('id', '=', $data['orderid'])->update([
            'last_update' => date('Y-m-d H:i:s')
        ]);
    }

    public static function getLeadsByOrder($id) {
        return LeadModel::where('order_id', '=', $id)->orderBy('id','DESC')->paginate(50);
    }

    public static function getLeadsEmpty() {
        return LeadModel::/*whereNull('order_id')->*/get();
    }

    public static function addLeadToOrder($order, $id) {
        LeadModel::where('id', '=', $id)->update([
            'order_id' => $order
        ]);
        DB::table('orders')->where('id', '=', $order)->update([
            'last_update' => date('Y-m-d H:i:s')
        ]);
    }

}
