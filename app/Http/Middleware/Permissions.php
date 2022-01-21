<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Permissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next,$web_rouls)
    {


        foreach(explode('|',$web_rouls) as $key=>$value){
          if (collect(session()->get('user_data')['user_perm'])->where('PERMISSION_TB_ID',$value)->count() > 0) {
              return $next($request);
          }else
          {
            abort(403,'لا تمتلك الصلاحية للوصول الى هذه الصفحة');
          }
        }


    }
}
