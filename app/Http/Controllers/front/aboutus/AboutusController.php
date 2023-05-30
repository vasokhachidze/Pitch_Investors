<?php
namespace App\Http\Controllers\front\aboutus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AboutusController extends Controller
{
    public function index() {
        return view('front.pageSetting.about');
    }
}
