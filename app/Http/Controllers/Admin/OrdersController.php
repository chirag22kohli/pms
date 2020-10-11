<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request) {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $orders = Order::where('client_id', Auth::id())->where('amount', 'LIKE', "%$keyword%")
                    ->orWhere('user_id', 'LIKE', "%$keyword%")
                    ->orWhere('client_id', 'LIKE', "%$keyword%")
                    ->orWhere('is_paid', 'LIKE', "%$keyword%")
                    ->orWhere('params', 'LIKE', "%$keyword%")
                    ->with('order_details')->with('address')
                    ->with('user_details')
                    ->paginate($perPage);
        } else {
            $orders = Order::where('client_id', Auth::id())->with('order_details')->with('address')->with('user_details')->paginate($perPage);
        }

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create() {
        return view('admin.orders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request) {
        $this->validate($request, [
            'amount' => 'required',
            'user_id' => 'required',
            'client_id' => 'required',
            'is_paid' => 'required',
            'params' => 'required'
        ]);
        $requestData = $request->all();

        Order::create($requestData);

        return redirect('admin/orders')->with('flash_message', 'Order added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id) {
        $order = Order::where('client_id', Auth::id())->with('order_details')->with('address')
                        ->with('user_details')->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id) {
        $order = Order::findOrFail($id);

        return view('admin.orders.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id) {
        $this->validate($request, [
            'amount' => 'required',
            'user_id' => 'required',
            'client_id' => 'required',
            'is_paid' => 'required',
            'params' => 'required'
        ]);
        $requestData = $request->all();

        $order = Order::findOrFail($id);
        $order->update($requestData);

        return redirect('admin/orders')->with('flash_message', 'Order updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id) {
        Order::destroy($id);

        return redirect('admin/orders')->with('flash_message', 'Order deleted!');
    }

    public function updateOrderStatus(Request $request) {
        $updateStatus = Order::where('id', $request->id)->update([
            'status' => $request->status
        ]);
        return "Order Status Updated";
    }

    public function getOrdersAjax(Request $request) {


        $orders = Order::where('client_id', Auth::id())->with('order_details')->with('address')->with('user_details')->paginate($perPage);



        return view('admin.orders.getOrdersAjax', compact('orders'));
    }

}
