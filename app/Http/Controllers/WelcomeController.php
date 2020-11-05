<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Plan;
use Validator;
use App\Metum;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

class WelcomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function welcome() {
        $plans = Plan::all();

        return view('home.welcome', ['plans' => $plans]);
    }

    public function viewPlans() {
        $plans = Plan::all();

        return view('home.plans', ['plans' => $plans]);
    }

    public function register($plan_id) {

        return view('home.register', ['plan_id' => base64_decode($plan_id)]);
    }

    public function terms() {
        $terms = Metum::where('meta_name', 'terms')->first();
        return view('home.terms', ['terms' => $terms]);
    }

    public function getMetas(Request $request) {

        $validator = Validator::make($request->all(), [
                    'meta_name' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = self::formatValidator($validator);
            return parent::error($errors, 200);
        }
        $details = Metum::where('meta_name', $request->input('meta_name'))->first();
        if (count($details) > 0) {
            return parent::success($details, 200);
        } else {
            return parent::error('No ' . $request->input('meta_name') . ' Found', 200);
        }
    }

    public function formatValidator($validator) {
        $messages = $validator->getMessageBag();
        foreach ($messages->keys() as $key) {
            $errors[] = $messages->get($key)['0'];
        }
        return $errors[0];
    }

    public function forgotPassword(Request $request) {
        $validator = Validator::make($request->all(), [
                    'email' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = self::formatValidator($validator);
            return parent::error($errors, 200);
        }
        return parent::success("Email Sent Successfuly ", 200);
    }
    
        public function sendTest() {
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60 * 20);

        $notificationBuilder = new PayloadNotificationBuilder('my title');
        $notificationBuilder->setBody('Hello world')
                ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['a_data' => 'my_data']);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $token = "cyKkegxQStGrMsNLOTl8wD:APA91bFKgtECGjYvUasfuPmBFd6IFJhJO6LDCnl_rtbQbTA-tEOli19APp24Nyi4O5PsBDbaKaEV8n0gMgGhRwnNUK-AFKXYzg3AcykdJqMIkyTvjG-EEhQLWVxfCAIQbpGXpGwtJ_fL";

        $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);

        $downstreamResponse->numberSuccess();
        $downstreamResponse->numberFailure();
        $downstreamResponse->numberModification();

// return Array - you must remove all this tokens in your database
        $downstreamResponse->tokensToDelete();

// return Array (key : oldToken, value : new token - you must change the token in your database)
        $downstreamResponse->tokensToModify();

// return Array - you should try to resend the message to the tokens in the array
        $downstreamResponse->tokensToRetry();

// return Array (key:token, value:error) - in production you should remove from your database the tokens
        $downstreamResponse->tokensWithError();
    }


}
