<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'admin/trackerUpload','renewPlan' , 'admin/addUpdateObject','admin/finalizeTracker','admin/googleUpload','admin/flipUpload','admin/screenShotUpload','admin/youtubeUpload','admin/contactUpload','admin/facebookUpload','admin/webLinkUpload','admin/eventUpload','admin/audioUpload','admin/videoUpload','admin/emailUpload','admin/deleteObject','admin/imageUpload', 'admin/updateHieghtNewObject'
    ];
}
