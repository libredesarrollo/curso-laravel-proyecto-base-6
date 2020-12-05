<?php

namespace App\Http\Controllers\web;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;

class WebController extends Controller
{
    public function index()
    {

        echo Helper::hello("Andres");

        return view('web.index');
    }

    public function detail()
    {
        return view('web.index');
    }

    public function post_category()
    {
        return view('web.index');
    }

    public function contact()
    {
        return view('web.index');
    }
}
