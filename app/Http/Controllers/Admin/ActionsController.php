<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Action;
use Illuminate\Http\Request;
use App\object;
use Pawlox\VideoThumbnail\VideoThumbnail;
class ActionsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function google(Request $request) {
        $object_details = $this->getObjectDetails($request->input('object_id'));
        $objectActionDetails = $this->objectActionDetails($object_details->id);

        return view('actions.google', ['object_id' => $object_details->id, 'objectAction' => $objectActionDetails]);
    }

    public function facebook(Request $request) {
        $object_details = $this->getObjectDetails($request->input('object_id'));
        $objectActionDetails = $this->objectActionDetails($object_details->id);

        return view('actions.facebook', ['object_id' => $object_details->id, 'objectAction' => $objectActionDetails]);
    }

    public function audio(Request $request) {
        $object_details = $this->getObjectDetails($request->input('object_id'));
        $objectActionDetails = $this->objectActionDetails($object_details->id);

        return view('actions.audio', ['object_id' => $object_details->id, 'objectAction' => $objectActionDetails]);
    }

    public function video(Request $request) {
        $object_details = $this->getObjectDetails($request->input('object_id'));
        $objectActionDetails = $this->objectActionDetails($object_details->id);

        return view('actions.video', ['object_id' => $object_details->id, 'objectAction' => $objectActionDetails]);
    }

    public function image(Request $request) {
        $object_details = $this->getObjectDetails($request->input('object_id'));
        $objectActionDetails = $this->objectActionDetails($object_details->id);

        return view('actions.image', ['object_id' => $object_details->id, 'objectAction' => $object_details->object_image]);
    }

    public function email(Request $request) {
        $object_details = $this->getObjectDetails($request->input('object_id'));
        $objectActionDetails = $this->objectActionDetails($object_details->id);

        return view('actions.email', ['object_id' => $object_details->id, 'objectImage' => $object_details->object_image, 'objectAction' => $objectActionDetails]);
    }

    public function webLink(Request $request) {
        $object_details = $this->getObjectDetails($request->input('object_id'));
        $objectActionDetails = $this->objectActionDetails($object_details->id);

        return view('actions.webLink', ['object_id' => $object_details->id, 'objectImage' => $object_details->object_image, 'objectAction' => $objectActionDetails]);
    }

    public function event(Request $request) {
        $object_details = $this->getObjectDetails($request->input('object_id'));
        $objectActionDetails = $this->objectActionDetails($object_details->id);

        return view('actions.event', ['object_id' => $object_details->id, 'objectImage' => $object_details->object_image, 'objectAction' => $objectActionDetails]);
    }

    public function contact(Request $request) {
        $object_details = $this->getObjectDetails($request->input('object_id'));
        $objectActionDetails = $this->objectActionDetails($object_details->id);

        return view('actions.contact', ['object_id' => $object_details->id, 'objectImage' => $object_details->object_image, 'objectAction' => $objectActionDetails]);
    }

    public function youtube(Request $request) {
        $object_details = $this->getObjectDetails($request->input('object_id'));
        $objectActionDetails = $this->objectActionDetails($object_details->id);

        return view('actions.youtube', ['object_id' => $object_details->id, 'objectImage' => $object_details->object_image, 'objectAction' => $objectActionDetails]);
    }

    public function flip(Request $request) {
        $object_details = $this->getObjectDetails($request->input('object_id'));
        $objectActionDetails = $this->objectActionDetails($object_details->id);

        return view('actions.flip', ['object_id' => $object_details->id, 'objectImage' => $object_details->object_image, 'objectAction' => $objectActionDetails]);
    }

    public function screenShot(Request $request) {
        $object_details = $this->getObjectDetails($request->input('object_id'));
        $objectActionDetails = $this->objectActionDetails($object_details->id);

        return view('actions.screenShot', ['object_id' => $object_details->id, 'objectImage' => $object_details->object_image, 'objectAction' => $objectActionDetails]);
    }

    public function tapAudio(Request $request) {
        $object_details = $this->getObjectDetails($request->input('object_id'));
        $objectActionDetails = $this->objectActionDetails($object_details->id);

        return view('actions.tapAudio', ['object_id' => $object_details->id, 'objectImage' => $object_details->object_image, 'objectAction' => $objectActionDetails]);
    }

    public function tapVideo(Request $request) {
        $object_details = $this->getObjectDetails($request->input('object_id'));
        $objectActionDetails = $this->objectActionDetails($object_details->id);

        return view('actions.tapVideo', ['object_id' => $object_details->id, 'objectImage' => $object_details->object_image, 'objectAction' => $objectActionDetails]);
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
        $size = $request->file('get_social_google')->getClientSize();
        $imagePath = $this->uploadObjectFile($request, 'get_social_google', '/images/actions');



        $updateObjectImage = object::where('id', $object_id)->update(['size' => $size, 'object_image' => url($imagePath)]);
        list($width, $height) = getimagesize(url($imagePath));
        $ratio = $width / $height;
        $targetHeight = 70 / $ratio;
        return json_encode([
            'success' => '1',
            'path' => url($imagePath),
            'width' => $width,
            'height' => $height,
            'newHeight' => $targetHeight,
            'size' => $size
        ]);
    }

    public function imageUpload(Request $request) {

        $this->validate($request, [
            'object_id' => 'required',
            'imagefile' => 'required'
        ]);

        $object_id = $request->input('object_id');


        $size = $request->file('imagefile')->getClientSize();
        $imagePath = $this->uploadObjectFile($request, 'imagefile', '/images/actions');

        $updateObjectImage = object::where('id', $object_id)->update(['size' => $size, 'object_image' => url($imagePath)]);
        list($width, $height) = getimagesize(url($imagePath));
        $ratio = $width / $height;
        $targetHeight = 70 / $ratio;

        //    $size = parent::bytesToHuman($size);
        return json_encode([
            'success' => '1',
            'path' => url($imagePath),
            'width' => $width,
            'height' => $height,
            'newHeight' => $targetHeight,
            'size' => $size
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
        $size = $request->file('get_social_facebook')->getClientSize();
        // $size = parent::bytesToHuman($size);

        $imagePath = $this->uploadObjectFile($request, 'get_social_facebook', '/images/actions');


        $updateObjectImage = object::where('id', $object_id)->update(['size' => $size, 'object_image' => url($imagePath)]);

        list($width, $height) = getimagesize(url($imagePath));
        $ratio = $width / $height;
        $targetHeight = 70 / $ratio;

        return json_encode([
            'success' => '1',
            'path' => url($imagePath),
            'width' => $width,
            'height' => $height,
            'newHeight' => $targetHeight,
            'size' => $size
        ]);
    }

    public function audioUpload(Request $request) {
        $this->validate($request, [
            'audiofile' => 'required',
        ]);
        $object_id = $request->input('object_id');

        $size = $request->file('audiofile')->getClientSize();
        //dd($size);
        //$size = parent::bytesToHuman($size);
        $imagePath = $this->uploadMediaFile($request, 'audiofile', '/images/actions/media/');
        $data = [
            'object_id' => $object_id,
            'url' => url($imagePath),
            'size' => $size
        ];

        $checkObjectAction = Action::where('object_id', $object_id)->first();
        if (count($checkObjectAction) > 0):
            $addAction = Action::where('object_id', $object_id)->update($data);
        else:
            $addAction = Action::create($data);
        endif;
        return json_encode([
            'success' => '1',
            'size' => $size
        ]);
    }

    public function videoUpload(Request $request) {
        $this->validate($request, [
            'videofile' => 'required',
        ]);
        $object_id = $request->input('object_id');
        $size = $request->file('videofile')->getClientSize();
        $imagePath = $this->uploadMediaFile($request, 'videofile', '/images/actions/media/');
        $thumb = new VideoThumbnail;
        $thumbname = time().'.jpg';
        $thumPath = '/images/thumbnails';
        $datas = $thumb->createThumbnail( url($imagePath), public_path($thumPath).$thumbname, 2, 400, 200);
        //  $size = parent::bytesToHuman($size);
        $updateObjectImage = object::where('id', $object_id)->update(['size' => $size, 'object_image' => url($thumPath.$thumbname)]);

        $data = [
            'object_id' => $object_id,
            'url' => url($imagePath),
            'size' => $size
        ];

        $checkObjectAction = Action::where('object_id', $object_id)->first();
        if (count($checkObjectAction) > 0):
            $addAction = Action::where('object_id', $object_id)->update($data);
        else:
            $addAction = Action::create($data);
        endif;
        return json_encode([
            'success' => '1',
            'datas'=>$datas
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

        if ($request->file('imagefile') === null):
            return json_encode([
                'success' => $email,
            ]);
        endif;
        $size = $request->file('imagefile')->getClientSize();
        $imagePath = $this->uploadObjectFile($request, 'imagefile', '/images/actions');

        $updateObjectImage = object::where('id', $object_id)->update(['size' => $size, 'object_image' => url($imagePath)]);

        list($width, $height) = getimagesize(url($imagePath));
        $ratio = $width / $height;
        $targetHeight = 70 / $ratio;
        return json_encode([
            'success' => '1',
            'path' => url($imagePath),
            'width' => $width,
            'height' => $height,
            'newHeight' => $targetHeight
        ]);
    }

    public function webLinkUpload(Request $request) {

        $object_id = $request->input('object_id');
        $webLink = $request->input('webLink');

        $data = [
            'object_id' => $object_id,
            'message' => $webLink,
        ];

        $checkObjectAction = Action::where('object_id', $object_id)->first();
        if (count($checkObjectAction) > 0):
            $addAction = Action::where('object_id', $object_id)->update($data);
        else:
            $addAction = Action::create($data);
        endif;

        if ($request->file('imagefile') === null):
            return json_encode([
                'success' => $webLink,
            ]);
        endif;
        $size = $request->file('imagefile')->getClientSize();
        $imagePath = $this->uploadObjectFile($request, 'imagefile', '/images/actions');

        $updateObjectImage = object::where('id', $object_id)->update(['size' => $size, 'object_image' => url($imagePath)]);

        list($width, $height) = getimagesize(url($imagePath));
        $ratio = $width / $height;
        $targetHeight = 70 / $ratio;
        return json_encode([
            'success' => '1',
            'path' => url($imagePath),
            'width' => $width,
            'height' => $height,
            'newHeight' => $targetHeight
        ]);
    }

    public function eventUpload(Request $request) {

        $object_id = $request->input('object_id');
        $eventJson = json_encode($request->all());
        $data = [
            'object_id' => $object_id,
            'message' => $eventJson,
        ];

        $checkObjectAction = Action::where('object_id', $object_id)->first();
        if (count($checkObjectAction) > 0):
            $addAction = Action::where('object_id', $object_id)->update($data);
        else:
            $addAction = Action::create($data);
        endif;

        if ($request->file('imagefile') === null):
            return json_encode([
                'success' => $eventJson,
            ]);
        endif;
        $size = $request->file('imagefile')->getClientSize();
        $imagePath = $this->uploadObjectFile($request, 'imagefile', '/images/actions');

        $updateObjectImage = object::where('id', $object_id)->update(['size' => $size, 'object_image' => url($imagePath)]);

        list($width, $height) = getimagesize(url($imagePath));
        $ratio = $width / $height;
        $targetHeight = 70 / $ratio;
        return json_encode([
            'success' => '1',
            'path' => url($imagePath),
            'width' => $width,
            'height' => $height,
            'newHeight' => $targetHeight
        ]);
    }

    public function contactUpload(Request $request) {

        $object_id = $request->input('object_id');
        $contactJson = json_encode($request->all());
        $data = [
            'object_id' => $object_id,
            'message' => $contactJson,
        ];

        $checkObjectAction = Action::where('object_id', $object_id)->first();
        if (count($checkObjectAction) > 0):
            $addAction = Action::where('object_id', $object_id)->update($data);
        else:
            $addAction = Action::create($data);
        endif;

        if ($request->file('imagefile') === null):
            return json_encode([
                'success' => $contactJson,
            ]);
        endif;
        $size = $request->file('imagefile')->getClientSize();
        $imagePath = $this->uploadObjectFile($request, 'imagefile', '/images/actions');

        $updateObjectImage = object::where('id', $object_id)->update(['size' => $size, 'object_image' => url($imagePath)]);

        list($width, $height) = getimagesize(url($imagePath));
        $ratio = $width / $height;
        $targetHeight = 70 / $ratio;
        return json_encode([
            'success' => '1',
            'path' => url($imagePath),
            'width' => $width,
            'height' => $height,
            'newHeight' => $targetHeight
        ]);
    }

    public function youtubeUpload(Request $request) {

        $object_id = $request->input('object_id');
        $youtubeLink = $request->input('youtube');
        //$videoId = $this->youtubeID($youtubeLink);
        $videoId = explode('=', $youtubeLink);

        $image = "https://img.youtube.com/vi/" . $videoId[1] . "/0.jpg";
        $data = [
            'object_id' => $object_id,
            'message' => $youtubeLink,
        ];
        $updateObjectImage = object::where('id', $object_id)->update(['object_image' => $image]);

        $checkObjectAction = Action::where('object_id', $object_id)->first();
        if (count($checkObjectAction) > 0):
            $addAction = Action::where('object_id', $object_id)->update($data);
        else:
            $addAction = Action::create($data);
        endif;

        if ($request->file('imagefile') === null):
            list($width, $height) = getimagesize($image);
            $ratio = $width / $height;
            $targetHeight = 70 / $ratio;
            return json_encode([
                'success' => '1',
                'path' => $image,
                'width' => $width,
                'height' => $height,
                'newHeight' => $targetHeight
            ]);
        endif;
        $imagePath = $this->uploadObjectFile($request, 'imagefile', '/images/actions');

        $updateObjectImage = object::where('id', $object_id)->update(['object_image' => url($imagePath)]);

        list($width, $height) = getimagesize(url($imagePath));
        $ratio = $width / $height;
        $targetHeight = 70 / $ratio;
        return json_encode([
            'success' => '1',
            'path' => url($imagePath),
            'width' => $width,
            'height' => $height,
            'newHeight' => $targetHeight
        ]);
    }

    public function flipUpload(Request $request) {

        $object_id = $request->input('object_id');



        if ($request->file('imagefile') === null):
            return json_encode([
                'success' => 0,
            ]);
        endif;
        $size = $request->file('imagefile')->getClientSize();
        $imagePath = $this->uploadObjectFile($request, 'imagefile', '/images/actions');

        $updateObjectImage = object::where('id', $object_id)->update(['size' => $size, 'object_image' => url($imagePath)]);

        list($width, $height) = getimagesize(url($imagePath));
        $ratio = $width / $height;
        $targetHeight = 70 / $ratio;
        return json_encode([
            'success' => '1',
            'path' => url($imagePath),
            'width' => $width,
            'height' => $height,
            'newHeight' => $targetHeight
        ]);
    }

    public function screenShotUpload(Request $request) {

        $object_id = $request->input('object_id');



        if ($request->file('imagefile') === null):
            return json_encode([
                'success' => 0,
            ]);
        endif;
        $size = $request->file('imagefile')->getClientSize();
        $imagePath = $this->uploadObjectFile($request, 'imagefile', '/images/actions');

        $updateObjectImage = object::where('id', $object_id)->update(['size' => $size, 'object_image' => url($imagePath)]);

        list($width, $height) = getimagesize(url($imagePath));
        $ratio = $width / $height;
        $targetHeight = 70 / $ratio;
        return json_encode([
            'success' => '1',
            'path' => url($imagePath),
            'width' => $width,
            'height' => $height,
            'newHeight' => $targetHeight
        ]);
    }

    public function tapAudioUpload(Request $request) {
        $this->validate($request, [
            'audiofile' => 'required',
        ]);
        $object_id = $request->input('object_id');

        $size = $request->file('audiofile')->getClientSize();
        //dd($size);
        //$size = parent::bytesToHuman($size);
        $imagePath = $this->uploadMediaFile($request, 'audiofile', '/images/actions/media/');
        $data = [
            'object_id' => $object_id,
            'url' => url($imagePath),
            'size' => $size
        ];

        $checkObjectAction = Action::where('object_id', $object_id)->first();
        if (count($checkObjectAction) > 0):
            $addAction = Action::where('object_id', $object_id)->update($data);
        else:
            $addAction = Action::create($data);
        endif;
        if ($request->file('imagefile') === null):
            return json_encode([
                'success' => '1',
                'size' => $size
            ]);
        endif;


        $size = $request->file('imagefile')->getClientSize();
        $imagePath_new = $this->uploadObjectFile($request, 'imagefile', '/images/actions');

        $updateObjectImage = object::where('id', $object_id)->update(['size' => $size, 'object_image' => url($imagePath_new)]);

        list($width, $height) = getimagesize(url($imagePath_new));
        $ratio = $width / $height;
        $targetHeight = 70 / $ratio;
        return json_encode([
            'success' => '1',
            'path' => url($imagePath_new),
            'width' => $width,
            'height' => $height,
            'newHeight' => $targetHeight
        ]);
    }

    public function tapVideoUpload(Request $request) {
        $this->validate($request, [
            'videofile' => 'required',
        ]);
        $object_id = $request->input('object_id');
        $size = $request->file('videofile')->getClientSize();
        $imagePath = $this->uploadMediaFile($request, 'videofile', '/images/actions/media/');

        //  $size = parent::bytesToHuman($size);
        $data = [
            'object_id' => $object_id,
            'url' => url($imagePath),
            'size' => $size
        ];

        $checkObjectAction = Action::where('object_id', $object_id)->first();
        if (count($checkObjectAction) > 0):
            $addAction = Action::where('object_id', $object_id)->update($data);
        else:
            $addAction = Action::create($data);
        endif;
        if ($request->file('imagefile') === null):
            return json_encode([
                'success' => '1',
                'size' => $size
            ]);
        endif;


        $size = $request->file('imagefile')->getClientSize();
        $imagePath_new = $this->uploadObjectFile($request, 'imagefile', '/images/actions');

        $updateObjectImage = object::where('id', $object_id)->update(['size' => $size, 'object_image' => url($imagePath_new)]);

        list($width, $height) = getimagesize(url($imagePath_new));
        $ratio = $width / $height;
        $targetHeight = 70 / $ratio;
        return json_encode([
            'success' => '1',
            'path' => url($imagePath_new),
            'width' => $width,
            'height' => $height,
            'newHeight' => $targetHeight
        ]);
    }

    public function getObjectDetails($object_id) {
        return $id = object::where('object_div', $object_id)->first();
    }

    public function objectActionDetails($object_id) {
        return $id = Action::where('object_id', $object_id)->first();
    }

    public function updateHieghtNewObject(Request $request) {
        $object_id = $request->input('id');
        $height = $request->input('height');
        object::where('object_div', $object_id)->update([
            'height' => $height
        ]);
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

    function youtubeID($url) {
        $res = explode("v", $url);
        if (isset($res[1])) {
            $res1 = explode('&', $res[1]);
            if (isset($res1[1])) {
                $res[1] = $res1[0];
            }
            $res1 = explode('#', $res[1]);
            if (isset($res1[1])) {
                $res[1] = $res1[0];
            }
        }
        return substr($res[1], 1, 12);
        return false;
    }

}
