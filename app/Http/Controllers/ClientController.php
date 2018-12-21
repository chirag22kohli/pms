<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use DB;
use App\UserScanPack;
use App\Scanpack;
use App\userProjectScan;
use App\Plan;
use App\UserPlan;

class ClientController extends Controller {

    public function home() {
        $getScanPack = UserScanPack::where('user_id', Auth::id())->first();
        $userPlan = UserPlan::where('user_id', Auth::id())->first();
        $planInfo = Plan::where('id', $userPlan->plan_id)->first();
        $dayDiffrence = $userPlan->plan_expiry_date;

        return view('client.home', ['getScanPack' => $getScanPack, 'expiryDate' => $dayDiffrence, 'userPlan' => $userPlan]);
    }

    public function profile() {
        $userDetails = User::where('id', Auth::id())->first();
        return view('client.profile', [
            'userDetails' => $userDetails
        ]);
    }

    public function updateProfile(Request $request) {
        $data = request()->except(['_token']);
        User::where('id', Auth::id())->update($data);
        return redirect('client/profile')->with('message', 'Profile has been updated!');
    }

    public function reports() {
        $userDetails = User::where('id', Auth::id())->first();
        $paidInfo = \App\PaidProjectHistoryDetail::where('project_admin_id', Auth::id())->with('userDetail')->with('projectDetail')->get();
        $totalPaid = DB::table('paid_project_history_details')
                ->where('project_admin_id', '=', Auth::id())
                ->sum('paid_price');
        $myTransactions = \App\PaidPlantHistory::where('user_id', Auth::id())->with('plan')->get();
        $paidScanPacksHistory = \App\PaidScanPacksHistory::where('user_id', Auth::id())->get();

        $getUserScan = userProjectScan::where('project_owner_id', Auth::id())->with('project_detail')->with('project_user')->get();



        return view('client.reports', [
            'userDetails' => $userDetails,
            'paidInfo' => $paidInfo,
            'totalPaid' => $totalPaid,
            'myTransactions' => $myTransactions,
            'paidScanPacksHistory' => $paidScanPacksHistory,
            'getUserScan' => $getUserScan
        ]);
    }

    public function getFinances(Request $request) {
        if ($request->input('startDate') == $request->input('endDate')) {



            $totalExpenseSubscription = \App\PaidPlantHistory::where('user_id', Auth::id())->whereDate('created_at', $request->input('startDate'))->sum('price_paid');
            $totalExpenseScanPacks = \App\PaidScanPacksHistory::where('user_id', Auth::id())->whereDate('created_at', $request->input('startDate'))->sum('price_paid');
        } else {



            $totalExpenseScanPacks = \App\PaidScanPacksHistory::where('user_id', Auth::id())->whereBetween('created_at', [$request->input('startDate'), $request->input('endDate')])->sum('price_paid');

            $totalExpenseSubscription = \App\PaidPlantHistory::where('user_id', Auth::id())->whereBetween('created_at', [$request->input('startDate'), $request->input('endDate')])->sum('price_paid');
        }


        return view('client.finances', ['totalExpenseSubscription' => $totalExpenseSubscription, 'totalExpenseScanPacks'=> $totalExpenseScanPacks ]);
    }

    public static function checkPlanUsage() {
        return parent::checkPlanUsage();
    }

    public function viewScanPack() {

        $getScanPack = UserScanPack::where('user_id', Auth::id())->first();
        return view('client.scanpack', ['getScanPack' => $getScanPack]);
    }

    public function getPaidProjectGraphData() {
        // { x: new Date(2017, 0), y: 25060 },
        $data = DB::select('select sum(paid_price), Month(created_at), Year(created_at) FROM `paid_project_history_details` where project_admin_id = ? GROUP BY  MONTH(created_at)', [Auth::id()]);

        return response()->json($data);
    }

}
