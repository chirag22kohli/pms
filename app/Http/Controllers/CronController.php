<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Payer;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use Illuminate\Support\Facades\URL;
use PayPal\Api\Payment;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use PayPal\Api\PaymentExecution;
use Auth;
use App\UserPlan;
use Rap2hpoutre\LaravelStripeConnect\StripeConnect;
use stdClass;
use App\Plan;
use Carbon;
use App\PaidPlantHistory;
use App\Cron;
use App\Stripe;
use App\PaidProjectDetail;
use App\Project;
use App\PaidProjectHistoryDetail;
use App\UserScanPack;
class CronController extends Controller {

    public function __construct() {
        $date = Carbon\Carbon::now();
        $date = strtotime($date);
        $date = date('Y-m-d', $date);
        $this->date = $date;
        $this->successStatus = 200;
    }

    public function testCron() {
        Cron::create([
            'user_id' => 1,
            'date_logged' => $this->date,
            'message' => "Test",
            'params' => '',
            'plan_id' => 0,
            'success' => 1,
            'type' => 'Test'
        ]);
        return "success";
    }

    public function planCron() {
        $date = Carbon\Carbon::now();
        $date = strtotime($date);
        $date = date('Y-m-d', $date);
        $activePlans = UserPlan::where('plan_expiry_date', $date)->where('reoccuring_status', 1)->get();
        if (count($activePlans) > 0):

            foreach ($activePlans as $plan) {

                $user = \App\User::where('id', $plan['user_id'])->first();
                $this->renewPlan($user, $plan['plan_id']);
            }
        endif;
    }

    public function renewPlan($user, $plan_id) {

        $planId = $plan_id;
        $planInfo = Plan::where('id', $planId)->first();
        $superAdmin = \App\User::where('id', 2)->first();
        $charge = array();
        $success = 'true';
        if (count($planInfo) > 0) {

            $price = $planInfo->price;
            try {

                $charge = StripeConnect::transaction()
                        ->amount($price * 100, 'sgd')
                        ->useSavedCustomer()
                        ->from($user)
                        ->to($superAdmin)
                        ->create();
            } catch (\Exception $e) {

                $removeInvalidCustomer = Stripe::where('user_id', Auth::id())->update(['customer_id' => null]);
                $message = $e->getMessage();
                $success = 'false';
            }

            if (isset($charge->status) && $charge->status == 'succeeded') {

                $this->upgradePlan($charge, $user->id);
                $message = 'Renew Success';
            }

            Cron::create([
                'user_id' => $user->id,
                'date_logged' => $this->date,
                'message' => $message,
                'params' => json_encode($charge),
                'plan_id' => $planId,
                'success' => $success,
                'type' => 'Plan Renewal'
            ]);
        }
    }

    protected function upgradePlan($result, $userId) {
        $userId = $userId;
        $userPlan = UserPlan::where('user_id', $userId)->first();
        $planDetails = Plan::where('id', $userPlan->plan_id)->first();
        $expiryData = $this->getExpiryWithDate($planDetails->price_type, $userPlan->plan_expiry_date);
        $updateParams = UserPlan::where('user_id', $userId)->update([
            'payment_status' => 1,
            'payment_params' => json_encode($result),
            'plan_expiry_date' => $expiryData
        ]);


        $historyParams = [
            'payment_params' => json_encode($result),
            'user_id' => $userId,
            'plan_id' => $userPlan->plan_id,
            'previous_expiry_date' => $userPlan->plan_expiry_date,
            'expriy_date' => $expiryData,
            'payment_type' => 'Renewed Current Plan',
            'price_paid' => $planDetails->price
        ];
        PaidPlantHistory::create($historyParams);
    }

    protected function getExpiryWithDate($type, $planDate) {
        $date = $planDate;
        $date = strtotime($date);
        if ($type == 'weekly') {


            $date = strtotime("+7 day", $date);
        } elseif ($type == 'monthly') {
            $date = strtotime("+30 day", $date);
        } else {
            $date = strtotime("+365 day", $date);
        }
        $date = date('Y-m-d', $date);
        return $date;
    }

    public function projectCron() {

        $date = $this->date;
        $activeProjects = PaidProjectDetail::where('expriy_date', $date)->where('reoccuring_trigger', 1)->get();
        if (count($activeProjects) > 0):

            foreach ($activeProjects as $project) {

                $user = \App\User::where('id', $project['user_id'])->first();
                $returnStatus = $this->renewProject($user, $project->project_id);
                if ($returnStatus['status']) {
                    $charge = $returnStatus['params'];
                } else {
                    $charge = array();
                }

                Cron::create([
                    'user_id' => $user->id,
                    'date_logged' => $this->date,
                    'message' => $returnStatus['message'],
                    'params' => json_encode($charge),
                    'project_id' => $project->project_id,
                    'success' => $returnStatus['status'],
                    'type' => 'Project Renewal'
                ]);
            }
        endif;
    }

    protected function renewProject($user, $projectId) {

        $projectDetails = Project::where('id', $projectId)->first();
        if (count($projectDetails) > 0) {
            $productPrice = $projectDetails->price;
            $expiryDate = parent::getExpiryDate($projectDetails->billing_cycle);
            $projectAdmin = \App\User::where('id', $projectDetails->created_by)->first();

            try {

                $charge = StripeConnect::transaction()
                        ->amount($productPrice * 100, 'sgd')
                        ->useSavedCustomer()
                        ->from($user)
                        ->to($projectAdmin)
                        ->create();
            } catch (\Exception $e) {

                $removeInvalidCustomer = Stripe::where('user_id', $user->id)->update(['customer_id' => null]);
                return [
                    'status' => false,
                    'message' => $e->getMessage()
                ];
            }
            if ($charge->status == 'succeeded') {

                $paidParams = [
                    'user_id' => $user->id,
                    'project_id' => $projectId,
                    'project_admin_id' => $projectDetails->created_by,
                    'expriy_date' => $expiryDate,
                    'paid_price' => $productPrice,
                    'payment_params' => json_encode($charge),
                ];
                $checkPayment = PaidProjectDetail::where('user_id', $user->id)->where('project_id', $projectId)->first();

                if (count($checkPayment) > 0) {

                    $updatePayment = PaidProjectDetail::where('user_id', $user->id)->where('project_id', $projectId)->update($paidParams);

                    $createPaymentHistory = PaidProjectHistoryDetail::create($paidParams);
                } else {
                    $createPayment = PaidProjectDetail::create($paidParams);
                    $createPaymentHistory = PaidProjectHistoryDetail::create($paidParams);
                }
                return [
                    'status' => true,
                    'message' => 'Charged Successfully',
                    'params' => $paidParams,
                ];
            } else {
                $removeInvalidCustomer = Stripe::where('user_id', $user->id)->update(['customer_id' => null]);

                return [
                    'status' => false,
                    'message' => 'Some Issue in Making Charge, Please try again!',
                ];
            }
        } else {
            return [
                'status' => false,
                'message' => 'Project Not Found (Please select another project)',
            ];
        }
    }

    public function scanPackReset() {
        if (date('d') == '01') {
            UserScanPack::where('user_id','!=','2')->update([
                'limit_set'=>0,
                'used_limit'=>0,
                'total_scan_packs'=>0,
                'used_scan_packs'=>0
            ]);
            echo "done";
        }
    }

}
