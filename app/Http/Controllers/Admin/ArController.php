<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use App\Project;
use App\Object;
use App\Tracker;
use Image;
use Illuminate\Support\Facades\Input;

class ArController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    const JSON_CONTENT_TYPE = 'application/json';
    const ACCESS_KEY = '72a4c0a54659757ae901449adcfd5b82e02a5da2';
    const SECRET_KEY = '2bca7331b17c8fa727e54c260c2f3a8c68b0db88';
    const BASE_URL = 'https://vws.vuforia.com';
    const TARGETS_PATH = '/targets';
    const ID_INDEX = 0;
    const IMAGE_INDEX = 1;
    const WINE_COM_URL = 2;
    const VINTAGE = 3;
    const WINERY_NAME = 4;

    public $imagePath = '/';
    public $imageName = 'fr.png';

    public function index(Request $request) {

        $trackerId = $request->input('id');

        $trackerDetails = Tracker::where('id', $trackerId)->first();
        $objectLastId = Object::where('tracker_id', $trackerDetails->id)->orderBy('id', 'desc')->first();
        $objects = Object::where('tracker_id', $trackerId)->get();
        if (count($objectLastId) > 0):
            $cloneId = $objectLastId->id + 1;
        else:
            $lastId = Object::orderBy('id', 'desc')->first();
            if (count($lastId) > 0):
                $cloneId = $lastId->id + 1;
            else:
                $cloneId = 1;
            endif;

        endif;
        if (count($trackerDetails) > 0):
            return view('ar.dashboard', ['trackerDetails' => $trackerDetails, 'tracker_id' => $trackerId, 'tracker' => $trackerDetails->tracker_path, 'cloneId' => $cloneId, 'objects' => $objects]);
        else:
            return 'Tracker Not Found';
        endif;
    }

    public function qrCode() {
        return view('client.qr');
    }

    public function trackerUpload(Request $request) {

        $this->validate($request, [
            'trackerImage' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePath = $this->uploadFile($request, 'trackerImage', '/images/trackers');
        $tracker_id = $request->input('tracker_id');
        $str = substr($imagePath, 1);
        if ($this->checkDup($str)) {
            $filename = $imagePath;
            $sha1file = sha1_file($str);
            $update = Tracker::where('id', $tracker_id)->update([
                'tracker_path' => $imagePath,
                'sha' => $sha1file
            ]);

            return json_encode([
                'success' => '1',
                'path' => url($imagePath)
            ]);
        } else {
            return json_encode([
                'success' => '0',
                'path' => ''
            ]);
        }
        //$img = Image::make($request->file('trackerImage')->getRealPath());
        //$image->save(public_path('images/' . time() . '.jpg'));
        //$image->fit(300, 200)->save(public_path('images/' . time() . '-thumbs.jpg'));
    }

    public function finalizeTracker(Request $request) {
        $this->validate($request, [
            'tracker_id' => 'required',
        ]);

        $tracker_id = $request->input('tracker_id');

        $trackerDetails = Tracker::where('id', $tracker_id)->with('objects')->first();
        if (count($trackerDetails) > 0) {
            $trackerDimensions = [
                'height' => $trackerDetails->height,
                'width' => $trackerDetails->width
            ];
            if ($trackerDetails->parm != '') {
                $trackerVuforia = json_decode($trackerDetails->parm);

                $vuforiaParams = $this->updateVuforia($trackerDimensions, $trackerDetails->project_id, $trackerVuforia->target_id, $trackerDetails->tracker_path, $trackerDetails['objects']);
                $updateTracker = Tracker::where('id', $tracker_id)->update(['updated_vuforia' => $vuforiaParams]);
                return [
                    'obj' => $trackerDetails['objects'],
                    'parms' => $vuforiaParams
                ];
            } else {
                $vuforiaParams = $this->uploadDataVuforia($trackerDimensions,$trackerDetails->project_id, $trackerDetails->tracker_path, $trackerDetails['objects']);
                $trackerVuforia = json_decode($vuforiaParams);
                $updateTracker = Tracker::where('id', $tracker_id)->update(['target_id' => $trackerVuforia->target_id, 'parm' => $vuforiaParams]);
                return $vuforiaParams;
            }
        } else {
            return 0;
        }
    }

    public function updateVuforia($trackerDimensions,$project_id, $id, $trackerUrl, $objectData) {

        $imagePath = '';
        $imageName = public_path($trackerUrl);
        $this->imagePath = '/';
        $this->imageName = public_path($trackerUrl);
        $image = file_get_contents($imagePath . $imageName);
        $image_base64 = base64_encode($image);
        // Use date to create unique filenames on server
        $date = new DateTime();
        $dateTime = $date->getTimestamp();
        $file = pathinfo($this->imageName);
        $filename = $file['filename'];
        $fileextension = $file['extension'];
        $post_data = array(
            'name' => $filename . "_" . $dateTime . "." . $fileextension,
            'width' => 74.5,
            'image' => $image_base64,
            'application_metadata' => $this->createMetadata($trackerDimensions,$project_id, $objectData),
            'active_flag' => 1
        );

        $data_json = json_encode($post_data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::BASE_URL . self::TARGETS_PATH . '/' . $id);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->getHeaders('PUT', self::TARGETS_PATH . '/' . $id, self::JSON_CONTENT_TYPE, $data_json));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    public function uploadDataVuforia($trackerDimensions, $project_id, $trackerUrl, $objectData) {
        $imagePath = '';
        $imageName = public_path($trackerUrl);
        $this->imagePath = '/';
        $this->imageName = public_path($trackerUrl);
        $ch = curl_init(self::BASE_URL . self::TARGETS_PATH);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $image = file_get_contents($imagePath . $imageName);
        $image_base64 = base64_encode($image);
        // Use date to create unique filenames on server
        $date = new DateTime();
        $dateTime = $date->getTimestamp();
        $file = pathinfo($this->imageName);
        $filename = $file['filename'];
        $fileextension = $file['extension'];
        $post_data = array(
            'name' => $filename . "_" . $dateTime . "." . $fileextension,
            'width' => 74.5,
            'image' => $image_base64,
            'application_metadata' => $this->createMetadata($trackerDimensions,$project_id, $objectData),
            'active_flag' => 1
        );
        $body = json_encode($post_data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->getHeaders('POST', self::TARGETS_PATH, self::JSON_CONTENT_TYPE, $body));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        $response = curl_exec($ch);
        $info = curl_getinfo($ch);
        if ($info['http_code'] !== 201) {
            print 'Failed to add target: ' . $response;
            return 'none';
        } else {
            $vuforiaTargetID = json_decode($response)->target_id;
            // print 'Successfully added target: ' . $vuforiaTargetID . "\n";
            return $response;
        }
    }

    /**
     * Get the target record of a target from database accessed by the given keys.
     * @param vuforiaTargetID - ID of a target in Vuforia database
     * @return [String] - Vuforia Target Record
     */
    public function getTargetRecord($vuforiaTargetID) {
        $ch = curl_init(self::BASE_URL . self::TARGETS_PATH . "/" . $vuforiaTargetID);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->getHeaders('GET', $path = self::TARGETS_PATH . '/' . $vuforiaTargetID, $content_type = '', $body = ''));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $info = curl_getinfo($ch);
        if ($info['http_code'] !== 200) {
            //return "No target with ID: " .$vuforiaTargetID;
            die('Failed to list targets: ' . $response . "\n");
        }
        // $trackinRate = json_decode($response)->target_record->tracking_rating;
        return json_decode($response);
    }

    /**
     * Delete a target from database accessed by the given keys.
     * @param vuforiaTargetID - ID of a target in Vuforia database
     * @return [String] Vuforia result_code
     */
    public function deleteTarget($vuforiaTargetID) {
        $path = self::TARGETS_PATH . "/" . $vuforiaTargetID;
        $ch = curl_init(self::BASE_URL . $path);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->getHeaders('DELETE', $path));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $info = curl_getinfo($ch);
        if ($info['http_code'] !== 200) {
            //return json_decode($response);
            die('Failed to delete target: ' . $response . "\n");
        }
        return json_decode($response);
    }

    /**
     * Delete all targets from database accessed by the given keys.
     * @return [String] Vuforia result_code
     */
    public function deleteAllTargets() {


        $ch = curl_init(self::BASE_URL . self::TARGETS_PATH);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->getHeaders('GET'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $info = curl_getinfo($ch);
        // dd(curl_error($ch));
        if ($info['http_code'] !== 200) {
            die('Failed to list targets: ' . $response . "\n");
        }
        $targets = json_decode($response);
        foreach ($targets->results as $index => $id) {
            $path = self::TARGETS_PATH . "/" . $id;
            $ch = curl_init(self::BASE_URL . $path);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->getHeaders('DELETE', $path));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            $info = curl_getinfo($ch);
            if ($info['http_code'] !== 200) {
                die('Failed to delete target: ' . $response . "\n");
            }
            print "Deleted target $index of " . count($targets->results);
            return json_decode($response);
        }
    }

    /**
     * Get all targets from database accessed by the given keys.
     * @return [JSON String] Vuforia targets
     */
    public function getAllTargets() {
        $ch = curl_init(self::BASE_URL . self::TARGETS_PATH);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->getHeaders('GET'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $info = curl_getinfo($ch);
        if ($info['http_code'] !== 200) {
            die('Failed to list targets: ' . $response . "\n");
        }
        return $targets = json_decode($response);
    }

    /**
     * Create a request header.
     * @return [Array] Header for request.
     */
    private function getHeaders($method, $path = self::TARGETS_PATH, $content_type = '', $body = '') {
        $headers = array();
        $date = new DateTime("now", new DateTimeZone("GMT"));
        $dateString = $date->format("D, d M Y H:i:s") . " GMT";
        $md5 = md5($body, false);
        $string_to_sign = $method . "\n" . $md5 . "\n" . $content_type . "\n" . $dateString . "\n" . $path;
        $signature = $this->hexToBase64(hash_hmac("sha1", $string_to_sign, self::SECRET_KEY));
        $headers[] = 'Authorization: VWS ' . self::ACCESS_KEY . ':' . $signature;
        $headers[] = 'Content-Type: ' . $content_type;
        $headers[] = 'Date: ' . $dateString;
        return $headers;
    }

    private function hexToBase64($hex) {
        $return = "";
        foreach (str_split($hex, 2) as $pair) {
            $return .= chr(hexdec($pair));
        }
        return base64_encode($return);
    }

    /**
     * Create a metadata for request. You can write any information into the metadata array you want to store.
     * @return [Array] Metadata for request.
     */
    private function createMetadata($trackerDimensions, $project_id, $objects) {
        $metadata = array(
            'id' => 1,
            'image_url' => $this->imagePath . $this->imageName,
            'width' => $trackerDimensions['width'],
            'height' => $trackerDimensions['height'],
            'project_id' => $project_id,
            'objects' => $objects
        );
        return base64_encode(json_encode($metadata));
    }

}
