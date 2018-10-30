<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Project;
use Illuminate\Http\Request;
use Auth;
use App\PaidProjectDetail;
use Carbon;
class ProjectsController extends Controller {

    protected $arController;

    public function __construct(ArController $arController) {
        $this->arController = $arController;
        $date = Carbon\Carbon::now();
        $date = strtotime($date);
        $date = date('Y-m-d', $date);
        $this->date = $date;
        $this->successStatus = 200;
    }

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
                        ->where('status', 1)
                        ->paginate($perPage);
            else:
                $projects = Project::where('name', 'LIKE', "%$keyword%")
                        ->orWhere('tracker_path', 'LIKE', "%$keyword%")
                        ->orWhere('created_by', 'LIKE', "%$keyword%")
                        ->where('created_by', Auth::id())
                        ->where('status', 1)
                        ->paginate($perPage);
            endif;
        } else {
            if (Auth::user()->hasRole('Admin')):
                $projects = Project::paginate($perPage);
            else:
                $projects = Project::where('created_by', Auth::id())->where('status', 1)->paginate($perPage);
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

        return view('projects.projects.create', [
            'connectStatus' => parent::checkClientConnectedAccount()
        ]);
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
        if (!Auth::user()->hasRole('Admin')):
            $projectOwnerCheck = Project::where('id', $id)->where('created_by', Auth::id())->first();
            if (count($projectOwnerCheck) < 1):
                return "Paji GaltGall";
            endif;
        endif;
        // $projectOwnerCheck = Project::where('id',$id)->where()->first();
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

        $checkPaid = PaidProjectDetail::where('project_id', $id)->where('expriy_date', '>=', $this->date)->get();
        if (count($checkPaid) > 0):
              return redirect('admin/projects')->with('flash_message', 'You cannot delete this project as it has subscribed users already.');
        endif;
        
        if (count($getTrackers) > 0) {
            foreach ($getTrackers as $tracker) {
                $selectObjects = \App\object::where('tracker_id', $tracker->id)->get();
                if (count($selectObjects) > 0) {
                    foreach ($selectObjects as $object) {

                        $deleteActions = \App\Action::where('object_id', '=', $object->id)->delete();

                        $deleteObject = \App\object::where('id', '=', $object->id)->delete();
                    }
                }
                if ($tracker->target_id !== null) {
                    $this->arController->deleteTarget($tracker->target_id);
                }
                $deleteTracker = \App\Tracker::where('id', '=', $tracker->id)->delete();
            }
        }
        Project::where('id', $id)->update([
            'status' => 0
        ]);

        return redirect('admin/projects')->with('flash_message', 'Project deleted!');
    }

}
