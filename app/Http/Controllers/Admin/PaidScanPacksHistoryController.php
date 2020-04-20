<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\PaidScanPacksHistory;
use Illuminate\Http\Request;

class PaidScanPacksHistoryController extends Controller
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
            $paidscanpackshistory = PaidScanPacksHistory::where('user_id', 'LIKE', "%$keyword%")
                ->orWhere('scan_pack_id', 'LIKE', "%$keyword%")
                ->orWhere('date_purchased', 'LIKE', "%$keyword%")
                ->orWhere('scans_credited', 'LIKE', "%$keyword%")
                ->orWhere('payment_params', 'LIKE', "%$keyword%")
                ->orWhere('payment_type', 'LIKE', "%$keyword%")
                ->orWhere('payment_status', 'LIKE', "%$keyword%")
                ->paginate($perPage);
        } else {
            $paidscanpackshistory = PaidScanPacksHistory::paginate($perPage);
        }

        return view('admin.paid-scan-packs-history.index', compact('paidscanpackshistory'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.paid-scan-packs-history.create');
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
        
        PaidScanPacksHistory::create($requestData);

        return redirect('admin/paid-scan-packs-history')->with('flash_message', 'PaidScanPacksHistory added!');
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
        $paidscanpackshistory = PaidScanPacksHistory::findOrFail($id);

        return view('admin.paid-scan-packs-history.show', compact('paidscanpackshistory'));
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
        $paidscanpackshistory = PaidScanPacksHistory::findOrFail($id);

        return view('admin.paid-scan-packs-history.edit', compact('paidscanpackshistory'));
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
        
        $paidscanpackshistory = PaidScanPacksHistory::findOrFail($id);
        $paidscanpackshistory->update($requestData);

        return redirect('admin/paid-scan-packs-history')->with('flash_message', 'PaidScanPacksHistory updated!');
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
        PaidScanPacksHistory::destroy($id);

        return redirect('admin/paid-scan-packs-history')->with('flash_message', 'PaidScanPacksHistory deleted!');
    }
}
