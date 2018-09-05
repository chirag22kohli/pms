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
        } else {
            $date = strtotime("+365 day", $date);
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
            
            if($expiryDate < $date){
                return "false";
            }else{
                return "true";
            }
        } else {
            return "false";
        }
    }

}
