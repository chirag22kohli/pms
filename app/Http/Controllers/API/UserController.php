<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use DB;
use App\Role;
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
            return parent::error('Unauthorized', 200);
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
            return parent::error($validator->errors(), 200);
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

}
