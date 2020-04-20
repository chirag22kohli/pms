<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\UserScanPack;
use Illuminate\Http\Request;
use App\Scanpack;
use Auth;
use Rap2hpoutre\LaravelStripeConnect\StripeConnect;

class UserScanPacksController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request) {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $userscanpacks = UserScanPack::where('user_id', 'LIKE', "%$keyword%")
                    ->orWhere('scan_pack_id', 'LIKE', "%$keyword%")
                    ->orWhere('scans', 'LIKE', "%$keyword%")
                    ->orWhere('scans_used', 'LIKE', "%$keyword%")
                    ->orWhere('limit_set', 'LIKE', "%$keyword%")
                    ->orWhere('used_limit', 'LIKE', "%$keyword%")
                    ->orWhere('total_scan_packs', 'LIKE', "%$keyword%")
                    ->orWhere('used_scan_packs', 'LIKE', "%$keyword%")
                    ->orWhere('user_plan_id', 'LIKE', "%$keyword%")
                    ->paginate($perPage);
        } else {
            $userscanpacks = UserScanPack::paginate($perPage);
        }

        return view('admin.user-scan-packs.index', compact('userscanpacks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create() {
        return view('admin.user-scan-packs.create');
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

        UserScanPack::create($requestData);

        return redirect('admin/user-scan-packs')->with('flash_message', 'User Scan Pack added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id) {
        $userscanpack = UserScanPack::findOrFail($id);

        return view('admin.user-scan-packs.show', compact('userscanpack'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id) {
        $userscanpack = UserScanPack::findOrFail($id);

        return view('admin.user-scan-packs.edit', compact('userscanpack'));
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

        $userscanpack = UserScanPack::findOrFail($id);
        $userscanpack->update($requestData);

        return redirect('admin/user-scan-packs')->with('flash_message', 'User Scan Pack updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id) {
        UserScanPack::destroy($id);

        return redirect('admin/user-scan-packs')->with('flash_message', 'User Scan Pack deleted!');
    }

    public function setTrackerLimit(Request $request) {

        $getScanPack = Scanpack::first();
        $scanpackPrice = $getScanPack->price;
        $calculatedScanPacks = $request->get('limit') / $scanpackPrice;

        $updateLimit = UserScanPack::where('user_id', Auth::id())->update([
            'limit_set' => $request->get('limit'),
            'total_scan_packs' => $calculatedScanPacks,
            'month'=>date('m')
        ]);

        return redirect('client/scanpack')->with('flash_message', 'Limit Updated Successfully');
    }

    public function updateScanPack() {
        $getScanPack = Scanpack::first();
        $scanpackPrice = $getScanPack->price;
        $scanpackAllowed = $getScanPack->scans;

        $updateLimit = UserScanPack::where('user_id', Auth::id())->first();
        $scanPacksTotal = $updateLimit->total_scan_packs;
        $scanPacksLeft = $scanPacksTotal - $updateLimit->used_scan_packs;
        $projectAdmin = \App\User::where('id', '2')->first();
        if ($scanPacksLeft > 0 && $updateLimit->scans == 0) {
            try {

                $charge = StripeConnect::transaction()
                        ->amount($scanpackPrice * 100, 'sgd')
                        ->useSavedCustomer()
                        ->from(Auth::user())
                        ->to($projectAdmin)
                        ->create();
            } catch (\Exception $e) {

                $removeInvalidCustomer = Stripe::where('user_id', Auth::id())->update(['customer_id' => null]);
                return false;
            }

            if ($charge->status == 'succeeded') {
                $historyParams = [
                    'payment_params' => json_encode($charge),
                    'user_id' => Auth::id(),
                    'scan_pack_id' => $getScanPack->id,
                    'date_purchased' => date('d/m/Y'),
                    'payment_type' => 'Scan Pack Upgraded',
                    'price_paid' => $scanpackPrice,
                    'scans_credited' => $scanpackAllowed,
                    'payment_status' => 1
                ];
                \App\PaidScanPacksHistory::create($historyParams);
                $newUsedLimit = $updateLimit->used_limit + $scanpackPrice;
                $deductScanPackLimit = $updateLimit->total_scan_packs - 1;
                $usedScanPacks = $updateLimit->used_scan_packs + 1;
                $updateUserScanPack = UserScanPack::where('user_id', Auth::id())->update([
                    'scans_used' => 0,
                    'used_limit' => $newUsedLimit,
                    'scans' => $scanpackAllowed,
                    'total_scan_packs' => $deductScanPackLimit,
                    'used_scan_packs' => $usedScanPacks
                ]);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}
