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
            return parent::error($validator->errors(), 200);
        }
        $projectDetails = RestrictedUid::where('project_id', $request->input('project_id'))->where('uid', $request->input('uid'))->first();

        if (count($projectDetails) > 0) {
            return parent::success($projectDetails, $this->successStatus);
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

}
