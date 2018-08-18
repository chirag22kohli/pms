<?php

namespace App\Http\Controllers\API;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Image;

class Controller {

    public static function error($validatorMessage, $errorCode = 422, $messageIndex = true) {
        if ($messageIndex === true):
            $validatorMessage = ['message' => [$validatorMessage]];
        else:
            $validatorMessage = ['message' => $validatorMessage];
        endif;
        return response()->json(['status' => false, 'data' => (object) [], 'error' => ['code' => $errorCode, 'error_message' => $validatorMessage]], $errorCode);
    }

    public static function success($data, $code = 200) {
//        print_r($data);die;
        return response()->json(['status' => true, 'code' => $code, 'data' => (object) $data], $code);
    }

    public static function successCreated($data, $code = 201) {
        return response()->json(['status' => true, 'code' => $code, 'data' => (object) $data], $code);
    }

    public function formatValidator($validator) {
        $messages = $validator->getMessageBag();
        foreach ($messages->keys() as $key) {
            $errors[] = $messages->get($key)['0'];
        }
        return $errors;
    }

}
