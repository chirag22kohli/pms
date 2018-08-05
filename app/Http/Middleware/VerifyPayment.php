<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\UserPlan;
use Illuminate\Http\Response;
use App\Plan;
class VerifyPayment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        $getUserPlan = UserPlan::where('user_id',Auth::id())->first();
        
        if ($getUserPlan->payment_status == 1) {
            return $next($request);
        }
        $getPlanDetails = Plan::where('id',$getUserPlan->plan_id)->first();
       
       return new Response(view('clientSignup.payment',['plan'=>$getPlanDetails]));
    }

   
}
