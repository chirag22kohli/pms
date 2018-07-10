<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\object;
use Illuminate\Http\Request;

class objectsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request) {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $objects = object::where('xpos', 'LIKE', "%$keyword%")
                    ->orWhere('ypos', 'LIKE', "%$keyword%")
                    ->orWhere('height', 'LIKE', "%$keyword%")
                    ->orWhere('width', 'LIKE', "%$keyword%")
                    ->orWhere('project_id', 'LIKE', "%$keyword%")
                    ->orWhere('type', 'LIKE', "%$keyword%")
                    ->orWhere('object_div', 'LIKE', "%$keyword%")
                    ->orWhere('user_id', 'LIKE', "%$keyword%")
                    ->paginate($perPage);
        } else {
            $objects = object::paginate($perPage);
        }

        return view('objects.objects.index', compact('objects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create() {
        return view('objects.objects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request) {

        $requestData = $request->all();

        object::create($requestData);

        return redirect('admin/objects')->with('flash_message', 'object added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id) {
        $object = object::findOrFail($id);

        return view('objects.objects.show', compact('object'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id) {
        $object = object::findOrFail($id);

        return view('objects.objects.edit', compact('object'));
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

        $requestData = $request->all();

        $object = object::findOrFail($id);
        $object->update($requestData);

        return redirect('admin/objects')->with('flash_message', 'object updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id) {
        object::destroy($id);

        return redirect('admin/objects')->with('flash_message', 'object deleted!');
    }

    public function addUpdateObject(Request $request) {

        $object = object::where('tracker_id', $request->input('tracker_id'))->where('object_div', $request->input('object_div'))->first();

        if (count($object) > 0):
            
            object::where('tracker_id', $request->input('tracker_id'))->where('object_div', $request->input('object_div'))->update($request->all());

        else:
            object::create($request->all());
        endif;
    }
    
    function deleteObject(Request $request){
        $object_div = $request->input('id');
        $deleteObject = object::where('object_div', '=', $object_div)->delete();
        return 'Success';
    }
    

}
