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
use Carbon;
use App\UserUid;
use App\UserScanPack;

class ProjectController extends Controller {

    public function __construct() {
        $date = Carbon\Carbon::now();
        $date = strtotime($date);
        $date = date('Y-m-d', $date);
        $this->date = $date;
    }

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
        $projectDetails = Project::where('id', $request->input('project_id'))->where('status', 1)->first();

        if (count($projectDetails) > 0) {

            $userDetails = User::where('id', $projectDetails->created_by)->first();
            if (!$projectDetails->newSubscribeTrigger):
                if ($projectDetails->project_type == 'paid') {

                    $paymentDetails = PaidProjectDetail::where('user_id', Auth::id())->where('project_id', $request->input('project_id'))->first();
                    // dd( $this->date);
                    if (count($paymentDetails) > 0 && strtotime($paymentDetails->expriy_date) >= strtotime($this->date)) {
                        // All Good
                    } else {
                        return parent::error('Project Owner has turned off new Subscriptions for the project. For enquiries please contact: ', 200);
                    }
                } else {
                    $checkInRecentProject = RecentProject::where('user_id', Auth::id())->where('project_id', $request->input('project_id'))->first();

                    if (count($checkInRecentProject) < 1) {
                        return parent::error('Project Owner has turned off new Subscriptions for the project. For enquiries please contact:', 200);
                    }
                }

            endif;
            $createRecentHistory = parent::recentHistoryProject(Auth::id(), $request->input('project_id'));
            if ($projectDetails->project_type == 'paid') {
                $paidDetails = parent::checkProjectPaidStatus($request->input('project_id'));
                $projectDetails->paid_status = $paidDetails;
                $reoccurDetails = PaidProjectDetail::where('project_id', $request->input('project_id'))->where('user_id', Auth::id())->first();
                if (count($reoccurDetails) > 0) {
                    $projectDetails->reoccuring_trigger = $reoccurDetails->reoccuring_trigger;
                } else {
                    $projectDetails->reoccuring_trigger = 0;
                }
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

            $projectDetails->project_owner = $userDetails;
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
            return parent::error('We could not find the UID. . Please contact Project Owner for assistance. ', 200);
        }
    }

    public function deleteRecentProject(Request $request) {
        $validator = Validator::make($request->all(), [
                    'recent_id' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = self::formatValidator($validator);
            return parent::error($errors, 200);
        }
        $details = RecentProject::where('id', $request->input('recent_id'))->delete();

        return parent::success('Deleted Successfully.', $this->successStatus);
    }

    public function myRecentProjects(Request $request) {


        $recentProjects = RecentProject::where('user_id', Auth::id())->with('project')->get();
        $projectRecent = [];
        $allProjects = [];
        if (count($recentProjects) > 0) {
            foreach ($recentProjects as $project) {
                $reoccurDetails = PaidProjectDetail::where('project_id', $project->project_id)->where('user_id', Auth::id())->first();
                $projectRecent['projectDetails'] = $project;

                if ($projectRecent['projectDetails']->project['project_type'] == 'paid') {
                    $paidDetails = parent::checkProjectPaidStatus($project->project_id);
                    $projectRecent['projectDetails']->project['paid_status'] = $paidDetails;
                    if ($paidDetails == 'true') {
                        $expiryDate = parent::checkProjectExpiryDate($project->project_id);
                        $projectRecent['projectDetails']->project['expiryDate'] = $expiryDate;
                    }
                }




                if (count($reoccurDetails) > 0) {
                    $projectRecent['projectinfo']['reoccuring_trigger'] = $reoccurDetails->reoccuring_trigger;
                } else {
                    $projectRecent['projectinfo']['reoccuring_trigger'] = 0;
                }

                $allProjects['projects'][] = $projectRecent;
            }

            return parent::success($allProjects, $this->successStatus);
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

    public function projectReoccuring(Request $request) {
        $validator = Validator::make($request->all(), [
                    'project_id' => 'required'
        ]);
        if ($validator->fails()) {
            $errors = self::formatValidator($validator);
            return parent::error($errors, 200);
            //  return parent::error($validator->errors(), 200);
        }
        $projectDetails = PaidProjectDetail::where('project_id', $request->input('project_id'))->where('user_id', Auth::id())->first();

        if (count($projectDetails) > 0) {
            if ($projectDetails->reoccuring_trigger == 1) {
                $reoccuringSwitch = 0;
                $message['message'] = 'You have successfully turned off reoccuring payment for this project';
            } else {
                $reoccuringSwitch = 1;
                $message['message'] = 'You have successfully turned on reoccuring payment for this project';
            }
            $updateReoccuringStatus = PaidProjectDetail::where('project_id', $request->input('project_id'))->where('user_id', Auth::id())->update([
                'reoccuring_trigger' => $reoccuringSwitch
            ]);
            return parent::success($message, $this->successStatus);
        } else {
            return parent::error('You are not subscribed to this project', 200);
        }
    }

    public function updateScanPacks(Request $request) {
        $validator = Validator::make($request->all(), [
                    'project_id' => 'required'
        ]);
        if ($validator->fails()) {
            $errors = self::formatValidator($validator);
            return parent::error($errors, 200);
            //  return parent::error($validator->errors(), 200);
        }


        $selectProjectOwner = Project::where('id', $request->get('project_id'))->first();
        //  dd($selectProjectOwner->created_by);
        $selectScanPlan = UserScanPack::where('user_id', $selectProjectOwner->created_by)->first();
        if ($selectScanPlan->scans == 0) {
            $purchasePack = parent::updateScanPack($selectProjectOwner->created_by);
            if (!$purchasePack) {
                return parent::error('Scan Packs are over for this project. Please contact project owner to continue scanning.', 200);
            }
        }
        $newScanUsed = $selectScanPlan->scans_used + 1;
        $scans = $selectScanPlan->scans - 1;
        $updateScanPack = UserScanPack::where('user_id', $selectProjectOwner->created_by)->update([
            'scans_used' => $newScanUsed,
            'scans' => $scans
        ]);
        return parent::success("Updated Successfully", $this->successStatus);
    }

}
