<?php
namespace App\Http\Controllers\front\contactus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\front\contactus\Contactus;
use App\Models\front\systememail\Systememail;
use App\Helper\GeneralHelper;

class ContactusController extends Controller
{
    public function index() {
        return view('front.contactus.contactus');
    }

    public function contactus_submit(Request $request) {
        $data['vUniqueCode']        = md5(uniqid(time()));
        $data['vName']              = $request->vName;
        $data['vEmail']             = $request->vEmail;
        $data['tComments']          = $request->tComments;
        $data['dtAddedDate']        = date("Y-m-d h:i:s");
        Contactus::add($data);

        /* EMAIL To User Register */
        $auth_code = md5($request->vEmail);
        $criteria = array();
        $criteria['vEmailCode'] = 'USER_CONTACT_ADMIN';
        $email = Systememail::get_email_by_code($criteria);
        $company_setting = GeneralHelper::setting_info('company');
        $subject = str_replace("#SYSTEM.COMPANY_NAME#", $company_setting['COMPANY_NAME']['vValue'], $email->vEmailSubject);
        $constant   = array('#vFullName#','#vEmail#','#tMessage#','#SITE_NAME#');
        $value      = array($request->vName, $request->vEmail,$request->tComments,$company_setting['COMPANY_NAME']['vValue']);
        $message = str_replace($constant, $value, $email->tEmailMessage);

        $email_data['to']       = $company_setting['COMPANY_EMAIL']['vValue'];
        $email_data['vSandgridTemplateId']       = $email->vSandgridTemplateId;
        $email_data['subject']  = $subject;
        $email_data['msg']      = $message;
        $email_data['dynamic_template_data']      = ['vFullName' => $request->vName, 'vEmail' => $request->vEmail, 'tMessage' => $request->tComments];
        $email_data['vFromName']     = $email->vFromName;
        $email_data['from']     = $email->vFromEmail;
        $email_data['company_name']     = $company_setting['COMPANY_NAME']['vValue'];
        /*GeneralHelper::send('USER_CONTACT_ADMIN', $email_data);*/
        GeneralHelper::send_email_notifiction('USER_CONTACT_ADMIN', $email_data);
        /* EMAIL To User Register*/

        return redirect()->route('front.home')->withSuccess('Your request message sent successfully.');
    }
}
