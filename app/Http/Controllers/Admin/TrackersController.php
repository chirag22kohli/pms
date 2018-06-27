<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tracker;
use Illuminate\Http\Request;

class TrackersController extends Controller {

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
            $trackers = Tracker::where('tracker_name', 'LIKE', "%$keyword%")
                    ->orWhere('height', 'LIKE', "%$keyword%")
                    ->orWhere('width', 'LIKE', "%$keyword%")
                    ->orWhere('project_id', 'LIKE', "%$keyword%")
                    ->orWhere('params', 'LIKE', "%$keyword%")
                    ->Where('project_id', $project_id)
                    ->paginate($perPage);
        } else {
            $trackers = Tracker::Where('project_id', $project_id)->paginate($perPage);
        }

        return view('admin.trackers.index', compact('trackers'), ['project_id' => $project_id]);
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
        return view('admin.trackers.create', ['project_id' => $project_id]);
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

        Tracker::create($requestData);

        return redirect('admin/trackers?p_id='.$request->input('project_id').'')->with('flash_message', 'Tracker added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id) {
        $tracker = Tracker::findOrFail($id);

        return view('admin.trackers.show', compact('tracker'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id) {
        $tracker = Tracker::findOrFail($id);

        return view('admin.trackers.edit', compact('tracker'));
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

        $tracker = Tracker::findOrFail($id);
        $tracker->update($requestData);

        return redirect('admin/trackers')->with('flash_message', 'Tracker updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id) {
        $selectProjectId = Tracker::where('id',$id)->first();
        
        Tracker::destroy($id);
        
        return redirect('admin/trackers?p_id='.$selectProjectId->project_id.'')->with('flash_message', 'Tracker deleted!');
    }

}
