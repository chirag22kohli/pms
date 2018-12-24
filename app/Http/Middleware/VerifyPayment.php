<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\UserPlan;
use Illuminate\Http\Response;
use App\Plan;

class VerifyPayment {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next) {



        if (Auth::user()->hasRole('Admin')) {
            return $next($request);
        }


        $getUserPlan = UserPlan::where('user_id', Auth::id())->first();
        if (!$getUserPlan) {
            $plans = Plan::all();
            return new Response(view('home.choosePlan', ['plans' => $plans]));
        }
        if ($getUserPlan->payment_status == 1) {
            return $next($request);
        }
        $getPlanDetails = Plan::where('id', $getUserPlan->plan_id)->first();

        return new Response(view('clientSignup.payment', ['plan' => $getPlanDetails]));
    }

}
