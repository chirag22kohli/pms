<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\tutorialManager;
use Illuminate\Http\Request;
use DB;
class tutorialManagerController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request) {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $tutorialmanager = tutorialManager::where('image', 'LIKE', "%$keyword%")
                    ->orWhere('text', 'LIKE', "%$keyword%")
                    ->paginate($perPage);
        } else {
            $tutorialmanager = tutorialManager::paginate($perPage);
        }

        return view('admin.tutorial-manager.index', compact('tutorialmanager'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create() {
        return view('admin.tutorial-manager.create');
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



        $size = $request->file('image')->getClientSize();
        $imagePath = $this->uploadTutorialFile($request, 'image', '/images/tutorial');



        $str = substr($imagePath, 1);
        $sha1file = sha1_file($str);


        tutorialManager::create($requestData);
        $tutId = DB::getPdo()->lastInsertId();

        $update = tutorialManager::where('id', $tutId)->update([
            'image' => url($imagePath),
        ]);



        return redirect('admin/tutorial-manager')->with('flash_message', 'tutorialManager added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id) {
        $tutorialmanager = tutorialManager::findOrFail($id);

        return view('admin.tutorial-manager.show', compact('tutorialmanager'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id) {
        $tutorialmanager = tutorialManager::findOrFail($id);

        return view('admin.tutorial-manager.edit', compact('tutorialmanager'));
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

        $tutorialmanager = tutorialManager::findOrFail($id);
        $tutorialmanager->update($requestData);

        return redirect('admin/tutorial-manager')->with('flash_message', 'tutorialManager updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id) {
        tutorialManager::destroy($id);

        return redirect('admin/tutorial-manager')->with('flash_message', 'tutorialManager deleted!');
    }

}
