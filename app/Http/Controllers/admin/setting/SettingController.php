<?php
namespace App\Http\Controllers\admin\setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\setting\Setting;

class SettingController extends Controller
{
    public function index()
    {   
        return view('admin.setting.listing');
    }

    public function store(Request $request)
    {
        $eConfigType = $request->eConfigType;

        $criteria = array();
        $criteria['eStatus']     = 'Active';
        $criteria['eConfigType'] = $eConfigType;

        $settings = Setting::get_all_settings($criteria);
        
        // $settings = Setting::where(['eConfigType' => $request->eConfigType, 'eStatus'=>'Active'])->get()->toArray();

        foreach ($settings as $key => $value) {
            $settings = array();

            if($value->vName == 'COMPANY_FAVICON'){
                $image = 'favicon.png';
                $setting = Setting::get_by_id($value->iSettingId);
                
                if ($request->hasFile($value->vName)) {
                    $request->validate([
                        'COMPANY_FAVICON' => 'required|mimes:png,jpg,jpeg|max:2048'
                    ]);
                    $imageName      = $image;
                    $path           = public_path('uploads/logo');
                    $request[$value->vName]->move($path, $imageName);
                }
                $settings['vValue'] = $image;
                $where = array("vName" => $value->vName);
                Setting::setting_update($where, $settings);
            }
            else if($value->vName == 'COMPANY_LOGO'){
                $image = 'logo.png';
                $setting = Setting::get_by_id($value->iSettingId);

                if($request->hasFile($value->vName) == 'true'){
                    if ($request->hasFile($value->vName)) {
                        $request->validate([
                            'COMPANY_LOGO' => 'required|mimes:png,jpg,jpeg|max:2048'
                        ]);
                        $imageName      = $image;
                        $path           = public_path('uploads/logo');
                        $request[$value->vName]->move($path, $imageName);
                    }
                    $settings['vValue'] = $imageName;

                    $where = array("vName" => $value->vName);
                    Setting::setting_update($where, $settings);
                   
                }
            }
            else if($value->vName == 'COMPANY_FOOTER_LOGO'){
                $image = 'footer_logo.png';
                $setting = Setting::get_by_id($value->iSettingId);

                if($request->hasFile($value->vName) == 'true'){
                    if ($request->hasFile($value->vName)) {
                        $request->validate([
                            'COMPANY_FOOTER_LOGO' => 'required|mimes:png,jpg,jpeg|max:2048'
                        ]);
                        $imageName      = $image;
                        $path           = public_path('uploads/logo');
                        $request[$value->vName]->move($path, $imageName);
                    }
                    $settings['vValue'] = $imageName;

                    $where = array("vName" => $value->vName);
                    Setting::setting_update($where, $settings);
                }
            }
            else{
                $setting = Setting::get_by_id($value->iSettingId);
                $settings['vValue'] = $request[$value->vName];
               
                $where = array("vName" => $value->vName);
               
                Setting::setting_update($where, $settings);
            }
        }
        return redirect()->back()->withSuccess("Data updated successfully");
    }

    public function edit($eConfigType)
    {
        $data['eConfigType'] = $eConfigType;

        $criteria = array();
        $criteria['eStatus']     = 'Active';
        $criteria['eConfigType'] = $eConfigType;

        $data['settings'] = Setting::get_all_settings($criteria);

        // $data['settings'] = Setting::where(['eConfigType' => $eConfigType, 'eStatus'=>'Active'])->get()->toArray();

        return view('admin.setting.add')->with($data);
    }
}