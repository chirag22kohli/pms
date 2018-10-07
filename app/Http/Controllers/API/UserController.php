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
use App\Metum;

class UserController extends Controller {

    public $successStatus = 200;

    /**
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function login() {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->accessToken;
            return parent::success($success, $this->successStatus);
        } else {
            return parent::error('Wrong Username or Password', 200);
        }
    }

    /**
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
                    'name' => 'required',
                    'email' => 'required|email|unique:users',
                    'password' => 'required',
                    'c_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            $errors = self::formatValidator($validator);
            return parent::error($errors, 200);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['name'] = $user->name;

        $lastId = $user->id;
        $selectClientRole = Role::where('name', 'Api')->first();
        $assignRole = DB::table('role_user')->insert(
                ['user_id' => $lastId, 'role_id' => $selectClientRole->id]
        );
        return parent::success($success, $this->successStatus);
    }

    /**
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function details() {

        $user = Auth::user();
        return parent::success($user, $this->successStatus);
    }

    public function createContactEvent(Request $request) {
        $validator = Validator::make($request->all(), [
                    'type' => 'required',
                    'json_info' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = self::formatValidator($validator);
            return parent::error($errors, 200);
        }
        $input = $request->all();

        $checkContact = Contactandevents::where('user_id',Auth::id())->where('type',$request->input('type'))->where('json_info',$request->input('json_info'))->first();
        
        if(count($checkContact)>0){
            return   parent::error($request->input('type').' already exist.', 200);
        }
        $user = Contactandevents::create(array_merge($request->all(), ['user_id' => Auth::id()]));

        $success['message'] = 'You may access saved '.$request->input('type').' under the '.$request->input('type').'s Section of the Navigation Bar';

        return parent::success($success, $this->successStatus);
    }

    public function getContactEvent(Request $request) {
        $validator = Validator::make($request->all(), [
                    'type' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = self::formatValidator($validator);
            return parent::error($errors, 200);
        }

        $details = Contactandevents::where('type', $request->input('type'))->where('user_id', Auth::id())->get();

        if (count($details) > 0) {
            return parent::success($details, $this->successStatus);
        } else {
            return parent::error('No ' . $request->input('type') . ' Found', 200);
        }
    }

    public function updateContactEvent(Request $request) {
        $validator = Validator::make($request->all(), [
                    'type' => 'required',
                    'id' => 'required',
                    'json_info' => 'required'
        ]);
        if ($validator->fails()) {
            $errors = self::formatValidator($validator);
            return parent::error($errors, 200);
        }
        
        $details = Contactandevents::where('type', $request->input('type'))->where('id', $request->input('id'))->update([
            'json_info' => $request->input('json_info')
        ]);

        return parent::success('Updated Successfully.', $this->successStatus);
    }

    public function deleteContactEvent(Request $request) {
        $validator = Validator::make($request->all(), [
                    'type' => 'required',
                    'id' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = self::formatValidator($validator);
            return parent::error($errors, 200);
        }

        $details = Contactandevents::where('type', $request->input('type'))->where('id', $request->input('id'))->delete();

        return parent::success('Deleted Successfully.', $this->successStatus);
    }

    public function getMeta(Request $request) {
        $validator = Validator::make($request->all(), [
                    'meta_name' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = self::formatValidator($validator);
            return parent::error($errors, 200);
        }
        $details = Metum::where('meta_name', $request->input('meta_name'))->first();
        if (count($details) > 0) {
            return parent::success($details, $this->successStatus);
        } else {
            return parent::error('No ' . $request->input('meta_name') . ' Found', 200);
        }
    }
    public function getProjectOwner(Request $request) {
        $validator = Validator::make($request->all(), [
                    'project_id' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = self::formatValidator($validator);
            return parent::error($errors, 200);
        }
        
        $project = \App\Project::where('id', $request->input('project_id'))->first();
        if(count($project)>0){
            $userDetails = User::where('id',$project->created_by)->first();
            if(count($userDetails)>0){
                return  parent::success($userDetails, $this->successStatus);
            }else{
                return parent::error(' Project Owner Not Found', 200);
            }
        }else{
            return parent::error(' Project Not Found', 200);
        }
    }

}
