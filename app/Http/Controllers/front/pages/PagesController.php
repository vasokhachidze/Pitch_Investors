<?php

namespace App\Http\Controllers\front\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\front\pageSetting\PageSetting;

class PagesController extends Controller
{
    public function terms_condition()
    {
        $criteria = array();
        $criteria['eType']          = "Terms and Condition";
        $criteria['eShowInHome']    = "No";
        $data['pageSetting']        = PageSetting::get_all_data($criteria);
        
        return view('front.pages.terms_condition')->with($data);
    }
    
    public function privacy_policy()
    {
        $criteria = array();
        $criteria['eType']          = "Privacy Policy";
        $criteria['eShowInHome']    = "No";
        $data['pageSetting']        = PageSetting::get_all_data($criteria);
        
        return view('front.pages.privacy_policy')->with($data);
    }

    public function about_us()
    {
        $criteria = array();
        $criteria['eType']          = "About";
        $criteria['eShowInHome']    = "No";
        $data['pageSetting']        = PageSetting::get_all_data($criteria);
        
        return view('front.pages.about_us')->with($data);
    }
}
