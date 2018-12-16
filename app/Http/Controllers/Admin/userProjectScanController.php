<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\userProjectScan;
use Illuminate\Http\Request;

class userProjectScanController extends Controller
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
            $userprojectscan = userProjectScan::where('project_id', 'LIKE', "%$keyword%")
                ->orWhere('user_id', 'LIKE', "%$keyword%")
                ->orWhere('project_owner_id', 'LIKE', "%$keyword%")
                ->orWhere('count', 'LIKE', "%$keyword%")
                ->paginate($perPage);
        } else {
            $userprojectscan = userProjectScan::paginate($perPage);
        }

        return view('admin.user-project-scan.index', compact('userprojectscan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.user-project-scan.create');
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
        
        userProjectScan::create($requestData);

        return redirect('admin/user-project-scan')->with('flash_message', 'userProjectScan added!');
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
        $userprojectscan = userProjectScan::findOrFail($id);

        return view('admin.user-project-scan.show', compact('userprojectscan'));
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
        $userprojectscan = userProjectScan::findOrFail($id);

        return view('admin.user-project-scan.edit', compact('userprojectscan'));
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
        
        $userprojectscan = userProjectScan::findOrFail($id);
        $userprojectscan->update($requestData);

        return redirect('admin/user-project-scan')->with('flash_message', 'userProjectScan updated!');
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
        userProjectScan::destroy($id);

        return redirect('admin/user-project-scan')->with('flash_message', 'userProjectScan deleted!');
    }
}
