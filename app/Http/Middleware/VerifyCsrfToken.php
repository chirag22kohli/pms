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
        'admin/trackerUpload' , 'admin/addUpdateObject','admin/finalizeTracker','admin/googleUpload','admin/facebookUpload','admin/audioUpload','admin/videoUpload','admin/emailUpload','admin/deleteObject'
    ];
}
