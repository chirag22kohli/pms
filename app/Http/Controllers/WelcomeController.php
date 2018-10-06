<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Plan;
use Validator;
use App\Metum;
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
    
   public function getMetas(Request $request) {
          
        $validator = Validator::make($request->all(), [
                    'meta_name' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = self::formatValidator($validator);
            return parent::error($errors, 200);
        }
        $details = Metum::where('meta_name', $request->input('meta_name'))->first();
        if (count($details) > 0) {
            return parent::success($details,200);
        } else {
            return parent::error('No ' . $request->input('meta_name') . ' Found', 200);
        }
    }
      public function formatValidator($validator) {
        $messages = $validator->getMessageBag();
        foreach ($messages->keys() as $key) {
            $errors[] = $messages->get($key)['0'];
        }
        return $errors[0];
    }
}
