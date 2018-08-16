<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\RestrictedUid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DB;
use Maatwebsite\Excel\Facades\Excel;

class RestrictedUidController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request) {
        $keyword = $request->get('search');
        $perPage = 25;
        $project_id = $request->get('p_id');
        if (empty($request->get('p_id'))) {
            return response('Internal Server Error', 500);
        }
        if (!empty($keyword)) {
            $restricteduid = RestrictedUid::where('project_id', 'LIKE', "%$keyword%")
                    ->orWhere('uid', 'LIKE', "%$keyword%")
                    ->Where('project_id', $project_id)
                    ->paginate($perPage);
        } else {
            $restricteduid = RestrictedUid::Where('project_id', $project_id)->paginate($perPage);
        }

        return view('admin.restricted-uid.index', compact('restricteduid'), ['project_id' => $project_id]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request) {
        $project_id = $request->get('p_id');
        if (empty($request->get('p_id'))) {
            return response('Internal Server Error', 500);
        }
        return view('admin.restricted-uid.create', ['project_id' => $project_id]);
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
            'project_id' => 'required',
            'uid' => 'required'
        ]);
        $requestData = $request->all();

        RestrictedUid::create($requestData);

        return redirect('admin/restricted-uid?p_id=' . $request->input('project_id') . '')->with('flash_message', 'RestrictedUid added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id) {
        $restricteduid = RestrictedUid::findOrFail($id);

        return view('admin.restricted-uid.show', compact('restricteduid'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id) {
        $restricteduid = RestrictedUid::findOrFail($id);

        return view('admin.restricted-uid.edit', compact('restricteduid'));
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
            'project_id' => 'required',
            'uid' => 'required'
        ]);
        $requestData = $request->all();

        $restricteduid = RestrictedUid::findOrFail($id);
        $restricteduid->update($requestData);

        return redirect('admin/restricted-uid')->with('flash_message', 'RestrictedUid updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id) {
        $selectProjectId = RestrictedUid::where('id', $id)->first();
        RestrictedUid::destroy($id);

        return redirect('admin/restricted-uid?p_id=' . $selectProjectId->project_id . '')->with('flash_message', 'RestrictedUid deleted!');
    }

    public function import(Request $request) {
        $project_id = $request->get('p_id');
        if (empty($request->get('p_id'))) {
            return response('Internal Server Error', 500);
        }
        return view('admin.restricted-uid.import', ['project_id' => $project_id]);
    }

    public function parseImport(Request $request) {
        $projectId = $request->input('project_id');
        if (Input::hasFile('csv_file')) {

            $file = Input::file('csv_file');
            $name = time() . '-' . $file->getClientOriginalName();

            //check out the edit content on bottom of my answer for details on $storage
            $storage = '/restrictedCsv/';
            $path = $storage;

            // Moves file to folder on server
            $file->move(public_path() . '/restrictedCsv/', $name);

            // Import the moved file to DB and return OK if there were rows affected
//            Excel::load(public_path($path. $name), function ($reader) {
//
//                foreach ($reader->toArray() as $row) {
//                    RestrictedUid::firstOrCreate($row);
//                }
//            });
            //    $data = Excel::load(public_path($path . $name), function($reader) {
            // })->get();
            $val['project_id'] = $projectId;
            try {
                Excel::load(public_path($path . $name), function ($reader) use($projectId) {

                    foreach ($reader->toArray() as $row => $val) {

                        foreach ($val as $key => $csm) {
                            $val[$key]['project_id'] = $projectId;
                        }
                       
                        RestrictedUid::insert($val);
                    }
                });
                \Session::flash('success', 'Users uploaded successfully.');
                return redirect('admin/restricted-uid?p_id=' . $projectId)->with('flash_message', 'Import Success!');
            } catch (\Exception $e) {
                \Session::flash('error', $e->getMessage());
                return $e->getMessage();
                return redirect('admin/restricted-uid?p_id=' . $projectId)->with('flash_message', 'Import Fail! Please make sure you have a excel file in proper format.');
            }
        }
    }

}
