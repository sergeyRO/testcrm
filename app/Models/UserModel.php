<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserModel extends Model
{
    use HasFactory;

    protected $table = 'users';
    public $timestamps = false;

    public static function getUsers() {
        return DB::table('users')->select('*' , DB::raw('CASE WHEN role = 0 THEN "Пользователь" WHEN role = 1 THEN "Менеджер" WHEN role = 2 THEN "Администратор" END AS role_name'))->where('role', '!=', 3)->get();
    }

    public static function getUser($id) {
        return UserModel::where('id', '=', $id)->get();
    }

    public static function uniqueEmail($email, $id) {

        $unique = UserModel::where([
            ['email', '=', $email],
            ['id', '!=', $id]
        ])->get();

        if(!$unique->isEmpty()) {
            return false;
        } else {
            return true;
        }
    }

    public static function updateUser($data, $id) {

        UserModel::where('id', '=', $id)->update([
            'login' => $data['login'],
            'email' => $data['email'],
            'role' => $data['role'],
        ]);
    }

    public static function removeUser($id) {
        UserModel::where('id', '=', $id)->delete();
    }

}
