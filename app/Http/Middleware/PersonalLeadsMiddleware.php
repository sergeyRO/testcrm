<?php

namespace App\Http\Middleware;

use App\Models\OrdersModel;
use Closure;
use Illuminate\Http\Request;

class PersonalLeadsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        $order = OrdersModel::getOrder($request->route()->parameter('id'));

        if(!empty($order)) {
            if(auth()->user()->id != $order[0]['id_creator']) {
                abort(403);
            }
        }

        return $next($request);
    }
}
