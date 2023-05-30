<?php

namespace App\Http\Controllers\front\home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home() {
        return view('front.home.home');
    }
}
