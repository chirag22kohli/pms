<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Support;
use Illuminate\Http\Request;
use DB;
class SupportController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request) {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $support = Support::where('email', 'LIKE', "%$keyword%")
                    ->orWhere('reason', 'LIKE', "%$keyword%")
                    ->orWhere('description', 'LIKE', "%$keyword%")
                    ->paginate($perPage);
        } else {
            $support = Support::paginate($perPage);
        }

        return view('admin.support.index', compact('support'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create() {
        return view('admin.support.create');
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

        Support::create($requestData);

        return redirect('admin/support')->with('flash_message', 'Support added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id) {
        $support = Support::findOrFail($id);

        return view('admin.support.show', compact('support'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id) {
        $support = Support::findOrFail($id);

        return view('admin.support.edit', compact('support'));
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

        $support = Support::findOrFail($id);
        $support->update($requestData);

        return redirect('admin/support')->with('flash_message', 'Support updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id) {
        Support::destroy($id);

        return redirect('admin/support')->with('flash_message', 'Support deleted!');
    }

    public function createSupport(Request $request) {
        $requestData = $request->all();

        Support::create($requestData);

        $request->session()->flash('alert-success', 'Support Ticket has been Raised Successfully.');
        return redirect('client/support');
    }
    
    public function trackerSupport() {
        $trackerSupport = DB::table('tracker_support')->select('tracker_support.*','projects.name as projectName','trackers.tracker_name','trackers.tracker_path','users.email')->join('projects', 'projects.id', '=', 'tracker_support.project_id')->join('trackers', 'trackers.id', '=', 'tracker_support.tracker_id')->join('users', 'users.id', '=', 'tracker_support.user_id')->get();
       //dd($trackerSupport); 
        return view('admin.support.trackerSupport', ['trackerSupport'=>$trackerSupport]);
    }

}
