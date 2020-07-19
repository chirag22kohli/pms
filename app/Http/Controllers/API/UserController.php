<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\Controller;
use App\User;
use Auth;
use Validator;
use DB;
use App\Role;
use App\Contactandevents;
use App\Metum;
use Hash;
use App\PaidProjectHistoryDetail;
use App\Help;
use App\tutorialManager;
use App\Stripe;
use Rap2hpoutre\LaravelStripeConnect\StripeConnect;

class UserController extends Controller {

    public $successStatus = 200;

    /**
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function login() {
        if (Auth::guard('web')->attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = User::where('email', request('email'))->first();
            // dd($user);
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

        $checkContact = Contactandevents::where('user_id', Auth::id())->where('type', $request->input('type'))->where('json_info', $request->input('json_info'))->first();

        if (count($checkContact) > 0) {
            return parent::error($request->input('type') . ' already exist.', 200);
        }
        $user = Contactandevents::create(array_merge($request->all(), ['user_id' => Auth::id()]));

        $success['message'] = 'You may access saved ' . $request->input('type') . ' under the ' . $request->input('type') . 's Section of the Navigation Bar';

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
        if (count($project) > 0) {
            $userDetails = User::where('id', $project->created_by)->first();
            if (count($userDetails) > 0) {
                return parent::success($userDetails, $this->successStatus);
            } else {
                return parent::error(' Project Owner Not Found', 200);
            }
        } else {
            return parent::error(' Project Not Found', 200);
        }
    }

    public function getProfile() {
        $profile = User::where('id', Auth::id())->first();
        return parent::success($profile, $this->successStatus);
    }

    public function updateProfile(Request $request) {
        $validator = Validator::make($request->all(), [
                    'name' => 'required',
                    'phone' => 'required',
                    'address' => 'required',
                    'city' => 'required',
                    'state' => 'required',
                    'zip_code' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = self::formatValidator($validator);
            return parent::error($errors, 200);
        }
        $profile = User::where('id', Auth::id())->update(
                $request->all()
        );
        return parent::success('Profile Updated Successfully', $this->successStatus);
    }

    public function changePassword(Request $request) {

        $validator = Validator::make($request->all(), [
                    'current-password' => 'required',
                    'password' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = self::formatValidator($validator);
            return parent::error($errors, 200);
        }

        $current_password = Auth::User()->password;
        if (Hash::check($request->input('current-password'), $current_password)) {
            $user_id = Auth::User()->id;
            $obj_user = User::find($user_id);
            $obj_user->password = Hash::make($request->input('password'));
            ;
            $obj_user->save();
            return parent::success('Password Changed Successfully', $this->successStatus);
        } else {
            return parent::error('Please enter correct current password', 200);
        }
    }

    public function getTransactions(Request $request) {
        $getTransictVendors = PaidProjectHistoryDetail::where('user_id', Auth::id())->groupby('project_admin_id')->with('ownTransaction')->with('transactionAdmin')->get();
        if (count($getTransictVendors) > 0):
            return parent::success($getTransictVendors, $this->successStatus);
        else:
            return parent::error('No Transaction List Found', 200);
        endif;
    }

    public function getHelp(Request $request) {
        $getHelp = Help::get();
        if (count($getHelp) > 0):
            return parent::success($getHelp, $this->successStatus);
        else:
            return parent::error('No Help Content Found', 200);
        endif;
    }

    public function getTutorials(Request $request) {
        $getHelp = tutorialManager::get();
        if (count($getHelp) > 0):
            return parent::success($getHelp, $this->successStatus);
        else:
            return parent::error('No Tutorial Found', 200);
        endif;
    }

    public function getProductDetails(Request $request) {
        $validator = Validator::make($request->all(), [
                    'product_id' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = self::formatValidator($validator);
            return parent::error($errors, 200);
        }

        $product_id = $request->input('product_id');

        $getProduct = \App\Product::with('product_options')->with('product_attribute_combinations')->where('id', $product_id)->first();
        if ($getProduct):
            return parent::success($getProduct, $this->successStatus);
        else:
            return parent::error('No Product Found', 200);
        endif;
    }

    public function addToCart(Request $request) {
        $validator = Validator::make($request->all(), [
                    'product_id' => 'required',
                    'attributes' => 'required',
                    'stock' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = self::formatValidator($validator);
            return parent::error($errors, 200);
        }


        $addToCart = \App\Cart::create([
                    'user_id' => Auth::id(),
                    'product_id' => $request->input('product_id'),
                    'stock' => $request->input('stock'),
                    'attributes' => $request->input('attributes'),
        ]);

        return parent::success("Product Added to Cart", $this->successStatus);
    }

    public function getMyCart(Request $request) {
        $getCart = \App\Cart::with('product_detail')->where('user_id', Auth::id())->get();
        if (!empty($getCart)) {
            return parent::success($getCart, $this->successStatus);
        } else {
            return parent::error('Your cart is empty', 200);
        }
    }

    public function addAddress(Request $request) {
        $validator = Validator::make($request->all(), [
                    'name' => 'required',
                    'mobile' => 'required',
                    'pin_code' => 'required',
                    'state' => 'required',
                    'address_1' => 'required',
                    'address_2' => 'required',
                    'landmark' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = self::formatValidator($validator);
            return parent::error($errors, 200);
        }

        \App\UserAddress::where('user_id', Auth::id())->update(['default_address' => 0]);
        $addAddress = \App\UserAddress::create([
                    'user_id' => Auth::id(),
                    'name' => $request->input('name'),
                    'mobile' => $request->input('mobile'),
                    'pin_code' => $request->input('pin_code'),
                    'city' => 'SG',
                    'state' => $request->input('state'),
                    'address_1' => $request->input('address_1'),
                    'address_2' => $request->input('address_2'),
                    'landmark' => $request->input('landmark'),
                    'default_address' => 1
        ]);

        return parent::success("New Address Added Successfully", $this->successStatus);
    }

    public function getMyAddress(Request $request) {
        $getAddress = \App\UserAddress::where('user_id', Auth::id())->get();
        if ($getAddress) {
            return parent::success($getAddress, $this->successStatus);
        } else {
            return parent::error('No Address Found', 200);
        }
    }

    public function updateCartQuatity(Request $request) {
        $validator = Validator::make($request->all(), [
                    'id' => 'required',
                    'stock' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = self::formatValidator($validator);
            return parent::error($errors, 200);
        }


        $updateCart = \App\Cart::where('id', $request->input('id'))->update([
            'stock' => $request->input('stock')
        ]);

        return parent::success("Cart Update Successfully", $this->successStatus);
    }

    public function deleteFromCart(Request $request) {
        $validator = Validator::make($request->all(), [
                    'id' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = self::formatValidator($validator);
            return parent::error($errors, 200);
        }


        $updateCart = \App\Cart::where('id', $request->input('id'))->delete();

        return parent::success("Cart Update Successfully", $this->successStatus);
    }

    public function placeOrder(Request $request) {




        if (isset($request->card_id)) {
            try {

                $user = Stripe::where('user_id', Auth::id())->first();
                \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                $customer = \Stripe\Customer::retrieve($user->customer_id);
                $customer->default_source = $request->card_id;
                $customer->save();
                //return parent::success($this->getCards(), $this->successStatus);
            } catch (\Exception $ex) {
                return parent::error($ex->getMessage());
            }
        }
        if ($request->input('token') != '') {

            try {
                $removeInvalidCustomer = Stripe::where('user_id', Auth::id())->update(['customer_id' => null]);
                $customer = StripeConnect::createCustomer($request->input('token'), Auth::user());
            } catch (\Exception $e) {
                return parent::error($e->getMessage(), $this->successStatus);
            }
        } else {
            if (!$this->checkPaymentMethod()) {
                return parent::error('No Payment Method Found', 404);
            }
        }






        $getCart = \App\Cart::where('user_id', Auth::id())->with('product_detail')->get();
        //dd(Auth::id());
        foreach ($getCart as $cart) {
            $getClientId = \App\Product::where('id', $cart->product_id)->first();
            $client[$getClientId->user_id][] = $cart;
        }

        foreach ($client as $clientId => $products) {
            $createOrder = \App\Order::create([
                        'amount' => 0,
                        'user_id' => Auth::id(),
                        'client_id' => $clientId,
                        'is_paid' => 0,
                        'address_id' => $request->input('address_id'),
                        'params' => json_encode($products),
                        'table_number' => $request->input('table_number')
            ]);
            $amount = 0;
            foreach ($products as $product) {
                $productDetails = \App\Product::where('id', $product->product_id)->first();
                // dd($product->attributes);

                $getAmount = \App\ProductAttributeCombination::where('product_id', $product->product_id)->where('value', $product->attributes)->first();
                //$amount = $getAmount->price;


                $amount += $productDetails->price * $product->stock;
                $getProduct = \App\ProductOption::where('product_id', $product->product_id)->pluck('attribute');


                \App\OrderDetail::create([
                    'order_id' => $createOrder->id,
                    'product_id' => $product->product_id,
                    'attributes' => json_encode($getProduct),
                    'attribute_options' => $product->attributes,
                    'quantity' => $product->stock
                ]);
            }

            $productAdmin = \App\User::where('id', $getClientId->user_id)->first();

            try {

                $charge = StripeConnect::transaction()
                        ->amount($amount * 100, 'sgd')
                        ->useSavedCustomer()
                        ->from(Auth::user())
                        ->to($productAdmin)
                        ->create();
            } catch (\Exception $e) {

                //$removeInvalidCustomer = Stripe::where('user_id', Auth::id())->update(['customer_id' => null]);
                return parent::error($e->getMessage(), $this->successStatus);
            }


            $updateOrderAmount = \App\Order::where('id', $createOrder->id)->update([
                'amount' => $amount,
                'is_paid' => 1
            ]);
        }

        $updateCart = \App\Cart::where('user_id', Auth::id())->delete();
        return parent::success("Order Placed Successfully", $this->successStatus);
    }

    public function getOrders(Request $request) {
        $getOrders = \App\Order::where('user_id', Auth::id())->with('order_details')->with('address')->get();

        if ($getOrders) {
            return parent::success($getOrders, $this->successStatus);
        } else {
            return parent::error('No Orders Found', 200);
        }
    }

    public function updateDefaultAddress(Request $request) {
        $validator = Validator::make($request->all(), [
                    'address_id' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = self::formatValidator($validator);
            return parent::error($errors, 200);
        }
        \App\UserAddress::where('user_id', Auth::id())->update(['default_address' => 0]);
        $updateAddress = \App\UserAddress::where('id', $request->input('address_id'))->update([
            'default_address' => 1
        ]);

        return parent::success("Default Address Updated", $this->successStatus);
    }

    public function deleteAddress(Request $request) {
        $validator = Validator::make($request->all(), [
                    'address_id' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = self::formatValidator($validator);
            return parent::error($errors, 200);
        }
        // \App\UserAddress::where('user_id', Auth::id())->update(['default_address' => 0]);
        $updateAddress = \App\UserAddress::where('id', $request->input('address_id'))->delete();

        return parent::success("Address Deleted", $this->successStatus);
    }

    public function checkPaymentMethod() {


        $details = Stripe::where('user_id', Auth::id())->first();

        if (count($details) > 0) {

            if ($details->customer_id != '') {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getAttributeDetails(Request $request) {
        $validator = Validator::make($request->all(), [
                    'product_id' => 'required',
                    'attributes' => 'required'
        ]);
        if ($validator->fails()) {
            $errors = self::formatValidator($validator);
            return parent::error($errors, 200);
        }
        $getAttribute = \App\ProductAttributeCombination::where('value',  $request->input('attributes'))->where('product_id', $request->product_id)->first();
        if ($getAttribute) {
            return parent::success($getAttribute, $this->successStatus);
        } else {
            return parent::error('Product not Found', 200);
        }
    }

}
