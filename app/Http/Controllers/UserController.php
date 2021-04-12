<?php

namespace App\Http\Controllers;

use App\Http\Controllers\inc\FooterController;
use App\Http\Controllers\inc\HeaderController;
use App\Http\Controllers\inc\SidebarController;
use Illuminate\Http\Request;
use App\Models\UserModel;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data['header'] = (new HeaderController)->index('Панель управления');
        $data['footer'] = (new FooterController)->index();
        $data['sidebar'] = (new SidebarController)->index();

        $data['users'] = UserModel::getUsers();

        return view('users.users', $data);
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
        //
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

        $data['header'] = (new HeaderController)->index('Панель управления');
        $data['footer'] = (new FooterController)->index();
        $data['sidebar'] = (new SidebarController)->index();

        $data['user'] = UserModel::getUser($id);

        return view('users.user_form', $data);

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
        if(UserModel::uniqueEmail($request->input('email'), $id)) {

            UserModel::updateUser($request->all(), $id);

            return back()->with('status_success', 'Профиль успешо обновлен.');
        } else {
            return back()->with('status_errors', 'Почта уже используется другими пользователями.');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        UserModel::removeUser($id);
        return back()->with('status', 'Пользователь удален.');
    }
}
