<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use App\Project;
use App\object;
class ArController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    const JSON_CONTENT_TYPE = 'application/json';
    const ACCESS_KEY = '463dce4372cd216e1b6582e1bb75b16984bcfdc8';
    const SECRET_KEY = '9bc79a20a13624b2e885c8ea0aad227f7e6ba41c';
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

        $projectID = $request->input('id');
        $projectDetails = Project::where('id', $projectID)->first();
        $objectLastId = object::where('project_id',$projectID)->orderBy('id','desc')->first();
        $objects = object::where('project_id',$projectID)->get();
        if(count($objectLastId)>0):
            $cloneId = $objectLastId->id;
            else:
            $cloneId = 0; 
        endif;
        if (count($projectDetails) > 0):
            return view('ar.dashboard', ['project_id' => $projectID, 'tracker' => $projectDetails->tracker_path,'cloneId'=>$cloneId, 'objects' =>$objects] );
        else:
            return 'Project Not Found';
        endif;
    }

    public function trackerUpload(Request $request) {

        $this->validate($request, [
            'trackerImage' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePath = $this->uploadFile($request, 'trackerImage', '/images/trackers');
        $project_id = $request->input('project_id');

        $update = Project::where('id', $project_id)->update([
            'tracker_path' => $imagePath
        ]);
        return json_encode([
            'success' => '1',
            'path' => url($imagePath)
                ]);
    }

    public function uploadDataVuforia() {
        $imagePath = '';
        $imageName = 'PB892124.JPG';
        $this->imagePath = '/';
        $this->imageName = 'PB892124.JPG';
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
            'width' => 32.0,
            'image' => $image_base64,
            'application_metadata' => $this->createMetadata(),
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
            print 'Successfully added target: ' . $vuforiaTargetID . "\n";
            return $vuforiaTargetID;
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
    private function createMetadata() {
        $metadata = array(
            'id' => 1,
            'image_url' => $this->imagePath . $this->imageName
        );
        return base64_encode(json_encode($metadata));
    }

}
