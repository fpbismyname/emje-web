<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

class HomepageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('client.homepage.index');
    }
}
