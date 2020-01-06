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
        $dayDiffrence = date('d/m/Y', strtotime($userPlan->plan_expiry_date));


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

        $getUserScan = DB::select("SELECT name,count(*) as uniquess, SUM(user_project_scans.count) as totalcount
FROM user_project_scans

LEFT JOIN projects
ON user_project_scans.project_id = projects.id
WHERE user_project_scans.project_owner_id = " . Auth::id() . " group by user_project_scans.user_id
;");

        $projectReport = DB::select("SELECT *,SUM(paid_price) as totalSum,COUNT(DISTINCT  user_id) as totalSubs FROM  `paid_project_history_details`  LEFT JOIN projects ON paid_project_history_details.project_id = projects.id WHERE paid_project_history_details.project_admin_id =  " . Auth::id() . " GROUP BY paid_project_history_details.project_id");



        return view('client.reports', [
            'userDetails' => $userDetails,
            'paidInfo' => $paidInfo,
            'totalPaid' => $totalPaid,
            'myTransactions' => $myTransactions,
            'paidScanPacksHistory' => $paidScanPacksHistory,
            'getUserScan' => $getUserScan,
            'projectReport' => $projectReport
        ]);
    }

    public function getFinances(Request $request) {
        if ($request->input('startDate') == $request->input('endDate')) {



            $totalExpenseSubscription = \App\PaidPlantHistory::where('user_id', Auth::id())->whereDate('created_at', $request->input('startDate'))->sum('price_paid');
            $totalExpenseScanPacks = \App\PaidScanPacksHistory::where('user_id', Auth::id())->whereDate('created_at', $request->input('startDate'))->sum('price_paid');

            $totalEarned = DB::table('paid_project_history_details')
                    ->where('project_admin_id', '=', Auth::id())
                    ->whereDate('created_at', $request->input('startDate'))
                    ->sum('paid_price');
        } else {



            $totalExpenseScanPacks = \App\PaidScanPacksHistory::where('user_id', Auth::id())->whereBetween('created_at', [$request->input('startDate'), $request->input('endDate')])->sum('price_paid');

            $totalExpenseSubscription = \App\PaidPlantHistory::where('user_id', Auth::id())->whereBetween('created_at', [$request->input('startDate'), $request->input('endDate')])->sum('price_paid');

            $totalEarned = DB::table('paid_project_history_details')
                    ->where('project_admin_id', '=', Auth::id())
                    ->whereBetween('created_at', [$request->input('startDate'), $request->input('endDate')])
                    ->sum('paid_price');
        }


        return view('client.finances', ['totalExpenseSubscription' => $totalExpenseSubscription, 'totalExpenseScanPacks' => $totalExpenseScanPacks, 'totalEarned' => $totalEarned]);
    }

    public static function checkPlanUsage() {
        return parent::checkPlanUsage();
    }

    public function viewScanPack() {

        $getScanPack = UserScanPack::where('user_id', Auth::id())->first();
        $scanPackDetails = Scanpack::first();
        return view('client.scanpack', ['getScanPack' => $getScanPack, 'scanPackDetails' => $scanPackDetails]);
    }

    public function getPaidProjectGraphData() {
        // { x: new Date(2017, 0), y: 25060 },
        $data = DB::select('select sum(paid_price), Month(created_at), Year(created_at) FROM `paid_project_history_details` where project_admin_id = ? GROUP BY  MONTH(created_at)', [Auth::id()]);

        return response()->json($data);
    }

    public function ecommerce() {
        $userPlan = UserPlan::where('user_id', Auth::id())->first();
        $planInfo = Plan::where('id', $userPlan->plan_id)->first();
        $connectStatus = parent::checkClientConnectedAccount();

        if ($planInfo->is_ecom == '1') {
            $productCount = \App\Product::where('user_id', Auth::id())->get()->count();
            $categoryCount = \App\ProductCategory::where('user_id', Auth::id())->get()->count();
            $ordersCount = \App\Order::where('client_id', Auth::id())->get()->count();
            return view('client.ecommerce', compact('productCount', 'categoryCount', 'ordersCount', 'connectStatus'));
        } else {
            return view('client.mayDay');
        }
    }

    public function editAttribute(Request $request) {
        $getAttributes = \App\ProductOption::where('id', $request->input('id'))->get();
        return view('client.editAttribute', compact('getAttributes'));
    }

    public function attributeForm(Request $request) {
        \App\ProductOption::where('id', $request->input('id'))->update(
                [
                    'attribute' => $request->input('attribute')
                ]
        );
    }

    public function settings() {
        return view('client.settings');
    }

}
