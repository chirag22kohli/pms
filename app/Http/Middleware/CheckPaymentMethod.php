<?php

namespace App\Http\Middleware;

use Closure;
use App\Stripe;
use Auth;
use Illuminate\Http\Response;

class CheckPaymentMethod {

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

        $getUserPaymentMethod = Stripe::where('user_id', Auth::id())->first();

        if ($getUserPaymentMethod->customer_id !== null || $getUserPaymentMethod->customer_id != '') {
            return $next($request);
        }

        return new Response(view('client.addPaymentMethod'));
    }

}
