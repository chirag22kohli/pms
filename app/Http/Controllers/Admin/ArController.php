<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class ArController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        return view('ar.dashboard');
    }
}
