<?php
namespace App\Http\Controllers\admin\country;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\country\Country;
use App\Libraries\Paginator;

class CountryController extends Controller
{
    public function index()
    {
     return view('admin.country.listing');
    }

    public function ajax_listing(Request $request)
    {
        $action = $request->action;
        $eStatus = $vCountry  = $vCountryCode = $vCountryISDCode = $status_search = "";
        $column          = "iCountryId";
        $order           = "DESC";
        $status_search   = $request->status_search;
        $vCountry        = $request->vCountry;
        $vCountryCode    = $request->vCountryCode;
        $vCountryISDCode = $request->vCountryISDCode;
        $eStatus         = $request->eStatus;
        $eIsDeleted      = $request->eIsDeleted;
        if(empty($eIsDeleted))
        {
            $eIsDeleted   = 'No';
        }
        if($action == "recover")
        {
            $vUniqueCode = $request->vUniqueCode;
            $data['eIsDeleted'] = 'No';
            $where = array("vUniqueCode" => $vUniqueCode);
            Country::update_data($where,$data);
        }
        if($action == "delete")
        {
            $where                 = array();
            $where['vUniqueCode']    = $request->vUniqueCode;
            $data['eIsDeleted'] = 'Yes';
            Country::update_data($where,$data);
        }
        if($action == "status")
        {
            $vUniqueCode = (explode(",",$request->vUniqueCode));
            $eStatus = $request->eStatus;
            if($eStatus == "delete")
            {
                foreach ($vUniqueCode as $key => $value)
                {
                    $where                 = array();
                    $where['vUniqueCode']    = $value;
                    $data['eIsDeleted'] = 'Yes';
                    Country::update_data($where,$data);
                }
                $eStatus = "";
            }
            else
            {
                foreach ($vUniqueCode as $key => $value) 
                {
                    $data['eStatus'] = $eStatus;
                    $where = array("vUniqueCode" => $value);
                    Country::update_data($where,$data);
                }
                $eStatus = "";
            }
        }
        $criteria = array();
        $criteria['status_search']     = $status_search;
        $criteria['vCountry']          = $vCountry;
        $criteria['vCountryCode']      = $vCountryCode;
        $criteria['vCountryISDCode']   = $vCountryISDCode;
        $criteria['eStatus']           = $eStatus;
        $criteria['eIsDeleted']        = $eIsDeleted;
        $criteria['column']            = $column;
        $criteria['order']             = $order;
        $banner_data = Country::get_all_data($criteria);
        $pages = 1;
        if($request->pages != "")
        {
            $pages = $request->pages;
        }
        $paginator = new Paginator($pages);
        $paginator->total = count($banner_data);
        $start = ($paginator->currentPage - 1) * $paginator->itemsPerPage;
        $limit = $paginator->itemsPerPage;
        if($request->limit_page !='')
        {
            
            $per_page = $request->limit_page;
            $paginator->itemsPerPage = $per_page;
            $paginator->range = $per_page;
            $limit =  $per_page;
        }
        $paginator->is_ajax = true;
        $paging = true;
        $data['data'] = Country::get_all_data($criteria, $start, $limit, $paging);
        $data['paging'] = $paginator->paginate();
        return view('admin.country.ajax_listing')->with($data);
    }

    public function add()
    {
       return view('admin.country.add');
    }
    public function edit($vUniqueCode)
    {
        $criteria                   = array();
        $criteria["vUniqueCode"]    = $vUniqueCode;
        $data['country']            = Country::get_by_id($criteria);
        if(!empty($data['country']))
        {
            return view('admin.country.add')->with($data);
        }
        else
        {
            return redirect()->route('admin.country.listing');
        }
    }
    public function store(Request $request)
    {
        $vUniqueCode                = $request->vUniqueCode;
        $data['vCountry']           = $request->vCountry;
        $data['vCountryCode']       = $request->vCountryCode;
        $data['vCountryISDCode']    = $request->vCountryISDCode;
        $data['eStatus']            = $request->eStatus;
        if(!empty($vUniqueCode))
        {
            $data['dtUpdatedDate']      = date("Y-m-d h:i:s");
            $where                      = array();
            $where['vUniqueCode']       = $vUniqueCode;
            Country::update_data($where, $data);
            return redirect()->route('admin.country.listing')->withSuccess('Country updated successfully.');
        }
        else
        {
            $data['dtAddedDate']        = date("Y-m-d h:i:s");
            $data['vUniqueCode']        = md5(uniqid(time()));
            Country::add($data);
            return redirect()->route('admin.country.listing')->withSuccess('Country created successfully.');
        }
        
    }
}
