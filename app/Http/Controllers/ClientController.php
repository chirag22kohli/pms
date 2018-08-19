<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class ClientController extends Controller
{
    public function home() {
        return view('client.home');
    }
    public function profile() {
            $userDetails = User::where('id',Auth::id())->first();
         return view('client.profile',[
             'userDetails'=>$userDetails
         ]);
    }
    public function updateProfile(Request $request) {
        $data = request()->except(['_token']);
        User::where('id',Auth::id())->update($data);
         return redirect('client/profile')->with('message', 'Profile has been updated!');
    }
}
