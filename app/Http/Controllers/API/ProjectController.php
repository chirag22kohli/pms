<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Project;
use App\RestrictedUid;
use App\RecentProject;
use App\PaidProjectDetail;
use DB;
use Carbon\Carbon;
use App\UserUid;

class ProjectController extends Controller {

    public $successStatus = 200;

    /**
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function projectDetails(Request $request) {
        $validator = Validator::make($request->all(), [
                    'project_id' => 'required'
        ]);
        if ($validator->fails()) {
            $errors = self::formatValidator($validator);
            return parent::error($errors, 200);
            //return parent::error($validator->errors(), 200);
        }
        $projectDetails = Project::where('id', $request->input('project_id'))->first();
        if (count($projectDetails) > 0) {
            $createRecentHistory = parent::recentHistoryProject(Auth::id(), $request->input('project_id'));
            if ($projectDetails->project_type == 'paid') {
                $paidDetails = parent::checkProjectPaidStatus($request->input('project_id'));
                $projectDetails->paid_status = $paidDetails;
            }
            if ($projectDetails->project_type == 'restricted') {
                $uidDetails = UserUid::where('user_id', Auth::id())->where('project_id', $request->input('project_id'))->first();
                if (count($uidDetails) > 0) {
                    $uidStatus = true;
                } else {
                    $uidStatus = false;
                }
                $projectDetails->uid_status = $uidStatus;
            }
            $userDetails = User::where('id', $projectDetails->created_by)->first();
            $projectDetails->project_owner  = $userDetails;
            return parent::success($projectDetails, $this->successStatus);
        } else {
            return parent::error('Project Not Found', 200);
        }
    }

    public function projectType(Request $request) {
        $validator = Validator::make($request->all(), [
                    'project_type' => 'in:paid,restricted,public|required'
        ]);
        if ($validator->fails()) {
            $errors = self::formatValidator($validator);
            return parent::error($errors, 200);
            //  return parent::error($validator->errors(), 200);
        }
        $projectDetails = Project::where('project_type', $request->input('project_type'))->get();
        if (count($projectDetails) > 0) {
            return parent::success($projectDetails, $this->successStatus);
        } else {
            return parent::error('Project Not Found', 200);
        }
    }

    public function validateUid(Request $request) {
        $validator = Validator::make($request->all(), [
                    'project_id' => 'required',
                    'uid' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = self::formatValidator($validator);
            return parent::error($errors, 200);
        }
        $projectDetails = RestrictedUid::where('project_id', $request->input('project_id'))->where('uid', $request->input('uid'))->first();

        if (count($projectDetails) > 0) {

            $checkPreviousUsedUid = UserUid::where('uid', $request->input('uid'))->where('project_id', $request->input('project_id'))->first();
            if (count($checkPreviousUsedUid) > 0) {
                if ($checkPreviousUsedUid->user_id == Auth::id()) {
                    return parent::success($projectDetails, $this->successStatus);
                } else {
                    return parent::error('UID Already Used. Please contact project owner.', 200);
                }
            } else {
                UserUid::create([
                    'user_id' => Auth::id(),
                    'uid' => $request->input('uid'),
                    'project_id' => $request->input('project_id')
                ]);
                return parent::success($projectDetails, $this->successStatus);
            }
        } else {
            return parent::error('No UID Found', 200);
        }
    }

    public function myRecentProjects(Request $request) {


        $recentProjects = RecentProject::where('user_id', Auth::id())->with('project')->get();

        if (count($recentProjects) > 0) {
            return parent::success($recentProjects, $this->successStatus);
        } else {
            return parent::error('No Recent Projects Found', 200);
        }
    }

    public function trackerSupport(Request $request) {
        $validator = Validator::make($request->all(), [
                    'project_id' => 'required',
                    'tracker_id' => 'required',
                    'reason' => 'required'
        ]);
        if ($validator->fails()) {
            $errors = self::formatValidator($validator);
            return parent::error($errors, 200);
        }

        DB::insert('insert into tracker_support (user_id, tracker_id, project_id, reason, created_at) values (?, ?, ? ,?, ?)', [Auth::id(),
            $request->input('tracker_id'), $request->input('project_id'), $request->input('reason'), Carbon::now()]);


        return parent::success('Successfully sent your feedback.', $this->successStatus);
    }

}
