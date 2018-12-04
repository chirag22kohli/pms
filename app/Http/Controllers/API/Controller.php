<?php

namespace App\Http\Controllers\API;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Image;
use Carbon;
use App\RecentProject;
use App\PaidProjectDetail;
use Illuminate\Support\Facades\Auth;
use App\Scanpack;
use App\UserScanPack;
use Rap2hpoutre\LaravelStripeConnect\StripeConnect;

class Controller {

    public static function error($validatorMessage, $errorCode = 422, $messageIndex = false) {
        if ($messageIndex === true):
            $validatorMessage = ['message' => [$validatorMessage]];
        else:
            $validatorMessage = ['message' => $validatorMessage];
        endif;
        return response()->json(['status' => false, 'data' => (object) [], 'error' => ['code' => $errorCode, 'error_message' => $validatorMessage]], $errorCode);
    }

    public static function success($data, $code = 200) {
//        print_r($data);die;
        return response()->json(['status' => true, 'code' => $code, 'data' => (object) $data], $code);
    }

    public static function successCreated($data, $code = 201) {
        return response()->json(['status' => true, 'code' => $code, 'data' => (object) $data], $code);
    }

    public function formatValidator($validator) {
        $messages = $validator->getMessageBag();
        foreach ($messages->keys() as $key) {
            $errors[] = $messages->get($key)['0'];
        }
        return $errors[0];
    }

    protected function getExpiryDate($type) {
        $date = Carbon\Carbon::now();
        $date = strtotime($date);
        if ($type == 'weekly') {


            $date = strtotime("+7 day", $date);
        } elseif ($type == 'monthly') {
            $date = strtotime("+30 day", $date);
        } elseif ($type == 'yearly') {
            $date = strtotime("+365 day", $date);
        } elseif ($type == 'daily') {
            $date = strtotime("+1 day", $date);
        }
        $date = date('Y-m-d', $date);
        return $date;
    }

    public static function recentHistoryProject($user_id = 0, $project_id = 0) {
        $checkRecent = RecentProject::where('user_id', $user_id)->where('project_id', $project_id)->first();
        if (count($checkRecent) > 0):
            return true;
        else:

            RecentProject::create(['user_id' => $user_id, 'project_id' => $project_id]);
            return true;
        endif;
    }

    public static function checkProjectPaidStatus($project_id = 0) {
        $paidDetail = PaidProjectDetail::where('user_id', Auth::id())->where('project_id', $project_id)->first();

        if (count($paidDetail) > 0) {
            $date = Carbon\Carbon::now();
            $date = strtotime($date);
            $expiryDate = strtotime($paidDetail->expriy_date);

            if ($expiryDate < $date) {
                return "false";
            } else {
                return "true";
            }
        } else {
            return "false";
        }
    }

    public static function checkProjectExpiryDate($project_id = 0) {
        $paidDetail = PaidProjectDetail::where('user_id', Auth::id())->where('project_id', $project_id)->first();

        if (count($paidDetail) > 0) {
            return $paidDetail->expriy_date;
        } else {
            return "0";
        }
    }

    public static function updateScanPack($projectOwner) {

        $userId = $projectOwner;
        $getScanPack = Scanpack::first();
        $scanpackPrice = $getScanPack->price;
        $scanpackAllowed = $getScanPack->scans;

        $updateLimit = UserScanPack::where('user_id', $userId)->first();
        $scanPacksTotal = $updateLimit->total_scan_packs;
        $scanPacksLeft = $scanPacksTotal - $updateLimit->used_scan_packs;
        $projectAdmin = \App\User::where('id', '2')->first();
        $projectOwner = \App\User::where('id', $userId)->first();
        if ($scanPacksLeft > 0 && $updateLimit->scans == 0) {
            try {

                $charge = StripeConnect::transaction()
                        ->amount($scanpackPrice * 100, 'sgd')
                        ->useSavedCustomer()
                        ->from($projectOwner)
                        ->to($projectAdmin)
                        ->create();
            } catch (\Exception $e) {

                $removeInvalidCustomer = Stripe::where('user_id', $userId)->update(['customer_id' => null]);
                return false;
            }

            if ($charge->status == 'succeeded') {
                $historyParams = [
                    'payment_params' => json_encode($charge),
                    'user_id' => $userId,
                    'scan_pack_id' => $getScanPack->id,
                    'date_purchased' => date('Y-m-d'),
                    'payment_type' => 'Scan Pack Upgraded',
                    'price_paid' => $scanpackPrice,
                    'scans_credited' => $scanpackAllowed,
                    'payment_status' => 1
                ];
                \App\PaidScanPacksHistory::create($historyParams);
                $newUsedLimit = $updateLimit->used_limit + $scanpackPrice;
                $deductScanPackLimit = $updateLimit->total_scan_packs - 1;
                $usedScanPacks = $updateLimit->used_scan_packs + 1;
                $updateUserScanPack = UserScanPack::where('user_id', $userId)->update([
                    'scans_used' => 0,
                    'used_limit' => $newUsedLimit,
                    'scans' => $scanpackAllowed,
                    'total_scan_packs' => $deductScanPackLimit,
                    'used_scan_packs' => $usedScanPacks
                ]);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}
