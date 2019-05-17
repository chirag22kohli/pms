<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use App\Project;
use App\object;
use App\Tracker;
use Image;
use Illuminate\Support\Facades\Input;
use Auth;
//use ReallySimpleJWT\Token;
use App\Build as BBC;
use ReallySimpleJWT\Build;
use ReallySimpleJWT\Parse;
use ReallySimpleJWT\Jwt;
use ReallySimpleJWT\Validate;
use ReallySimpleJWT\Encode;
use ReallySimpleJWT\Exception\ValidateException;

class CreateTokenController extends \ReallySimpleJWT\Token {

    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    const JSON_CONTENT_TYPE = 'application/json';
    const ACCESS_KEY = '196d3b643d5947dc9a00c44256a7ca5e';
    const SECRET_KEY = 'fc04c9bde9434283934965ec7f891a84';
    const BASE_URL = 'https://developer.maxst.com/api/';
    const TARGETS_PATH = '/Trackables';
    const ID_INDEX = 0;
    const IMAGE_INDEX = 1;
    const WINE_COM_URL = 2;
    const VINTAGE = 3;
    const WINERY_NAME = 4;

    public $imagePath = '/';
    public $imageName = 'fr.png';

    public static function customPayload(array $payload, string $secret): string {
        $builder = self::builderMethod();

        foreach ($payload as $key => $value) {
            if (is_int($key)) {
                throw new ValidateException('Invalid payload claim.', 8);
            }

            $builder->setPayloadClaim($key, $value);
        }
        //dd($builder);
        return $builder->setSecret($secret)
                        ->build()
                        ->getToken();
    }

    public static function builderMethod(): BBC {

        return new BBC('JWT', new Validate(), new Encode());
    }

    public static function createToken() {

        $payload = [
            'iat' => time(),
            'secId' => '829c6878a2364d169217150491748dda'
        ];

        $secret = '4f7495f69c384837a1f38044ab7bb5fd';

        return $token = self::customPayload($payload, $secret);
    }

}
