<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Project;
use Illuminate\Http\Request;
use Auth;

class ProjectsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request) {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {

            if (Auth::user()->hasRole('Admin')):
                $projects = Project::where('name', 'LIKE', "%$keyword%")
                        ->orWhere('tracker_path', 'LIKE', "%$keyword%")
                        ->orWhere('created_by', 'LIKE', "%$keyword%")
                        ->paginate($perPage);
            else:
                $projects = Project::where('name', 'LIKE', "%$keyword%")
                        ->orWhere('tracker_path', 'LIKE', "%$keyword%")
                        ->orWhere('created_by', 'LIKE', "%$keyword%")
                        ->where('created_by', Auth::id())
                        ->paginate($perPage);
            endif;
        } else {
            if (Auth::user()->hasRole('Admin')):
                $projects = Project::paginate($perPage);
            else:
                $projects = Project::where('created_by', Auth::id())->paginate($perPage);
            endif;
        }

        return view('projects.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create() {
        return view('projects.projects.create');
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

        Project::create($requestData);

        return redirect('admin/projects')->with('flash_message', 'Project added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id) {
        $project = Project::findOrFail($id);

        return view('projects.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id) {
        $project = Project::findOrFail($id);

        return view('projects.projects.edit', compact('project'));
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

        $project = Project::findOrFail($id);
        $project->update($requestData);

        return redirect('admin/projects')->with('flash_message', 'Project updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id) {

        $getTrackers = \App\Tracker::where('project_id', $id)->get();
        if (count($getTrackers) > 0) {
            foreach ($getTrackers as $tracker) {
                $selectObjects = \App\object::where('tracker_id', $tracker->id)->get();
                if (count($selectObjects) > 0) {
                    foreach ($selectObjects as $object) {
                        $deleteActions = \App\Action::where('object_id', '=', $object->id)->delete();
                        $deleteObject = \App\object::where('id', '=', $object->id)->delete();
                    }
                }
                $deleteTracker =  \App\Tracker::where('id', '=', $tracker->id)->delete();
            }
        }
        Project::destroy($id);

        return redirect('admin/projects')->with('flash_message', 'Project deleted!');
    }

}
