<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use DB;
use App\UserScanPack;
use App\Scanpack;
class ClientController extends Controller {

    public function home() {
        return view('client.home');
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
        $paidScanPacksHistory = \App\PaidScanPacksHistory::where('user_id',Auth::id())->get();
        return view('client.reports', [
            'userDetails' => $userDetails,
            'paidInfo' => $paidInfo,
            'totalPaid' => $totalPaid,
            'myTransactions' => $myTransactions,
            'paidScanPacksHistory'=>$paidScanPacksHistory
        ]);
    }

    public static function checkPlanUsage() {
        return parent::checkPlanUsage();
    }
    
    public function viewScanPack(){
     
        $getScanPack = UserScanPack::where('user_id',Auth::id())->first();
         return view('client.scanpack',['getScanPack' => $getScanPack]);
    }

}
