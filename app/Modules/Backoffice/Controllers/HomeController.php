<?php

namespace Backoffice\Controllers;

use Illuminate\Http\Request;
use Backoffice\Controllers\Controller as Controller;
use Illuminate\Support\Facades\Redis;

class HomeController extends Controller
{
    protected $layout = 'backoffice::layouts.app';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backoffice::index');
    }
}
