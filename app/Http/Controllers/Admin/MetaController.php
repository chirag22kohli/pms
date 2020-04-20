<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Metum;
use Illuminate\Http\Request;

class MetaController extends Controller
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
            $meta = Metum::where('meta_name', 'LIKE', "%$keyword%")
                ->orWhere('meta_description', 'LIKE', "%$keyword%")
                ->paginate($perPage);
        } else {
            $meta = Metum::paginate($perPage);
        }

        return view('admin.meta.index', compact('meta'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.meta.create');
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
        
        $requestData = $request->all();
        
        Metum::create($requestData);

        return redirect('admin/meta')->with('flash_message', 'Metum added!');
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
        $metum = Metum::findOrFail($id);

        return view('admin.meta.show', compact('metum'));
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
        $metum = Metum::findOrFail($id);

        return view('admin.meta.edit', compact('metum'));
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
        
        $requestData = $request->all();
        
        $metum = Metum::findOrFail($id);
        $metum->update($requestData);

        return redirect('admin/meta')->with('flash_message', 'Metum updated!');
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
        Metum::destroy($id);

        return redirect('admin/meta')->with('flash_message', 'Metum deleted!');
    }
}
