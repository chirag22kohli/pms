<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\ProductOption;
use Illuminate\Http\Request;

class ProductOptionsController extends Controller
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
            $productoptions = ProductOption::where('product_id', 'LIKE', "%$keyword%")
                ->orWhere('attribute', 'LIKE', "%$keyword%")
                ->orWhere('attribute_values', 'LIKE', "%$keyword%")
                ->orWhere('user_id', 'LIKE', "%$keyword%")
                ->paginate($perPage);
        } else {
            $productoptions = ProductOption::paginate($perPage);
        }

        return view('admin.product-options.index', compact('productoptions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.product-options.create');
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
			'product_id' => 'required',
			'attribute' => 'required',
			'attribute_values' => 'required',
			'user_id' => 'required'
		]);
        $requestData = $request->all();
        
        ProductOption::create($requestData);

        return redirect('admin/product-options')->with('flash_message', 'ProductOption added!');
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
        $productoption = ProductOption::findOrFail($id);

        return view('admin.product-options.show', compact('productoption'));
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
        $productoption = ProductOption::findOrFail($id);

        return view('admin.product-options.edit', compact('productoption'));
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
			'product_id' => 'required',
			'attribute' => 'required',
			'attribute_values' => 'required',
			'user_id' => 'required'
		]);
        $requestData = $request->all();
        
        $productoption = ProductOption::findOrFail($id);
        $productoption->update($requestData);

        return redirect('admin/product-options')->with('flash_message', 'ProductOption updated!');
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
        ProductOption::destroy($id);

        return redirect('admin/product-options')->with('flash_message', 'ProductOption deleted!');
    }
}
