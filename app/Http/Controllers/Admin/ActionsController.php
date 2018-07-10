<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Action;
use Illuminate\Http\Request;
use App\object;

class ActionsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function google(Request $request) {
        $object_details = $this->getObjectDetails($request->get('object_id'));
        $objectActionDetails = $this->objectActionDetails($object_details->id);

        return view('actions.google', ['object_id' => $object_details->id, 'objectAction' => $objectActionDetails]);
    }

    public function facebook(Request $request) {
        $object_details = $this->getObjectDetails($request->get('object_id'));
        $objectActionDetails = $this->objectActionDetails($object_details->id);

        return view('actions.facebook', ['object_id' => $object_details->id, 'objectAction' => $objectActionDetails]);
    }

    public function audio(Request $request) {
        $object_details = $this->getObjectDetails($request->get('object_id'));
        $objectActionDetails = $this->objectActionDetails($object_details->id);

        return view('actions.audio', ['object_id' => $object_details->id, 'objectAction' => $objectActionDetails]);
    }

    public function video(Request $request) {
        $object_details = $this->getObjectDetails($request->get('object_id'));
        $objectActionDetails = $this->objectActionDetails($object_details->id);

        return view('actions.video', ['object_id' => $object_details->id, 'objectAction' => $objectActionDetails]);
    }

    public function email(Request $request) {
        $object_details = $this->getObjectDetails($request->get('object_id'));
        $objectActionDetails = $this->objectActionDetails($object_details->id);

        return view('actions.email', ['object_id' => $object_details->id, 'objectAction' => $objectActionDetails]);
    }

    public function googleUpload(Request $request) {

        $this->validate($request, [
            'object_id' => 'required',
            'google_msg' => 'required',
        ]);

        $object_id = $request->input('object_id');
        $message = $request->input('google_msg');
        $trigger = $request->input('g_default');
        $data = [
            'object_id' => $object_id,
            'message' => $message,
            'trigger' => $trigger
        ];

        $checkObjectAction = Action::where('object_id', $object_id)->first();
        if (count($checkObjectAction) > 0):
            $addAction = Action::where('object_id', $object_id)->update($data);
        else:
            $addAction = Action::create($data);
        endif;


        if ($request->file('get_social_google') === null):
            return json_encode([
                'success' => '1',
            ]);
        endif;
        $imagePath = $this->uploadObjectFile($request, 'get_social_google', '/images/actions');

        $updateObjectImage = object::where('id', $object_id)->update(['object_image' => url($imagePath)]);

        return json_encode([
            'success' => '1',
            'path' => url($imagePath)
        ]);
    }

    public function facebookUpload(Request $request) {

        $this->validate($request, [
            'object_id' => 'required',
            'facebook_msg' => 'required',
        ]);

        $object_id = $request->input('object_id');
        $message = $request->input('facebook_msg');
        $trigger = $request->input('f_default');
        $data = [
            'object_id' => $object_id,
            'message' => $message,
            'trigger' => $trigger
        ];

        $checkObjectAction = Action::where('object_id', $object_id)->first();
        if (count($checkObjectAction) > 0):
            $addAction = Action::where('object_id', $object_id)->update($data);
        else:
            $addAction = Action::create($data);
        endif;


        if ($request->file('get_social_facebook') === null):
            return json_encode([
                'success' => '1',
            ]);
        endif;
        $imagePath = $this->uploadObjectFile($request, 'get_social_facebook', '/images/actions');

        $updateObjectImage = object::where('id', $object_id)->update(['object_image' => url($imagePath)]);

        return json_encode([
            'success' => '1',
            'path' => url($imagePath)
        ]);
    }

    public function audioUpload(Request $request) {
        $this->validate($request, [
            'audiofile' => 'required',
        ]);
        $object_id = $request->input('object_id');

        $imagePath = $this->uploadMediaFile($request, 'audiofile', '/images/actions/media/');
        $data = [
            'object_id' => $object_id,
            'url' => url($imagePath),
        ];

        $checkObjectAction = Action::where('object_id', $object_id)->first();
        if (count($checkObjectAction) > 0):
            $addAction = Action::where('object_id', $object_id)->update($data);
        else:
            $addAction = Action::create($data);
        endif;
        return json_encode([
            'success' => '1',
        ]);
    }

    public function videoUpload(Request $request) {
        $this->validate($request, [
            'videofile' => 'required',
        ]);
        $object_id = $request->input('object_id');

        $imagePath = $this->uploadMediaFile($request, 'videofile', '/images/actions/media/');
        $data = [
            'object_id' => $object_id,
            'url' => url($imagePath),
        ];

        $checkObjectAction = Action::where('object_id', $object_id)->first();
        if (count($checkObjectAction) > 0):
            $addAction = Action::where('object_id', $object_id)->update($data);
        else:
            $addAction = Action::create($data);
        endif;
        return json_encode([
            'success' => '1',
        ]);
    }

    public function emailUpload(Request $request) {

        $object_id = $request->input('object_id');
        $email = $request->input('email');

        $data = [
            'object_id' => $object_id,
            'message' => $email,
        ];
    
        $checkObjectAction = Action::where('object_id', $object_id)->first();
        if (count($checkObjectAction) > 0):
            $addAction = Action::where('object_id', $object_id)->update($data);
        else:
            $addAction = Action::create($data);
        endif;
        return json_encode([
            'success' => '1',
        ]);
    }

    public function getObjectDetails($object_id) {
        return $id = object::where('object_div', $object_id)->first();
    }

    public function objectActionDetails($object_id) {
        return $id = Action::where('object_id', $object_id)->first();
    }

    public function index(Request $request) {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $actions = Action::where('url', 'LIKE', "%$keyword%")
                    ->orWhere('image', 'LIKE', "%$keyword%")
                    ->orWhere('params', 'LIKE', "%$keyword%")
                    ->orWhere('object_id', 'LIKE', "%$keyword%")
                    ->paginate($perPage);
        } else {
            $actions = Action::paginate($perPage);
        }

        return view('actions.index', compact('actions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create() {
        return view('actions.create');
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

        Action::create($requestData);

        return redirect('admin/actions')->with('flash_message', 'Action added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id) {
        $action = Action::findOrFail($id);

        return view('actions.show', compact('action'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id) {
        $action = Action::findOrFail($id);

        return view('actions.edit', compact('action'));
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

        $action = Action::findOrFail($id);
        $action->update($requestData);

        return redirect('admin/actions')->with('flash_message', 'Action updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id) {
        Action::destroy($id);

        return redirect('admin/actions')->with('flash_message', 'Action deleted!');
    }

}
