<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class typeUser
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
       
   
         if($user->type =='User'){
              
          return response()->json(['msg' => 'Not a User'], 401);
           
            }else{
                 return $next($request); 
            }
    }
   public function guard()
    {
        return Auth::guard();

    }
}


