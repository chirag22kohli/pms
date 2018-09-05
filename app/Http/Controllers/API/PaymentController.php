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
                        ->amount($productPrice * 100, 'usd')
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
                    'paid_price'=>$productPrice,
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
                return parent::success('Charged Successfully', $this->successStatus);
            } else {
                $removeInvalidCustomer = Stripe::where('user_id', Auth::id)->update(['customer_id' => null]);
                return parent::error('Some Issue in Making Charge, Please try again!', $this->successStatus);
            }
        } else {
            return parent::error('Project Not Found (Please select another project)', $this->successStatus);
        }
    }

}
