<?php

namespace App\Http\Middleware;

use Auth;
use App\UserPlan;
use Illuminate\Http\Response;
use App\Plan;
use Closure;

class PlanExpiry {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        if (Auth::user()->hasRole('Admin')) {
            return $next($request);
        }
        $getUserPlan = UserPlan::where('user_id', Auth::id())->first();

        if ($getUserPlan->plan_expiry_date < date('Y-m-d')) {
            //$plans = Plan::all();

            return new Response(view('client.planExpiry'));
        }
        return $next($request);
    }

}
