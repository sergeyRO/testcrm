<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', [\App\Http\Controllers\DashboardController::class,'index'])->middleware(['auth'])->name('dashboard');

//Список покупателей
Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])->middleware(['auth', 'admin'])->name('users');
//Конкретный покупатель
Route::get('/user/{id}', [\App\Http\Controllers\UserController::class, 'edit'])->middleware(['auth', 'admin'])->name('user_edit');
//Обновление покупателя
Route::post('/user/update/{id}', [\App\Http\Controllers\UserController::class, 'update'])->middleware(['auth', 'admin'])->name('user_update');
//Удаление покупателя
Route::post('/user/delete/{id}', [\App\Http\Controllers\UserController::class, 'destroy'])->middleware(['auth', 'admin'])->name('user_remove');

Route::get('/personal/orders', [\App\Http\Controllers\PersonalOrdersController::class, 'index'])->middleware(['auth'])->name('personal_orders');
Route::get('/personal/orders/{id}/leads', [\App\Http\Controllers\PersonalOrdersController::class, 'show'])->middleware(['auth','personalLeads'])->name('personal_orders_leads');
Route::get('/personal/add', [\App\Http\Controllers\PersonalOrdersController::class, 'create'])->middleware(['auth'])->name('personal_add_order');
Route::post('/personal/create', [\App\Http\Controllers\PersonalOrdersController::class, 'store'])->middleware(['auth'])->name('personal_create_order');

//Список заказов для менеджеров и выше
Route::get('/orders', [\App\Http\Controllers\OrdersController::class, 'index'])->middleware(['auth', 'manager'])->name('orders');

Route::post('/orders/addlead', [\App\Http\Controllers\LeadController::class, 'storeAjax'])->middleware(['auth', 'manager'])->name('addlead_from_orders');
Route::get('/orders/{id}/leads', [\App\Http\Controllers\OrdersController::class, 'show'])->middleware(['auth', 'manager'])->name('orders_leads');
Route::post('/orders/update', [\App\Http\Controllers\OrdersController::class, 'updateStatus'])->middleware(['auth', 'admin'])->name('update_order_status_custom');


Route::post('/orders/switch', ['as' => 'orders.add_order','uses' => '\App\Http\Controllers\OrdersController@switchS']);

//Лиды
Route::get('/leads', [\App\Http\Controllers\LeadController::class, 'index'])->middleware(['auth', 'manager'])->name('leads');
/*Route::post('/leads/create', [\App\Http\Controllers\LeadController::class, 'store'])->middleware(['auth', 'manager'])->name('leads_add');*/
Route::post('/leads/{id}/update', [\App\Http\Controllers\LeadController::class, 'update'])->middleware(['auth', 'manager'])->name('add_lead_to_order');

//Поиск
Route::get('/search/{find}', ['as' => 'search','uses' => '\App\Http\Controllers\SearchController@detail']);
/*Route::get('/search/edit/{find}', ['as' => 'search','uses' => '\App\Http\Controllers\SearchController@index']);*/



require __DIR__.'/auth.php';
