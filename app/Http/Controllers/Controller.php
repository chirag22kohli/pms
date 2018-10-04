<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Image;
use App\Tracker;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Stripe;

class Controller extends BaseController {

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;

    public function uploadFile($request, $fileName, $path) {
        $image = $request->file($fileName);
        //dd($_FILES);
        $input['imagename'] = time() . '.' . $image->getClientOriginalExtension();

        $destinationPath = public_path($path);

        //

        $thumb_img = Image::make($image->getRealPath())->resize(745, 550);
        $thumb_img->save($destinationPath . '/cropped/' . 'thu-' . $input['imagename'], 80);
        $image->move($destinationPath, $input['imagename']);
        return $path . '/cropped/' . 'thu-' . $input['imagename'];
    }

    public function uploadObjectFile($request, $fileName, $path) {
        $image = $request->file($fileName);
        //dd($_FILES);
        $input['imagename'] = time() . '.' . $image->getClientOriginalExtension();

        $destinationPath = public_path($path);

        //

        $thumb_img = Image::make($image->getRealPath())->resize(400, 400);
        $thumb_img->save($destinationPath . '/cropped/' . 'thu-' . $input['imagename'], 80);
        $image->move($destinationPath, $input['imagename']);
        //return $path . '/cropped/' .'thu-'. $input['imagename'];
        return $path . '/' . $input['imagename'];
    }

    public function uploadMediaFile($request, $fileName, $path) {
        $image = $request->file($fileName);
        //dd($_FILES);

        $input['imagename'] = time() . '.' . $image->getClientOriginalExtension();

        $destinationPath = public_path($path);

        $image->move($destinationPath, $input['imagename']);
        return $path . $input['imagename'];
    }

    public function checkDup($filePath) {
        $filename = $filePath;
        $sha1file = sha1_file($filename);
        $getSame = Tracker::where('sha', $sha1file)->first();
        if (count($getSame) > 0) {
            return false;
        } else {
            return true;
        }
    }

    public static function bytesToHuman($bytes) {
        $units = ['B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    public static function convertoMb($bytes) {
        $units = ['B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }
        if ($units[$i] == 'KiB'):
            $bytes = $bytes / 1024;
            $units[$i] = 'Mib';
        endif;
        return round($bytes, 2);
    }

    public static function usageInfoPlan() {
        $actionSpace = DB::table('actions')
                ->where('created_by', '=', Auth::id())
                ->sum('size');
        $objectSpace = DB::table('objects')
                ->where('created_by', '=', Auth::id())
                ->sum('size');

        $trackerSpace = DB::table('trackers')
                ->where('created_by', '=', Auth::id())
                ->sum('size');

        $finalSpace = $actionSpace + $objectSpace +$trackerSpace;
        return self::convertoMb($finalSpace);
    }

    public static function usageInfo() {
        $actionSpace = DB::table('actions')
                ->where('created_by', '=', Auth::id())
                ->sum('size');
        $objectSpace = DB::table('objects')
                ->where('created_by', '=', Auth::id())
                ->sum('size');
          $trackerSpace = DB::table('trackers')
                ->where('created_by', '=', Auth::id())
                ->sum('size');

        $finalSpace = $actionSpace + $objectSpace +$trackerSpace;
        return self::bytesToHuman($finalSpace);
    }

    public static function trackerCount() {
        $trackerCount = DB::table('trackers')
                ->where('created_by', '=', Auth::id())
                ->count();
        return $trackerCount;
    }

    public static function checkPlanUsage() {
        if (Auth::user()->roles[0]->name == 'Admin') {
            return [
                'status' => true,
                'message' => 'Storage Full, Please delete some objects to continue. You may upgrade to a new plan to continue adding more trackers',
                'plan_type' => 'size'
            ];
        }
        $userId = Auth::id();
        $getPlanDetails = \App\UserPlan::where('user_id', $userId)->first();
        $getPlanType = \App\Plan::where('id', $getPlanDetails->plan_id)->first();
        //for storage type
        if ($getPlanType->type == 'size') {
            $allowedStorage = $getPlanType->max_trackers;
            $usageInfo = self::usageInfoPlan();

            if ($usageInfo > $allowedStorage) {
                return [
                    'status' => false,
                    'message' => 'Storage Full, Please delete some objects to continue. You may upgrade to a new plan to continue get more storage.',
                    'plan_type' => $getPlanType->type
                ];
            } else {
                return [
                    'status' => true,
                    'message' => $usageInfo,
                    'plan_type' => $getPlanType->type
                ];
            }
        } elseif ($getPlanType->type == 'trackers_count') {
            $allowedTrackers = $getPlanType->max_trackers;
            $usageInfo = self::trackerCount();

            if ($usageInfo >= $allowedTrackers) {
                return [
                    'status' => false,
                    'message' => 'All Trackers for this plan is used. You may upgrade to a new plan to continue adding more trackers.',
                    'plan_type' => $getPlanType->type
                ];
            } else {
                return [
                    'status' => true,
                    'message' => $usageInfo,
                    'plan_type' => $getPlanType->type
                ];
            }
        }
    }

    public static function checkClientConnectedAccount(){
        if (Auth::user()->roles[0]->name == 'Admin') {
            return true;
        }
        $checkClientStripeConnect = Stripe::where('user_id',Auth::id())->where('account_id','!=',null)->first();
        if(count($checkClientStripeConnect)>0):
            return true;
        else:
            return false;
        endif;
    }
}
