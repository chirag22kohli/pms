<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\ProductAttributeCombination;
use Illuminate\Http\Request;

class ProductAttributeCombinationsController extends Controller
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
            $productattributecombinations = ProductAttributeCombination::where('product_id', 'LIKE', "%$keyword%")
                ->orWhere('value', 'LIKE', "%$keyword%")
                ->orWhere('stock', 'LIKE', "%$keyword%")
                ->orWhere('user_id', 'LIKE', "%$keyword%")
                ->paginate($perPage);
        } else {
            $productattributecombinations = ProductAttributeCombination::paginate($perPage);
        }

        return view('admin.product-attribute-combinations.index', compact('productattributecombinations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.product-attribute-combinations.create');
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
			'value' => 'required',
			'stock' => 'required',
			'user_id' => 'required'
		]);
        $requestData = $request->all();
        
        ProductAttributeCombination::create($requestData);

        return redirect('admin/product-attribute-combinations')->with('flash_message', 'ProductAttributeCombination added!');
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
        $productattributecombination = ProductAttributeCombination::findOrFail($id);

        return view('admin.product-attribute-combinations.show', compact('productattributecombination'));
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
        $productattributecombination = ProductAttributeCombination::findOrFail($id);

        return view('admin.product-attribute-combinations.edit', compact('productattributecombination'));
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
			'value' => 'required',
			'stock' => 'required',
			'user_id' => 'required'
		]);
        $requestData = $request->all();
        
        $productattributecombination = ProductAttributeCombination::findOrFail($id);
        $productattributecombination->update($requestData);

        return redirect('admin/product-attribute-combinations')->with('flash_message', 'ProductAttributeCombination updated!');
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
        ProductAttributeCombination::destroy($id);

        return redirect('admin/product-attribute-combinations')->with('flash_message', 'ProductAttributeCombination deleted!');
    }
}
