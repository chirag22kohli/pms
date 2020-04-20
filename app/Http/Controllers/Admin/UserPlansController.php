<?php

namespace App\Http\Controllers\admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\UserPlan;
use Illuminate\Http\Request;

class UserPlansController extends Controller
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
            $userplans = UserPlan::where('user_id', 'LIKE', "%$keyword%")
                ->orWhere('plan_id', 'LIKE', "%$keyword%")
                ->orWhere('payment_status', 'LIKE', "%$keyword%")
                ->orWhere('payment_params', 'LIKE', "%$keyword%")
                ->orWhere('plan_expiry_date', 'LIKE', "%$keyword%")
                ->orWhere('created_by', 'LIKE', "%$keyword%")
                ->paginate($perPage);
        } else {
            $userplans = UserPlan::paginate($perPage);
        }

        return view('admin.user-plans.index', compact('userplans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.user-plans.create');
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
        
        UserPlan::create($requestData);

        return redirect('admin/user-plans')->with('flash_message', 'User Plan added!');
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
        $userplan = UserPlan::findOrFail($id);

        return view('admin.user-plans.show', compact('userplan'));
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
        $userplan = UserPlan::findOrFail($id);

        return view('admin.user-plans.edit', compact('userplan'));
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
        
        $userplan = UserPlan::findOrFail($id);
        $userplan->update($requestData);

        return redirect('admin/user-plans')->with('flash_message', 'User Plan updated!');
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
        UserPlan::destroy($id);

        return redirect('admin/user-plans')->with('flash_message', 'User Plan deleted!');
    }
}
