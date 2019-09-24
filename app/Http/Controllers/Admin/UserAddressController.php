<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\UserAddress;
use Illuminate\Http\Request;

class UserAddressController extends Controller
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
            $useraddress = UserAddress::where('user_id', 'LIKE', "%$keyword%")
                ->orWhere('name', 'LIKE', "%$keyword%")
                ->orWhere('mobile', 'LIKE', "%$keyword%")
                ->orWhere('pin_code', 'LIKE', "%$keyword%")
                ->orWhere('city', 'LIKE', "%$keyword%")
                ->orWhere('state', 'LIKE', "%$keyword%")
                ->orWhere('address_1', 'LIKE', "%$keyword%")
                ->orWhere('address_2', 'LIKE', "%$keyword%")
                ->orWhere('landmark', 'LIKE', "%$keyword%")
                ->paginate($perPage);
        } else {
            $useraddress = UserAddress::paginate($perPage);
        }

        return view('admin.user-address.index', compact('useraddress'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.user-address.create');
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
        $this->validate($request, [
			'user_id' => 'required',
			'name' => 'required',
			'mobile' => 'required',
			'pin_code' => 'required',
			'city' => 'required',
			'state' => 'required',
			'address_1' => 'required',
			'address_2' => 'required',
			'landmark' => 'required'
		]);
        $requestData = $request->all();
        
        UserAddress::create($requestData);

        return redirect('admin/user-address')->with('flash_message', 'UserAddress added!');
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
        $useraddress = UserAddress::findOrFail($id);

        return view('admin.user-address.show', compact('useraddress'));
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
        $useraddress = UserAddress::findOrFail($id);

        return view('admin.user-address.edit', compact('useraddress'));
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
        $this->validate($request, [
			'user_id' => 'required',
			'name' => 'required',
			'mobile' => 'required',
			'pin_code' => 'required',
			'city' => 'required',
			'state' => 'required',
			'address_1' => 'required',
			'address_2' => 'required',
			'landmark' => 'required'
		]);
        $requestData = $request->all();
        
        $useraddress = UserAddress::findOrFail($id);
        $useraddress->update($requestData);

        return redirect('admin/user-address')->with('flash_message', 'UserAddress updated!');
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
        UserAddress::destroy($id);

        return redirect('admin/user-address')->with('flash_message', 'UserAddress deleted!');
    }
}
