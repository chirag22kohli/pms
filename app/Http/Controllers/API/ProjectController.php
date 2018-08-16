<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Project;
use App\RestrictedUid;

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
            return parent::error($validator->errors(), 401);
        }
        $projectDetails = Project::where('id', $request->input('project_id'))->first();
       if (count($projectDetails) > 0) {
            return parent::success($projectDetails, $this->successStatus);
        }else{
             return parent::error('Project Not Found', 404);
        }
    }

    public function projectType(Request $request) {
        $validator = Validator::make($request->all(), [
                    'project_type' => 'in:paid,restricted,public|required'
        ]);
        if ($validator->fails()) {
            return parent::error($validator->errors(), 401);
        }
        $projectDetails = Project::where('project_type', $request->input('project_type'))->get();
       if (count($projectDetails) > 0) {
            return parent::success($projectDetails, $this->successStatus);
        }else{
             return parent::error('Project Not Found', 404);
        }
    }

    public function validateUid(Request $request) {
        $validator = Validator::make($request->all(), [
                    'project_id' => 'required',
                    'uid' => 'required',
        ]);
        if ($validator->fails()) {
            return parent::error($validator->errors(), 401);
        }
        $projectDetails = RestrictedUid::where('project_id', $request->input('project_id'))->where('uid', $request->input('uid'))->first();

        if (count($projectDetails) > 0) {
            return parent::success($projectDetails, $this->successStatus);
        }else{
             return parent::error('No UID Found', 404);
        }
    }

}
