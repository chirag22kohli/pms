<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\OrderDetail;
use Illuminate\Http\Request;

class OrderDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $orderdetails = OrderDetail::where('order_id', 'LIKE', "%$keyword%")
                ->orWhere('product_id', 'LIKE', "%$keyword%")
                ->orWhere('attributes', 'LIKE', "%$keyword%")
                ->orWhere('attribute_options', 'LIKE', "%$keyword%")
                ->orWhere('quantity', 'LIKE', "%$keyword%")
                ->paginate($perPage);
        } else {
            $orderdetails = OrderDetail::paginate($perPage);
        }

        return view('admin.order-details.index', compact('orderdetails'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.order-details.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
			'order_id' => 'required',
			'product_id' => 'required',
			'attributes' => 'required',
			'attribute_options' => 'required',
			'quantity' => 'required'
		]);
        $requestData = $request->all();
        
        OrderDetail::create($requestData);

        return redirect('admin/order-details')->with('flash_message', 'OrderDetail added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $orderdetail = OrderDetail::findOrFail($id);

        return view('admin.order-details.show', compact('orderdetail'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $orderdetail = OrderDetail::findOrFail($id);

        return view('admin.order-details.edit', compact('orderdetail'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
			'order_id' => 'required',
			'product_id' => 'required',
			'attributes' => 'required',
			'attribute_options' => 'required',
			'quantity' => 'required'
		]);
        $requestData = $request->all();
        
        $orderdetail = OrderDetail::findOrFail($id);
        $orderdetail->update($requestData);

        return redirect('admin/order-details')->with('flash_message', 'OrderDetail updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        OrderDetail::destroy($id);

        return redirect('admin/order-details')->with('flash_message', 'OrderDetail deleted!');
    }
}
