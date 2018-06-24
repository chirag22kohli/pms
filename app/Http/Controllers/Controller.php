<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function uploadFile($request, $fileName, $path){
        $image = $request->file($fileName);
        //dd($_FILES);
        $input['imagename'] = time() . '.' . $image->getClientOriginalExtension();

        $destinationPath = public_path($path);

        $image->move($destinationPath, $input['imagename']);
        return $path.'/'.$input['imagename'];
    }
}
