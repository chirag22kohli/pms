<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
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
            $cart = Cart::where('product_id', 'LIKE', "%$keyword%")
                ->orWhere('user_id', 'LIKE', "%$keyword%")
                ->paginate($perPage);
        } else {
            $cart = Cart::paginate($perPage);
        }

        return view('admin.cart.index', compact('cart'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.cart.create');
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
			'user_id' => 'required'
		]);
        $requestData = $request->all();
        
        Cart::create($requestData);

        return redirect('admin/cart')->with('flash_message', 'Cart added!');
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
        $cart = Cart::findOrFail($id);

        return view('admin.cart.show', compact('cart'));
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
        $cart = Cart::findOrFail($id);

        return view('admin.cart.edit', compact('cart'));
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
			'user_id' => 'required'
		]);
        $requestData = $request->all();
        
        $cart = Cart::findOrFail($id);
        $cart->update($requestData);

        return redirect('admin/cart')->with('flash_message', 'Cart updated!');
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
        Cart::destroy($id);

        return redirect('admin/cart')->with('flash_message', 'Cart deleted!');
    }
}
