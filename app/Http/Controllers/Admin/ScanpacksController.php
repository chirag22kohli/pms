<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Scanpack;
use Illuminate\Http\Request;

class ScanpacksController extends Controller
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
            $scanpacks = Scanpack::where('packname', 'LIKE', "%$keyword%")
                ->orWhere('scans', 'LIKE', "%$keyword%")
                ->orWhere('price', 'LIKE', "%$keyword%")
                ->paginate($perPage);
        } else {
            $scanpacks = Scanpack::paginate($perPage);
        }

        return view('admin.scanpacks.index', compact('scanpacks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.scanpacks.create');
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
        
        Scanpack::create($requestData);

        return redirect('admin/scanpacks')->with('flash_message', 'Scanpack added!');
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
        $scanpack = Scanpack::findOrFail($id);

        return view('admin.scanpacks.show', compact('scanpack'));
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
        $scanpack = Scanpack::findOrFail($id);

        return view('admin.scanpacks.edit', compact('scanpack'));
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
        
        $scanpack = Scanpack::findOrFail($id);
        $scanpack->update($requestData);

        return redirect('admin/scanpacks')->with('flash_message', 'Scanpack updated!');
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
        Scanpack::destroy($id);

        return redirect('admin/scanpacks')->with('flash_message', 'Scanpack deleted!');
    }
}
