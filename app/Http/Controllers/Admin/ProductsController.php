<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Auth;

class ProductsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request) {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $products = Product::where('user_id', Auth::id())->where('sku', 'LIKE', "%$keyword%")
                    ->orWhere('name', 'LIKE', "%$keyword%")
                    ->orWhere('price', 'LIKE', "%$keyword%")
                    ->orWhere('stock', 'LIKE', "%$keyword%")
                    ->orWhere('image', 'LIKE', "%$keyword%")
                    ->orWhere('status', 'LIKE', "%$keyword%")
                    ->orWhere('user_id', 'LIKE', "%$keyword%")
                    ->orWhere('category_id', 'LIKE', "%$keyword%")
                    ->paginate($perPage);
        } else {
            $products = Product::where('user_id', Auth::id())->paginate($perPage);
        }

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create() {
        //  return json_encode($this->get_combinations());
        //die();
        $productCategories = \App\ProductCategory::where('user_id', Auth::id())->get();
        return view('admin.products.create', ['productCategories' => $productCategories]);
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
            'sku' => 'required',
            'name' => 'required',
            'price' => 'required',
            'image' => 'required',
            'user_id' => 'required',
            'description' => 'required',
            'category_id' => 'required'
        ]);


        //print_r($request->all());die();

        $imagePath = $this->uploadFile($request, 'image', '/images/products');

        $requestData = $request->all();
        $requestData['image'] = $imagePath;
        $product = Product::create($requestData);

        $i = 0;
        $fieldValues = $request->input('fieldsValue');
        foreach ($request->input('fields') as $field) {
            //echo $fieldValues[$i];
            \App\ProductOption::create([
                'product_id' => $product->id,
                'attribute' => $field,
                'attribute_values' => $fieldValues[$i],
                'user_id' => Auth::id()
            ]);

            $optionArray[] = explode(',', $fieldValues[$i]);
            $i++;
        }
        //dd($this->get_combinations($optionArray));
        foreach ($this->get_combinations($optionArray) as $option) {

            \App\ProductAttributeCombination::create([
                'product_id' => $product->id,
                'value' => json_encode($option),
                'user_id' => Auth::id(),
                'stock' => $request->input('stock'),
                'price' => $request->input('price'),
                'image' => $imagePath
            ]);
        }



        return redirect('admin/products')->with('flash_message', 'Product added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id) {
        $product = Product::findOrFail($id);

        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id) {
        $product = Product::findOrFail($id);
        $productCategories = \App\ProductCategory::where('user_id', Auth::id())->get();

        $productOptions = \App\ProductOption::where('product_id', $id)->where('user_id', Auth::id())->get();
        return view('admin.products.edit', compact('product', 'productCategories', 'productOptions'));
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
            'sku' => 'required',
            'name' => 'required',
            'price' => 'required',
            'image' => 'required',
            'user_id' => 'required',
            'category_id' => 'required'
        ]);
        $requestData = $request->all();

        $product = Product::findOrFail($id);
        $product->update($requestData);

        return redirect('admin/products')->with('flash_message', 'Product updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id) {
        Product::destroy($id);

        return redirect('admin/products')->with('flash_message', 'Product deleted!');
    }

    function get_combinations($arrays = []) {



        $result = array(array());
        foreach ($arrays as $property => $property_values) {
            $tmp = array();
            foreach ($result as $result_item) {
                foreach ($property_values as $property_value) {
                    $tmp[] = array_merge($result_item, array($property => $property_value));
                }
            }
            $result = $tmp;
        }
        return $result;
    }

    function getProductAttributeStock(Request $request) {
        $attributes = json_encode($request->input('attributes'));
        $product_id = $request->input('product_id');

        $stock = \App\ProductAttributeCombination::where('product_id', $product_id)->where('value', $attributes)->where('user_id', Auth::id())->first();

        return array($stock['stock'], $stock['price'], $stock['image'],$stock['id']);
    }

    function updateStock(Request $request) {

        $attributes = $request->input('attributes');
        $product_id = $request->input('product_id');
        $stockValue = $request->input('stockValue');
        $price = $request->input('priceValue');
        //dd($attributes);
        if ($request->file('image') !== null) {
            $imagePath = $this->uploadFile($request, 'image', '/images/products');
          //  dd($imagePath);
            \App\ProductAttributeCombination::where('product_id', $product_id)->where('id', $attributes)->where('user_id', Auth::id())->update([
                'stock' => $stockValue,
                'price' =>  (int)$price,
                'image' => $imagePath
            ]);
        } else {
            \App\ProductAttributeCombination::where('product_id', $product_id)->where('id', $attributes)->where('user_id', Auth::id())->update([
                'stock' => $stockValue,
                'price' => (int)$price
            ]);
        }


         return redirect('admin/products/'.$product_id.'/edit')->with('flash_message', 'Product updated!');;
    }

}
