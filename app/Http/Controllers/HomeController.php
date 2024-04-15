<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $title = "home";

        return view('back.pages.home', compact('title'));
    }
}
