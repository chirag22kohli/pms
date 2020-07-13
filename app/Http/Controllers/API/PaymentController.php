<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use DB;
use App\Role;
use App\Contactandevents;
use App\Stripe;
use Rap2hpoutre\LaravelStripeConnect\StripeConnect;
use stdClass;
use App\Plan;
use Carbon;
use App\Project;
use App\PaidProjectDetail;
use App\PaidProjectHistoryDetail;
use App\RecentProject;

class PaymentController extends Controller {

    public $successStatus = 200;

    public function checkPaymentMethod(Request $request) {


        $details = Stripe::where('user_id', Auth::id())->first();

        if (count($details) > 0) {

            if ($details->customer_id != '') {
                return parent::success($details, $this->successStatus);
            } else {
                return parent::error('No Payment Method Found', $this->successStatus);
            }
        } else {
            return parent::error('No Payment Method Found', $this->successStatus);
        }
    }

    public function deductPayment(Request $request) {
        $validator = Validator::make($request->all(), [
                    'project_id' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = self::formatValidator($validator);
            return parent::error($errors, 200);
        }


        if ($request->input('token') != '') {

            try {
                $removeInvalidCustomer = Stripe::where('user_id', Auth::id())->update(['customer_id' => null]);
                $customer = StripeConnect::createCustomer($request->input('token'), Auth::user());
            } catch (\Exception $e) {
                return parent::error($e->getMessage(), $this->successStatus);
            }
        }

        $projectDetails = Project::where('id', $request->input('project_id'))->first();
        if (count($projectDetails) > 0) {
            $productPrice = $projectDetails->price;
            $expiryDate = parent::getExpiryDate($projectDetails->billing_cycle);
            $projectAdmin = \App\User::where('id', $projectDetails->created_by)->first();

            try {

                $charge = StripeConnect::transaction()
                        ->amount($productPrice * 100, 'sgd')
                        ->useSavedCustomer()
                        ->from(Auth::user())
                        ->to($projectAdmin)
                        ->create();
            } catch (\Exception $e) {

                $removeInvalidCustomer = Stripe::where('user_id', Auth::id())->update(['customer_id' => null]);
                return parent::error($e->getMessage(), $this->successStatus);
            }
            if ($charge->status == 'succeeded') {

                $paidParams = [
                    'user_id' => Auth::id(),
                    'project_id' => $request->input('project_id'),
                    'project_admin_id' => $projectDetails->created_by,
                    'expriy_date' => $expiryDate,
                    'paid_price' => $productPrice,
                    'payment_params' => json_encode($charge),
                ];
                $checkPayment = PaidProjectDetail::where('user_id', Auth::id())->where('project_id', $request->input('project_id'))->first();

                if (count($checkPayment) > 0) {

                    $updatePayment = PaidProjectDetail::where('user_id', Auth::id())->where('project_id', $request->input('project_id'))->update($paidParams);

                    $createPaymentHistory = PaidProjectHistoryDetail::create($paidParams);
                    $createRecentHistory = parent::recentHistoryProject(Auth::id(), $request->input('project_id'));
                } else {
                    $createPayment = PaidProjectDetail::create($paidParams);
                    $createPaymentHistory = PaidProjectHistoryDetail::create($paidParams);
                    $createRecentHistory = parent::recentHistoryProject(Auth::id(), $request->input('project_id'));
                }
                return parent::success('Payment Successful. Paid projects are set to auto-renew by default. You may change this by going to the Projects Section of the Navigation Bar.', $this->successStatus);
            } else {
                $removeInvalidCustomer = Stripe::where('user_id', Auth::id)->update(['customer_id' => null]);
                return parent::error('Some Issue in Making Charge, Please try again!', $this->successStatus);
            }
        } else {
            return parent::error('Project Not Found (Please select another project)', $this->successStatus);
        }
    }

    public function getAllCards(Request $request) {

        $userStripe = Stripe::where('user_id', Auth::id())->first();
       // dd($userStripe);
        if ($userStripe) {


            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            $cards = \Stripe\Customer::allSources(
                            $userStripe->customer_id,
                            ['object' => 'card', 'limit' => 20]
            );

            if (count($cards) > 0) {
                return parent::success($cards, $this->successStatus);
            } else {
                return parent::error('No Cards Found)', $this->successStatus);
            }
        } else {
            return parent::error('No Payment Method Found', $this->successStatus);
        }
    }

    public function createCard(Request $request) {

        $validator = Validator::make($request->all(), [
                    'token' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = self::formatValidator($validator);
            return parent::error($errors, 200);
        }
        $userStripe = Stripe::where('user_id', Auth::id())->first();

        if ($userStripe) {
            try {
                 \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

                $card = \Stripe\Customer::createSource(
                                $userStripe->customer_id,
                                ['source' => $request->token]
                );
            } catch (\Exception $e) {
                return parent::error($e->getMessage(), $this->successStatus);
            }
        } else {
            try {
                $customer = StripeConnect::createCustomer($request->token, Auth::user());
            } catch (\Exception $e) {
                return parent::error($e->getMessage(), $this->successStatus);
            }
        }

        return parent::success("Payment Method Added Successfully", $this->successStatus);
    }
    
    
    public function updateDefaultCard(Request $request){
        try {
            
            $user = Stripe::where('user_id', Auth::id())->first();
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            $customer = \Stripe\Customer::retrieve($user->customer_id);
            $customer->default_source = $request->card_id;
            $customer->save();
            return parent::successCreated(['message' => 'Updated Successfully']);
        } catch (\Exception $ex) {
            return parent::error($ex->getMessage());
        }
    }

}
