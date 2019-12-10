<?php

namespace App\Http\Controllers\admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Plan;
use Illuminate\Http\Request;
use App\UserPlan;
use Auth;
use Carbon\Carbon;
use App\Stripe;
use App\Role;
use DB;

class PlansController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request) {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $plans = Plan::where('name', 'LIKE', "%$keyword%")
                    ->orWhere('type', 'LIKE', "%$keyword%")
                    ->orWhere('max_trackers', 'LIKE', "%$keyword%")
                    ->orWhere('max_projects', 'LIKE', "%$keyword%")
                    ->orWhere('price', 'LIKE', "%$keyword%")
                    ->orWhere('price_type', 'LIKE', "%$keyword%")
                    ->orWhere('status', 'LIKE', "%$keyword%")
                    ->orWhere('created_by', 'LIKE', "%$keyword%")
                    ->paginate($perPage);
        } else {
            $plans = Plan::paginate($perPage);
        }

        return view('admin.plans.index', compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create() {
        return view('admin.plans.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request) {

        $requestData = $request->all();
        Plan::create($requestData);

        return redirect('plans')->with('flash_message', 'Plan added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id) {
        $plan = Plan::findOrFail($id);

        return view('admin.plans.show', compact('plan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id) {
        $plan = Plan::findOrFail($id);

        return view('admin.plans.edit', compact('plan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id) {

        $requestData = $request->all();

        $plan = Plan::findOrFail($id);
        $plan->update($requestData);

        return redirect('plans')->with('flash_message', 'Plan updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id) {
        Plan::destroy($id);

        return redirect('plans')->with('flash_message', 'Plan deleted!');
    }

    public function planinfo(Request $request) {

        if ($request->get('code') && $request->get('code') != ''):
//die();

            $data = [
                'client_secret' => env("STRIPE_SECRET"),
                'code' => $request->get('code'),
                'grant_type' => 'authorization_code'
            ];

            $strieResposnes = json_decode(self::getStripeConnectAccount($data));
            if (!empty($strieResposnes->error)):
                //$request->session()->flash('alert-danger', 'There was some issue while conneting your stripe account. Please try again.');
                $request->session()->flash('alert-danger', $strieResposnes->error_description);

            else:
                $updateAccountStripe = Stripe::where('user_id', Auth::id())->update([
                    'account_id' => $strieResposnes->stripe_user_id
                ]);
                $request->session()->flash('alert-success', 'Your stripe account is successfully connected.');
            endif;


        endif;
        $userPlan = UserPlan::where('user_id', Auth::id())->first();
        //   return $userPlan;
        $planInfo = Plan::where('id', $userPlan->plan_id)->first();
        $dayDiffrence = $userPlan->plan_expiry_date;

        $usageInfo = parent::usageInfo();
        $created = new Carbon($dayDiffrence);
        $now = Carbon::now();
        $trackerCount = parent::trackerCount();
        //return parent::checkPlanUsage();

        $difference = ($created->diff($now)->days < 1) ? 'today' : $created->diffForHumans($now);
        return view('client.planinfo', [
            'userPlan' => $userPlan,
            'planInfo' => $planInfo,
            'difference' => $difference,
            'usageInfo' => $usageInfo,
            'trackerCount' => $trackerCount,
            'connectStatus' => parent::checkClientConnectedAccount()
        ]);
    }

    protected static function getStripeConnectAccount($data) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://connect.stripe.com/oauth/token ");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

// In real life you should use something like:
// curl_setopt($ch, CURLOPT_POSTFIELDS, 
//          http_build_query(array('postvar1' => 'value1')));
// Receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);

        curl_close($ch);
        return $server_output;
    }

    public function choosePlan(Request $request) {
        $planId = $request->input('plan_id');

        $selectClientRole = Role::where('name', 'Client')->first();
        $assignRole = DB::table('role_user')->where('user_id', Auth::id())->update(
                ['role_id' => $selectClientRole->id]
        );
        UserPlan::create([
            'user_id' => Auth::id(),
            'plan_id' => $planId,
            'payment_status' => 0,
            'created_by' => $planId
        ]);
        return "success";
    }

}
