<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Plan;
class WelcomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
   public function welcome() {
       $plans = Plan::all();
      
        return view('home.welcome',['plans' => $plans]);
   }
  public function register($plan_id){
      
      return view('home.register',['plan_id'=> base64_decode($plan_id)]);
  }
    
}
