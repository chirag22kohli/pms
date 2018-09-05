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
        $getSame = Tracker::where('sha',$sha1file)->first();
        if(count($getSame) > 0){
            return false;
        }else{
            return true;
        }
    }
     public static function bytesToHuman($bytes) {
        $units = ['B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2). ' ' . $units[$i];
    }

    
    public static function usageInfo(){
         $actionSpace = DB::table('actions')
                    ->where('created_by', '=', Auth::id())
                     ->sum('size');
        $objectSpace = DB::table('objects')
                    ->where('created_by', '=', Auth::id())
                     ->sum('size');
        
        $finalSpace = $actionSpace + $objectSpace;
        return self::bytesToHuman($finalSpace);
    }

}
