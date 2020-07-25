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
use App\Project;
use App\Scanpack;
use App\UserScanPack;

class PaymentController extends Controller {

    public function __construct() {
        /** PayPal api context * */
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
                        $paypal_conf['client_id'], $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);
    }

    public function payWithpaypal(Request $request) {
        $payer = new Payer();

        $payer->setPaymentMethod('paypal');
        $item_1 = new Item();
        $item_1->setName('Item 1') /** item name * */
                ->setCurrency('USD')
                ->setQuantity(1)
                ->setPrice($request->get('amount'));/** unit price * */
        $item_list = new ItemList();
        $item_list->setItems(array($item_1));
        $amount = new Amount();
        $amount->setCurrency('USD')
                ->setTotal($request->get('amount'));
        $transaction = new Transaction();
        $transaction->setAmount($amount)
                ->setItemList($item_list)
                ->setDescription('Your transaction description');
        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::route('status')) /** Specify return URL * */
                ->setCancelUrl(URL::route('status'));
        $payment = new Payment();
        $payment->setIntent('Sale')
                ->setPayer($payer)
                ->setRedirectUrls($redirect_urls)
                ->setTransactions(array($transaction));
        // dd($payment->create($this->_api_context));exit; 
        try {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            if (\Config::get('app.debug')) {
                \Session::put('error', 'Connection timeout');
                return Redirect::route('paywithpaypal');
            } else {
                \Session::put('error', 'Some error occur, sorry for inconvenient');
                return Redirect::route('paywithpaypal');
            }
        }
        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }
        /** add payment ID to session * */
        Session::put('paypal_payment_id', $payment->getId());
        if (isset($redirect_url)) {
            /** redirect to paypal * */
            return Redirect::away($redirect_url);
        }
        \Session::put('error', 'Unknown error occurred');
        return Redirect::route('paywithpaypal');
    }

    public function getPaymentStatus(Request $request) {

        /** Get the payment ID before session clear * */
        $payment_id = Session::get('paypal_payment_id');
        /** clear the session payment ID * */
        Session::forget('paypal_payment_id');
        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
            \Session::put('error', 'Payment failed');
            return Redirect::route('home');
        }
        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));
        /*         * Execute the payment * */
        $result = $payment->execute($execution, $this->_api_context);
        if ($result->getState() == 'approved') {
            \Session::put('success', 'Payment success');
            $this->assignPlan($request->all());
            return Redirect::route('home');
        }
        \Session::put('error', 'Payment failed');
        return Redirect::route('home');
    }

    protected function assignPlan($result) {
        $userId = Auth::id();
        $userPlan = UserPlan::where('user_id', $userId)->first();
        $planDetails = Plan::where('id', $userPlan->plan_id)->first();
        $expiryData = $this->getExpiryDate($planDetails->price_type);
        $updateParams = UserPlan::where('user_id', $userId)->update([
            'payment_status' => 1,
            'payment_params' => json_encode($result),
            'plan_expiry_date' => $expiryData
        ]);

        $historyParams = [
            'payment_params' => json_encode($result),
            'user_id' => Auth::id(),
            'plan_id' => $userPlan->plan_id,
            'expriy_date' => $expiryData,
            'payment_type' => 'Chap Signup and Plan Selection',
            'price_paid' => $planDetails->price
        ];
        PaidPlantHistory::create($historyParams);
        $getScanPack = Scanpack::first();
        $assignScanPack = UserScanPack::create([
                    'user_id' => Auth::id(),
                    'scan_pack_id' => $getScanPack->id,
                    'scans' => $getScanPack->scans,
                    'month' => date('m'),
                    'user_plan_id' => $userPlan->plan_id
        ]);
    }

    protected function upgradePlan($result) {
        $userId = Auth::id();
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
            'user_id' => Auth::id(),
            'plan_id' => $userPlan->plan_id,
            'previous_expiry_date' => $userPlan->plan_expiry_date,
            'expriy_date' => $expiryData,
            'payment_type' => 'Renewed Current Plan',
            'price_paid' => $planDetails->price
        ];
        PaidPlantHistory::create($historyParams);
    }

    protected function upgradeExpiredPlan($result) {
        $userId = Auth::id();
        $userPlan = UserPlan::where('user_id', $userId)->first();
        $planDetails = Plan::where('id', $userPlan->plan_id)->first();
        $expiryData = $this->getExpiryWithDate($planDetails->price_type, date('Y-m-d'));
        $updateParams = UserPlan::where('user_id', $userId)->update([
            'payment_status' => 1,
            'payment_params' => json_encode($result),
            'plan_expiry_date' => $expiryData
        ]);


        $historyParams = [
            'payment_params' => json_encode($result),
            'user_id' => Auth::id(),
            'plan_id' => $userPlan->plan_id,
            'previous_expiry_date' => $userPlan->plan_expiry_date,
            'expriy_date' => $expiryData,
            'payment_type' => 'Renewed Current Plan',
            'price_paid' => $planDetails->price
        ];

        //dd($historyParams);

        PaidPlantHistory::create($historyParams);
        //dd($historyParams);
    }

    public function payWithStripe(Request $request) {
        //  dd(Auth::user()->name);
        $token = $request->input('stripe');
        $price = $request->input('plan');
        //$customer = new \App\User();
        // return Auth::user();
        // $customer->user_id = Auth::id();
        $customer = StripeConnect::createCustomer($token['id'], Auth::user());


        //return $token['id'];
        $superAdmin = \App\User::where('id', 2)->first();


        try {
            $charge = $this->payToSuperAdmin($price, $customer->customer_id);
        } catch (\Exception $e) {
            return parent::error($e->getMessage(), $this->successStatus);
        }


        //$createVendor = StripeConnect::createAccount(Auth::user());
        if ($charge->status == 'succeeded') {
            $this->assignPlan($charge);

            return 'success';
        } else {
            return 'false';
        }

        // var_dump($createVendor);
    }

    protected function getExpiryDate($type) {
        $date = Carbon\Carbon::now();
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

    public function renewPlan(Request $request) {
        $planId = $request->input('plan_id');
        $planInfo = Plan::where('id', $planId)->first();
        $superAdmin = \App\User::where('id', 2)->first();

        if (count($planInfo) > 0) {

            $price = $planInfo->price;



            try {
                $customer = \App\Stripe::where('user_id', Auth::id())->first();
                $charge = $this->payToSuperAdmin($price, $customer->customer_id);
            } catch (\Exception $e) {
                return parent::error($e->getMessage(), $this->successStatus);
            }


            if ($charge->status == 'succeeded') {

                $this->upgradePlan($charge);

                return 'success';
            } else {
                return 'false';
            }
        }
    }

    public function renewExpiredPlan(Request $request) {
        $planId = $request->input('plan_id');
        $planInfo = Plan::where('id', $planId)->first();
        $superAdmin = \App\User::where('id', 2)->first();

        if (count($planInfo) > 0) {

            $price = $planInfo->price;
            try {
                $customer = \App\Stripe::where('user_id', Auth::id())->first();
                $charge = $this->payToSuperAdmin($price, $customer->customer_id);
            } catch (\Exception $e) {
                return parent::error($e->getMessage(), $this->successStatus);
            }

            if ($charge->status == 'succeeded') {

                $this->upgradeExpiredPlan($charge);
                return 'success';
            } else {
                return 'false';
            }
        }
    }

    public function addPaymentMethod(Request $request) {
        $token = $request->input('stripe');
        $price = 1;
        //$customer = new \App\User();
        // return Auth::user();
        // $customer->user_id = Auth::id();
        $clearPrevious = \App\Stripe::where('user_id', Auth::id())->update([
            'customer_id' => null,
            'account_id' => null
        ]);
        $customer = StripeConnect::createCustomer($token['id'], Auth::user());
        //return $token['id'];
        $superAdmin = \App\User::where('id', 2)->first();

        try {
            $customer = \App\Stripe::where('user_id', Auth::id())->first();
            $charge = $this->payToSuperAdmin($price, $customer->customer_id);
        } catch (\Exception $e) {
            return parent::error($e->getMessage(), $this->successStatus);
        }


        // $createVendor = StripeConnect::createAccount(Auth::user());
        if ($charge->status == 'succeeded') {

            return 'success';
        } else {
            return 'false';
        }
    }

    public function upgradePlanView() {
        $myPlan = UserPlan::where('user_id', Auth::id())->first();
        $getPlanDetails = Plan::where('id', $myPlan->plan_id)->first();
        $getSimilarPlans = Plan::where('type', $getPlanDetails->type)->where('price_type', $getPlanDetails->price_type)->where('price', '>', $getPlanDetails->price)->get();
        return view('client.upgradePlanView', ['planInfo' => $getPlanDetails, 'getSimilarPlans' => $getSimilarPlans]);
    }

    public function manageReoccurring() {
        $newStatus = 1;
        $userPlan = UserPlan::where('user_id', Auth::id())->first();
        $message = 'Thankyou for turning on the Re-occuring payments with us. We ensure you to provide the best AR Experience.';
        if ($userPlan->reoccuring_status == '1') {
            $newStatus = 0;
            $message = 'We have stopped your Re-occurring payments for this plan, However you can continue anytime.';
        } else {
            $newStatus = 1;
        }

        UserPlan::where('user_id', Auth::id())->update([
            'reoccuring_status' => $newStatus
        ]);
        return $message;
    }

    public function newSubscribeTrigger(Request $request) {
        $projectId = $request->get('id');
        $newStatus = 1;
        $userPlan = Project::where('id', $projectId)->first();
        $message = 'Thankyou for turning on the new subscribers trigger. The more users subscribe, the more you earn. Happy AR!';
        if ($userPlan->newSubscribeTrigger == '1') {
            $newStatus = 0;
            $message = 'We have stopped to add new subscribers to this project , However you can continue anytime.';
        } else {
            $newStatus = 1;
        }

        Project::where('id', $projectId)->update([
            'newSubscribeTrigger' => $newStatus
        ]);
        return $message;
    }

    public function upgradeNow(Request $request) {
        $planId = base64_decode($request->get('id'));
        $getNewPlan = Plan::where('id', $planId)->first();

        if (count($getNewPlan) > 0) {
            $updgradeData = self::getNewPlanPrice($planId);
            return view('client.upgradeNow', [
                'planInfo' => $getNewPlan,
                'newPayment' => $updgradeData['newPayment'],
                'expiry_date' => $updgradeData['expiry_date']
            ]);
        } else {
            return redirect('client/upgradePlanView');
        }
    }

    public static function countTypeDays($type) {
        if ($type == 'weekly') {
            return 7;
        }
        if ($type == 'monthly') {
            return 30;
        }
        if ($type == 'yearly') {
            return 365;
        }

        if ($type == 'daily') {
            return 2;
        }
    }

    public function upgradeNowPlan(Request $request) {
        $planId = $request->input('plan_id');

        $newChargeDetails = self::getNewPlanPrice($planId);

        $planInfo = Plan::where('id', $planId)->first();
        $superAdmin = \App\User::where('id', 2)->first();

        if (count($planInfo) > 0) {

            $price = $planInfo->price;
            try {
                $customer = \App\Stripe::where('user_id', Auth::id())->first();
                $charge = $this->payToSuperAdmin($price, $customer->customer_id);
            } catch (\Exception $e) {
                return parent::error($e->getMessage());
            }

            if ($charge->status == 'succeeded') {

                $this->upgradePlanNew($request->input('plan_id'), $charge, $newChargeDetails['newPayment']);

                return 'success';
            } else {
                return 'false';
            }
        }
    }

    protected function upgradePlanNew($planId, $charge, $price) {
        $updatePlan = UserPlan::where('user_id', Auth::id())->update([
            'plan_id' => $planId,
            'payment_params' => json_encode($charge)
        ]);
        $newPlan = UserPlan::where('user_id', Auth::id())->where('plan_id', $planId)->first();
        $historyParams = [
            'payment_params' => json_encode($charge),
            'user_id' => Auth::id(),
            'plan_id' => $planId,
            'expriy_date' => $newPlan->plan_expiry_date,
            'payment_type' => 'Upgraded to a New Plan',
            'price_paid' => $price
        ];
        PaidPlantHistory::create($historyParams);
    }

    public static function getNewPlanPrice($newPlanId) {
        $getNewPlan = Plan::where('id', $newPlanId)->first();
        $myPlan = UserPlan::where('user_id', Auth::id())->first();
        $getPlanDetails = Plan::where('id', $myPlan->plan_id)->first();
        $dayDiffrence = $myPlan->plan_expiry_date;
        $created = new Carbon\Carbon($dayDiffrence);
        $now = Carbon\Carbon::now();
        $difference = $created->diff($now)->days;
        $getPlanTypeDaysCount = self::countTypeDays($getPlanDetails->price_type);
        $perdaycostofcurrent = $getPlanDetails->price / $getPlanTypeDaysCount;
        $totalAlreadyPaidByUser = $perdaycostofcurrent * $difference;




        //New Plan Price till expiry date

        $newPlanPrice = $getNewPlan->price;
        $getNewPlanTypeDaysCount = self::countTypeDays($getNewPlan->price_type);
        $newPlanPerDayCost = $newPlanPrice / $getNewPlanTypeDaysCount;
        $newPayment = $newPlanPerDayCost * $difference;
        $newPayment = $newPayment - $totalAlreadyPaidByUser;
        return [
            'planInfo' => $getNewPlan,
            'newPlanId' => $getNewPlan->id,
            'newPayment' => round($newPayment, 2),
            'expiry_date' => $dayDiffrence
        ];
    }

    public function testPayment(Request $request) {
        $superAdmin = \App\User::where('id', $request->input('id'))->first();
        //dd(Auth::user());
        $price = 10;
        try {
            $customer = \App\Stripe::where('user_id', Auth::id())->first();
            $charge = $this->payToSuperAdmin($price, $customer->customer_id);
        } catch (\Exception $e) {
            return parent::error($e->getMessage(), $this->successStatus);
        }
        return $charge;
    }

    public function payToSuperAdmin($amount, $from) {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        return $charge = \Stripe\Charge::create(array(
                    'customer' => $from,
                    'amount' => $amount * 100,
                    'currency' => 'sgd'
        ));
    }

    
    public function getAllCards($customer_id){
        
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $cards = \Stripe\Customer::allSources(
                        $customer_id,
                        ['object' => 'card', 'limit' => 20]
        );
        
    }
}
