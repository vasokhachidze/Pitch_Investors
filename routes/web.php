<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\admin\languagelabel\LanguageLabelController;
use App\Http\Controllers\admin\homepage\HomepageController;
use App\Http\Controllers\admin\system_email\SystemEmailController;
use App\Http\Controllers\admin\cmspage\CmspageController;
use App\Http\Controllers\admin\pageSetting\PageSettingsController;

/* New Admin */
use App\Http\Controllers\admin\login\LoginController;
use App\Http\Controllers\admin\admin\AdminController;
use App\Http\Controllers\admin\industry\IndustryController;
use App\Http\Controllers\admin\setting\SettingController;
use App\Http\Controllers\admin\country\CountryController;
use App\Http\Controllers\admin\region\RegionController;
use App\Http\Controllers\admin\county\CountyControllr;
use App\Http\Controllers\admin\subcounty\SubCountyController;
use App\Http\Controllers\admin\user\UserController;
use App\Http\Controllers\admin\banner\BannerController;
use App\Http\Controllers\admin\plan\PlanController as AdminPlanController;
use App\Http\Controllers\admin\contract\ContractController as AdminContractController;
use App\Http\Controllers\admin\connection\ConnectionController as AdminConnectionController;
use App\Http\Controllers\admin\premium_service\PremiumServiceController as AdminPremiumServiceController;
use App\Http\Controllers\admin\contactus\ContactusController;
use App\Http\Controllers\admin\dashboard\DashboardController;
use App\Http\Controllers\admin\notificationmaster\NotificationmasterController;
use App\Http\Controllers\admin\investor\InvestorController as AdminInvestorController;
use App\Http\Controllers\admin\business_advisor\BusinessAdvisorController;
use App\Http\Controllers\admin\investment\InvestmentController as AdminInvestmentController;
use App\Http\Controllers\admin\testimonial\TestimonialController as AdminTestimonialController;

/* New Front */
use App\Http\Controllers\front\home\HomeController;
use App\Http\Controllers\front\login\LoginController as FrontLoginController;
use App\Http\Controllers\front\register\RegisterController;
use App\Http\Controllers\front\contactus\ContactusController as FrontContactusController;
use App\Http\Controllers\front\aboutus\AboutusController;
use App\Http\Controllers\front\investment\InvestmentController;
use App\Http\Controllers\front\advisor\AdvisorController;
use App\Http\Controllers\front\investor\InvestorController;
use App\Http\Controllers\front\selectprofile\SelectprofileController;
use App\Http\Controllers\front\dashboard\DashboardController as FrontDashboardController;
use App\Http\Controllers\front\chat\ChatController;
use App\Http\Controllers\front\token\TokenController;
use App\Http\Controllers\front\contract\ContractController;
use App\Http\Controllers\front\dashboard\InvestmentDashboardController;
use App\Http\Controllers\front\dashboard\InvestorDashboardController;
use App\Http\Controllers\front\dashboard\AdvisorDashboardController;
use App\Http\Controllers\front\plan\PlanController;
use App\Http\Controllers\front\pages\PagesController;
use App\Http\Controllers\tests\TestController; //path
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\payments\pesapal\PesapalController;


/************************** Artisans ********************************/
Route::get('/storage-link', function() {
    Artisan::call('storage:link');
    return redirect('/');
});

Route::get('/thank-you', function() {
    return view("front/thankyou");
});
Route::get('/optimize', function() {
    Artisan::call('optimize');
    return redirect('/');
});

Route::get('pesapal-response',[PesapalController::class, 'pesapalResponse']);

Route::get('thank-you/{premium_service}',[InvestmentDashboardController::class, 'add_business_thankyou']);

/************************** Tests ********************************/
Route::get('/test-test', function() {
    ///if we vist this route, we expect this Message"Test Today!!"
    //we got an erroe because the route is not registered in cache,
    //so we delete the cache routes file, such that when the app will pick routes from original file when it finds no cache file. 
    //lets delete...
    //nice, now we are ok!
    
    echo "Test Today!!";
})->name('test.today');

//lets create a route that call's a controller and the controller can direct us
Route::get('/test-page-render', [TestController::class, 'testPage'])->name('front.test-page');
Route::get('/howtocreateprofiles', function () {return view('howtocreateprofiles');});

//lets create a controller TestContoller since it's not there...it calls function->testPage
//also, do not forget to import this controller in this routes file

///Good, now we can do some logic from our controller side
/************************** Front Routes ********************************/
/* Default set Home page */
Route::get('/', [HomeController::class, 'home'])->name('front.home');
/* Home page */
Route::get('home',[HomeController::class, 'home'])->name('home');
Route::get('nationality',[HomeController::class, 'nationality'])->name('nationality');



/*header search profile*/
Route::post('searchProfile',[HomeController::class, 'searchProfile'])->name('front.search_profile');

Route::post('subscribe',[HomeController::class, 'subscribe']);
Route::post('hide-subscribe',[HomeController::class, 'hide_subscribe']);
/*footer search profile*/
/*Route::post('footerSearchProfile',[HomeController::class, 'footerSearchProfile'])->name('front.footerSearchProfile');*/

/* Front Logout */
Route::get('logout', [FrontLoginController::class, 'logout'])->name('front.login.logout');

/* Front Login */
Route::get('login',[FrontLoginController::class, 'index'])->name('front.login.index');
Route::post('login_action',[FrontLoginController::class, 'login_action'])->name('front.login.login_action');
/* Front Register */
Route::get('register',[RegisterController::class, 'index'])->name('front.register.index');
Route::get('sign_up_thank_you',[RegisterController::class, 'sign_up_thank_you'])->name('front.register.sign_up_thank_you');
Route::post('register_action',[RegisterController::class, 'register_action'])->name('front.register.register_action');
Route::get('active-profile/{code}', [RegisterController::class, 'active_profile'])->name('front.register.active_profile');

/* pesapal */
Route::get('pesapal/{amount}/{premium_service}/{investment_id}',[PesapalController::class, 'pesapalRequest']);

/* Front Forgot Password */
Route::get('forgotpassword',[FrontLoginController::class, 'forgot_password'])->name('forgotpassword');
Route::post('forgotpassword_action',[FrontLoginController::class, 'forgotpassword_action'])->name('front.forgotpassword.forgotpassword_action');

/* Front Reset Password */
Route::get('reset-password/{code}',[FrontLoginController::class, 'reset_password'])->name('reset-assword');
Route::post('reset-password',[FrontLoginController::class, 'resetPassword_action'])->name('front.forgotpassword.reset-password');

/* About us page */
// Route::get('about_us',[AboutusController::class, 'index'])->name('front.aboutus.index');

//Terms & Condition, Privacy Policy, About Us
Route::get('terms-condition',[PagesController::class, 'terms_condition'])->name('front.pages.terms_condition');
Route::get('privacy-policy',[PagesController::class, 'privacy_policy'])->name('front.pages.privacy_policy');
Route::get('about-us',[PagesController::class, 'about_us'])->name('front.pages.about_us');
Route::get('create-investor',[PagesController::class, 'create_investor'])->name('front.pages.create_investor');

/* Investments Listing */
Route::get('investment',[InvestmentController::class, 'listing'])->name('front.investment.listing');
Route::post('front/investment/ajax_listing',[InvestmentController::class, 'ajax_listing'])->name('front.investment.ajaxListing');
Route::get('investment-detail/{code}',[InvestmentController::class, 'investment_detail'])->name('front.investment.detail');
Route::get('{any}/t2b/',[InvestmentController::class, 'investment_search'])->name('front.investment.search');
Route::post('front/investment/ajax_search_listing',[InvestmentController::class, 'ajax_search_listing'])->name('front.investment.ajaxSearchListing');


/* Advisor Listing */
Route::get('advisor',[AdvisorController::class, 'listing'])->name('front.advisor.listing');
Route::post('front/advisor/ajax_listing',[AdvisorController::class, 'ajax_listing'])->name('front.advisor.ajax_listing');
Route::get('advisor-detail/{code}',[AdvisorController::class, 'detail'])->name('front.advisor.detail');
Route::get('{any}/m17i/',[AdvisorController::class, 'advisor_search'])->name('front.advisor.search');
Route::post('front/advisor/ajax_search_listing',[AdvisorController::class, 'ajax_search_listing'])->name('front.advisor.ajaxSearchListing');

/* Investor Listing */
Route::get('investor',[InvestorController::class, 'listing'])->name('front.investor.listing');
Route::get('investor-detail/{code}',[InvestorController::class, 'detail'])->name('front.investor.detail');
Route::post('front/investor/ajax_listing',[InvestorController::class, 'ajax_listing'])->name('front.investor.ajax_listing');
Route::get('{any}/m1i/',[InvestorController::class, 'investor_search'])->name('front.investor.search');
Route::post('front/investor/ajax_search_listing',[InvestorController::class, 'ajax_search_listing'])->name('front.investor.ajaxSearchListing');

Route::get('/join-pitch-inverstor', function() {
    return view("front/landing/join_pitch_inverstor");
});

Route::get('/invest-in-your-future', function() {
    return view("front/landing/future-invest");
});

Route::group(['middleware' => ['userlogin']], function() {
    /* Dashboard */
    Route::get('dashboard',[FrontDashboardController::class, 'dashboard'])->name('front.dashboard.dashboard');
    
    /* Investment Dashboard */
    Route::get('investmentDashboard',[InvestmentDashboardController::class, 'investmentDashboard'])->name('front.dashboard.investmentDashboard');
    Route::post('investmentDashboard-ajax',[InvestmentDashboardController::class, 'ajax_data'])->name('front.dashboard.investmentDashboard-ajax');
    Route::post('investmentDashboard-received-ajax',[InvestmentDashboardController::class, 'ajax_received_data'])->name('front.dashboard.investmentDashboard-received-ajax');
    Route::post('investment-change_status',[InvestmentDashboardController::class, 'change_status'])->name('front.investment.changeStatus');
    Route::get('investment-request',[InvestmentDashboardController::class, 'investmentDashboardTabview'])->name('front.dashboard.investmentDashboardTabview');

    /* Investor Dashboard */
    Route::get('investorDashboard',[InvestorDashboardController::class, 'investorDashboard'])->name('front.dashboard.investorDashboard');
    Route::post('accept_reject_connection_investor',[InvestorDashboardController::class, 'accept_reject_connection'])->name('front.dashboard.accept_reject_connection_investor');
    Route::get('investor-request',[InvestorDashboardController::class, 'investorDashboardTabview'])->name('front.dashboard.investorDashboardTabview');

    /* Advisor Dashboard */
    Route::get('advisorDashboard',[AdvisorDashboardController::class, 'advisorDashboard'])->name('front.dashboard.advisorDashboard');
    Route::post('accept_reject_connection',[AdvisorDashboardController::class, 'accept_reject_connection'])->name('front.dashboard.accept_reject_connection');
    Route::get('advisor-request',[AdvisorDashboardController::class, 'advisorDashboardTabview'])->name('front.dashboard.advisorDashboardTabview');

    /* Chat */
    Route::post('chatConnectionList',[ChatController::class, 'connectionList'])->name('front.chat.chatConnectionList');
    Route::post('chatHistory',[ChatController::class, 'chatHistory'])->name('front.chat.chatHistory');
    Route::post('chatSend',[ChatController::class, 'chatSend'])->name('front.chat.chatSend');
    Route::post('UpdateStatus',[ChatController::class, 'UpdateStatus'])->name('front.chat.UpdateStatus');

    /* premium Account */
    Route::get('premium-detail',[FrontDashboardController::class, 'premiumAccountDetail'])->name('front.dashboard.FrontDashboardController');

    /* Diduct  token from user db, based on established connection or not */

    /* Reset Password */
    Route::get('changePassword',[FrontDashboardController::class, 'change_password'])->name('front.dashboard.changePassword');
    Route::post('change_password_store',[FrontDashboardController::class, 'change_password_store'])->name('front.dashboard.changePasswordStore');

    /* Edit User */
    Route::get('editUser',[FrontDashboardController::class, 'edit_user'])->name('front.dashboard.editUser');
    Route::post('editUser_store',[FrontDashboardController::class, 'edit_user_store'])->name('front.dashboard.editUserStore');

    /* Investments page */    
    Route::get('business-instruction',[InvestmentController::class, 'business_details'])->name('front.investment.business_details');
    Route::get('investment-add',[InvestmentController::class, 'add'])->name('front.investment.add');
    Route::get('investment-add-new',[InvestmentController::class, 'addnew'])->name('front.investment.addnew');
    Route::post('investment-store',[InvestmentController::class, 'store'])->name('front.investment.store');
    Route::post('investment-token-store',[InvestmentController::class, 'token_store'])->name('front.investment-token.store');
    Route::post('investment-review',[InvestmentController::class, 'review_store'])->name('front.investment.review');
    Route::post('investment-upload',[InvestmentController::class, 'upload'])->name('front.investment.upload');
    Route::post('investment-delete-document',[InvestmentController::class, 'delete_documents'])->name('front.investment.deleteDocument');


    Route::get('investment-edit/{code}',[InvestmentController::class, 'edit'])->name('front.investment.edit');
    

    /* Advisor page */
    Route::get('advisor-add',[AdvisorController::class, 'add'])->name('front.advisor.add');
    Route::post('advisor-store',[AdvisorController::class, 'store'])->name('front.advisor.store');
    Route::post('advisor-upload',[AdvisorController::class, 'upload'])->name('front.advisor.upload');
    Route::post('advisor-delete-document',[AdvisorController::class, 'delete_documents'])->name('front.advisor.deleteDocument');
    Route::post('advisor-token-store',[AdvisorController::class, 'token_store'])->name('front.advisor-token.store'); /* Diduct token from user db, based on established connection or not */    
    Route::get('advisor-edit/{code}',[AdvisorController::class, 'edit'])->name('front.advisor.edit');
    Route::post('advisor-review',[AdvisorController::class, 'review_store'])->name('front.advisor.review');

    /* Investor page */
    Route::get('investor-add',[InvestorController::class, 'add'])->name('front.investor.add');
    Route::post('investor-store',[InvestorController::class, 'store'])->name('front.investor.store');
    Route::post('investor-upload',[InvestorController::class, 'upload'])->name('front.investor.upload');
    Route::post('investor-delete-document',[InvestorController::class, 'delete_documents'])->name('front.investor.deleteDocument');
    Route::post('investor-token-store',[InvestorController::class, 'token_store'])->name('front.investor-token.store');    
    Route::post('investor-review',[InvestorController::class, 'review_store'])->name('front.investor.review');
    Route::get('investor-edit/{code}',[InvestorController::class, 'edit'])->name('front.investor.edit'); 

    /* Select Profile page */
    Route::get('select-profile',[SelectprofileController::class, 'index'])->name('front.selectprofile.index');

    /* Select Wallet Listing */
    Route::get('token-listing',[TokenController::class, 'listing'])->name('front.token.listing');

    /* Select Contract Listing */
    Route::get('contract-listing',[ContractController::class, 'listing'])->name('front.contract.listing');
    Route::post('advisor-create-contract',[ContractController::class, 'advisorCreateContract'])->name('front.advisor-create.contract'); 
    Route::post('contract-payment',[ContractController::class, 'contract_payment'])->name('front.contract.payment');
    Route::post('withdraw-amount',[ContractController::class, 'withdraw_amount'])->name('front.contract.withdraw');

    
    /* Plan */
    Route::get('plan-listing',[PlanController::class, 'index'])->name('front.plan.listing');
    Route::post('ajax_listing',[PlanController::class, 'ajax_listing'])->name('front.plan.ajax_listing');
    Route::get('plan-detail/{code}',[PlanController::class, 'plan_detail'])->name('front.plan.detail');
    Route::post('plan-purchase',[PlanController::class, 'plan_purchase'])->name('front.plan.purchase');

});
Route::any('plan-callback/{planid}/{userid}',[PlanController::class, 'plan_callback'])->name('front.plan.callback');
Route::post('verify-payment',[PlanController::class, 'verify_payment'])->name('front.plan.verify_payment');
Route::post('contract-callback/{iContractId}',[ContractController::class, 'contract_callback'])->name('front.contract.callback');
Route::post('verify-contract-payment',[ContractController::class, 'verify_contract_payment'])->name('front.contract.verify_contract_payment');
Route::post('withdraw-callback/{loginUserId}/{amount}/{vUniqueCode}',[ContractController::class, 'withdraw_callback'])->name('front.plan.withdraw_callback');
Route::post('verify-withdraw',[ContractController::class, 'verify_withdrawal'])->name('front.contract.verify_withdrawal');
Route::post('second-pmnt-callback',[ContractController::class, 'contract_payment_alternative_callback'])->name('front.contract.alternative_callback');
Route::post('second-pmnt-validateUrl',[ContractController::class, 'contract_payment_validate_alternative'])->name('front.contract.validateUrl');


//get county subcounty and region
Route::post('investment/get_region_by_country/',[InvestmentController::class, 'get_region_by_country'])->name('front.investment.get_region_by_country');
Route::post('investment/get_county_by_region/',[InvestmentController::class, 'get_county_by_region'])->name('front.investment.get_county_by_region');
Route::post('investment/get_sub_county_by_county/',[InvestmentController::class, 'get_sub_county_by_county'])->name('front.investment.get_sub_county_by_county');

/* Contact Us page */
Route::get('contact_us',[FrontContactusController::class, 'index'])->name('front.contactus.contact_us');
Route::post('contactus_submit',[FrontContactusController::class, 'contactus_submit'])->name('front.contactus.contactus_submit');

/************************** End of Front Routes *************************/

/************************** admin Routes ********************************/

Route::get('admin/login',[LoginController::class, 'index'])->name('admin.login');
Route::post('admin/login/login_action',[LoginController::class, 'login_action'])->name('admin.login.login_action');
Route::get('admin/logout', [LoginController::class, 'logout'])->name('admin.logout');

Route::group(['middleware' => ['auth']], function() {
//admin dashboard
Route::get('admin/dashboard',[DashboardController::class, 'index'])->name('admin.dashboard');

//admin
Route::get('admin/admin',[AdminController::class, 'index'])->name('admin.listing');
Route::post('admin/admin/ajax_listing', [AdminController::class, 'ajax_listing'])->name('admin.admin.ajaxListing');
Route::get('admin/admin/add',[AdminController::class, 'add'])->name('admin.admin.add');
Route::post('admin/admin/store',[AdminController::class, 'store'])->name('admin.admin.store');
Route::get('admin/admin/edit/{iAdminId}',[AdminController::class, 'edit'])->name('admin.admin.edit');
Route::post('admin/admin/check_unique_email', [AdminController::class, 'check_unique_email'])->name('admin.admin.check_unique_email');
Route::get('admin/admin/change_password/{iAdminId}',[AdminController::class, 'change_password'])->name('admin.admin.change_password');
Route::post('admin/admin/change_password_action',[AdminController::class, 'change_password_action'])->name('admin.admin.change_password_action');
Route::post('admin/admin/remove_attachment',[AdminController::class, 'remove_attachment'])->name('admin.admin.remove_attachment');

//banner
Route::get('admin/banner/listing',[BannerController::class, 'index'])->name('banner.listing');
Route::post('admin/banner/ajax_listing', [BannerController::class, 'ajax_listing'])->name('admin.banner.ajax_listing');
Route::get('admin/banner/add',[BannerController::class, 'add'])->name('admin.banner.add');
Route::post('admin/banner/store',[BannerController::class, 'store'])->name('admin.banner.store');
Route::get('admin/banner/edit/{iUserId}',[BannerController::class, 'edit'])->name('admin.banner.edit');

//plan
Route::get('admin/plan/listing',[AdminPlanController::class, 'index'])->name('plan.listing');
Route::post('admin/plan/ajax_listing', [AdminPlanController::class, 'ajax_listing'])->name('admin.plan.ajax_listing');
Route::get('admin/plan/add',[AdminPlanController::class, 'add'])->name('admin.plan.add');
Route::post('admin/plan/store',[AdminPlanController::class, 'store'])->name('admin.plan.store');
Route::get('admin/plan/edit/{iUserId}',[AdminPlanController::class, 'edit'])->name('admin.plan.edit');

//contract
Route::get('admin/contract/listing',[AdminContractController::class, 'index'])->name('contract.listing');
Route::post('admin/contract/ajax_listing', [AdminContractController::class, 'ajax_listing'])->name('admin.contract.ajax_listing');
Route::get('admin/contract/add',[AdminContractController::class, 'add'])->name('admin.contract.add');
Route::post('admin/contract/store',[AdminContractController::class, 'store'])->name('admin.contract.store');
Route::get('admin/contract/edit/{iUserId}',[AdminContractController::class, 'edit'])->name('admin.contract.edit');


//connection
Route::get('admin/connection/listing',[AdminConnectionController::class, 'index'])->name('connection.listing');
Route::post('admin/connection/ajax_listing', [AdminConnectionController::class, 'ajax_listing'])->name('admin.connection.ajax_listing');
Route::post('admin/connection/ajax_week_data', [AdminConnectionController::class, 'ajax_week_data'])->name('admin.connection.ajax_week_data');

//premium Service
Route::get('admin/premium_service/listing',[AdminPremiumServiceController::class, 'index'])->name('premiumservice.listing');
Route::post('admin/premium_service/ajax_listing', [AdminPremiumServiceController::class, 'ajax_listing'])->name('admin.premiumservice.ajax_listing');
Route::post('admin/premium_service/ajax_week_data', [AdminPremiumServiceController::class, 'ajax_week_data'])->name('admin.premiumservice.ajax_week_data');

//user
Route::get('admin/user/listing',[UserController::class, 'index'])->name('user.listing');
Route::post('admin/user/ajax_listing', [UserController::class, 'ajax_listing'])->name('admin.user.ajax_listing');
Route::get('admin/user/add',[UserController::class, 'add'])->name('admin.user.add');
Route::post('admin/user/store',[UserController::class, 'store'])->name('admin.user.store');
Route::get('admin/user/edit/{iUserId}',[UserController::class, 'edit'])->name('admin.user.edit');
Route::post('admin/user/check_unique_email', [UserController::class, 'check_unique_email'])->name('admin.user.check_unique_email');
Route::get('admin/user/change_password/{iUserId}',[UserController::class, 'change_password'])->name('admin.user.change_password');
Route::post('admin/user/change_password_action',[UserController::class, 'change_password_action'])->name('admin.user.change_password_action');

//country used
Route::get('admin/country/listing',[CountryController::class, 'index'])->name('admin.country.listing');
Route::get('admin/country/add',[CountryController::class, 'add'])->name('admin.country.add');
Route::post('admin/country/store',[CountryController::class, 'store'])->name('admin.country.store');
Route::post('admin/country/ajax_listing',[CountryController::class, 'ajax_listing'])->name('admin.country.ajaxListing');
Route::get('admin/country/edit/{vUniqueCode}',[CountryController::class, 'edit'])->name('admin.country.edit');

//languagelabel
Route::get('admin/languagelabel/listing',[LanguageLabelController::class, 'index'])->name('admin.languagelabel.listing');
Route::get('admin/languagelabel/add',[LanguageLabelController::class, 'add'])->name('admin.languagelabel.add');
Route::get('admin/languagelabel/generate',[LanguageLabelController::class, 'generate'])->name('admin.languagelabel.generate');
Route::post('admin/languagelabel/store',[LanguageLabelController::class, 'store'])->name('admin.languagelabel.store');
Route::post('admin/languagelabel/ajax_listing',[LanguageLabelController::class, 'ajax_listing'])->name('admin.languagelabel.ajaxListing');
Route::get('admin/languagelabel/edit/{vUniqueCode}',[LanguageLabelController::class, 'edit'])->name('admin.languagelabel.edit');


//Testimonial
Route::get('admin/testimonial/listing',[AdminTestimonialController::class, 'index'])->name('admin.testimonial');
Route::get('admin/testimonial/add',[AdminTestimonialController::class, 'add'])->name('admin.testimonial.add');
Route::post('admin/testimonial/store',[AdminTestimonialController::class, 'store'])->name('admin.testimonial.store');
Route::post('admin/testimonial/ajax_listing',[AdminTestimonialController::class, 'ajax_listing'])->name('admin.testimonial.ajaxListing');
Route::get('admin/testimonial/edit/{vUniqueCode}',[AdminTestimonialController::class, 'edit'])->name('admin.testimonial.edit');

// Home page
Route::post('admin/homepage/store',[HomepageController::class, 'store'])->name('admin.homepage.store');
Route::get('admin/homepage/{vType}',[HomepageController::class, 'edit'])->name('admin.homepage.edit');

//system_email
Route::get('admin/system_email/listing',[SystemEmailController::class, 'index'])->name('admin.systemEmail.listing');
Route::get('admin/system_email/add',[SystemEmailController::class, 'add'])->name('admin.systemEmail.add');
Route::post('admin/system_email/store',[SystemEmailController::class, 'store'])->name('admin.systemEmail.store');
Route::post('admin/system_email/ajax_listing',[SystemEmailController::class, 'ajax_listing'])->name('admin.systemEmail.ajaxListing');
Route::get('admin/system_email/edit/{iSystemEmailId}',[SystemEmailController::class, 'edit'])->name('admin.systemEmail.edit');

//Cms Pages
Route::get('admin/cmspage/listing',[CmspageController::class, 'index'])->name('admin.cmspage.listing');
Route::get('admin/cmspage/add',[CmspageController::class, 'add'])->name('admin.cmspage.add');
Route::post('admin/cmspage/store',[CmspageController::class, 'store'])->name('admin.cmspage.store');
Route::post('admin/cmspage/ajax_listing',[CmspageController::class, 'ajax_listing'])->name('admin.cmspage.ajaxListing');
Route::get('admin/cmspage/edit/{icmspageId}',[CmspageController::class, 'edit'])->name('admin.cmspage.edit');

//setting
Route::get('admin/setting/listing',[SettingController::class, 'index'])->name('admin.setting.listing');
Route::post('admin/setting/store',[SettingController::class, 'store'])->name('admin.setting.store');
Route::get('admin/setting/{eConfigType}',[SettingController::class, 'edit'])->name('admin.setting.edit');

// page setting
Route::get('admin/pageSetting/listing',[PageSettingsController::class, 'index'])->name('admin.pageSetting.listing');
Route::post('admin/pageSetting/ajax_listing',[PageSettingsController::class, 'ajax_listing'])->name('admin.pageSetting.ajaxListing');
Route::get('admin/pageSetting/add',[PageSettingsController::class, 'add'])->name('admin.pageSetting.add');
Route::post('admin/pageSetting/store',[PageSettingsController::class, 'store'])->name('admin.pageSetting.store');
Route::get('admin/pageSetting/edit/{vUniqueCode}',[PageSettingsController::class, 'edit'])->name('admin.pageSetting.edit');
Route::get('admin/pageSetting/view/{vUniqueCode}',[PageSettingsController::class, 'view'])->name('admin.pageSetting.view');



// contact us
Route::get('admin/contactus/listing',[ContactusController::class, 'index'])->name('admin.contactus.listing');
Route::post('admin/contactus/ajax_listing',[ContactusController::class, 'ajax_listing'])->name('admin.contactus.ajaxListing');

/* Start New Route */

/*  Industry */
Route::get('admin/industry/listing',[IndustryController::class,'index'])->name('admin.industry.listing');
Route::post('admin/industry/ajax_listing',[IndustryController::class, 'ajax_listing'])->name('admin.industry.ajaxListing');
Route::get('admin/industry/add',[IndustryController::class,'add'])->name('admin.industry.add');
Route::post('admin/industry/store',[IndustryController::class, 'store'])->name('admin.industry.store');
Route::get('admin/industry/edit/{vUniqueCode}',[IndustryController::class,'edit'])->name('admin.industry.edit');

/*  Region */
Route::get('admin/region/listing',[RegionController::class,'index'])->name('admin.region.listing');
Route::post('admin/region/ajax_listing',[RegionController::class, 'ajax_listing'])->name('admin.region.ajaxListing');
Route::get('admin/region/add',[RegionController::class,'add'])->name('admin.region.add');
Route::post('admin/region/store',[RegionController::class, 'store'])->name('admin.region.store');
Route::get('admin/region/edit/{vUniqueCode}',[RegionController::class,'edit'])->name('admin.region.edit');

/* County */
Route::get('admin/county/listing',[CountyControllr::class,'index'])->name('admin.county.listing');
Route::post('admin/county/ajax_listing',[CountyControllr::class, 'ajax_listing'])->name('admin.county.ajaxListing');
Route::get('admin/county/add',[CountyControllr::class,'add'])->name('admin.county.add');
Route::post('admin/county/store',[CountyControllr::class, 'store'])->name('admin.county.store');
Route::get('admin/county/edit/{vUniqueCode}',[CountyControllr::class,'edit'])->name('admin.county.edit');
Route::post('admin/county/get_region_by_country',[CountyControllr::class, 'get_region_by_country'])->name('admin.county.get_region_by_country');

/* Sub County */
Route::get('admin/subCounty/listing',[SubCountyController::class,'index'])->name('admin.subCounty.listing');
Route::post('admin/subCounty/ajax_listing',[SubCountyController::class, 'ajax_listing'])->name('admin.subCounty.ajaxListing');
Route::get('admin/subCounty/add',[SubCountyController::class,'add'])->name('admin.subCounty.add');
Route::post('admin/subCounty/store',[SubCountyController::class, 'store'])->name('admin.subCounty.store');
Route::get('admin/subCounty/edit/{vUniqueCode}',[SubCountyController::class,'edit'])->name('admin.subCounty.edit');
Route::post('admin/subCounty/get_region_by_country',[SubCountyController::class, 'get_region_by_country'])->name('admin.subCounty.get_region_by_country');
Route::post('admin/subCounty/get_county_by_region',[SubCountyController::class, 'get_county_by_region'])->name('admin.subCounty.get_county_by_region');

/* Notification Master page */
Route::get('admin/notificationmaster/listing',[NotificationmasterController::class,'index'])->name('admin.notificationmaster.listing');
Route::post('admin/notificationmaster/ajax_listing',[NotificationmasterController::class, 'ajax_listing'])->name('admin.notificationmaster.ajaxListing');
Route::get('admin/notificationmaster/add',[NotificationmasterController::class,'add'])->name('admin.notificationmaster.add');
Route::post('admin/notificationmaster/store',[NotificationmasterController::class, 'store'])->name('admin.notificationmaster.store');
Route::get('admin/notificationmaster/edit/{vUniqueCode}',[NotificationmasterController::class,'edit'])->name('admin.notificationmaster.edit');

/*  Investor */
Route::get('admin/investor/listing',[AdminInvestorController::class,'listing'])->name('admin.investor.listing');
Route::post('admin/investor/ajax_listing',[AdminInvestorController::class, 'ajax_listing'])->name('admin.investor.ajaxListing');
Route::get('admin/investor/add',[AdminInvestorController::class,'add'])->name('admin.investor.add');
Route::get('admin/investor/edit/{vUniqueCode}',[AdminInvestorController::class,'edit'])->name('admin.investor.edit');
Route::get('admin/investor/view/{vUniqueCode}',[AdminInvestorController::class,'view'])->name('admin.investor.view');
Route::post('admin/investor/store',[AdminInvestorController::class, 'store'])->name('admin.investor.store');
Route::post('admin/investor/upload',[AdminInvestorController::class, 'upload'])->name('admin.investor.upload');

/*  Business Advisor */
Route::get('admin/business-advisor/listing',[BusinessAdvisorController::class,'listing'])->name('admin.business-advisor.listing');
Route::post('admin/business-advisor/ajax_listing',[BusinessAdvisorController::class, 'ajax_listing'])->name('admin.business-advisor.ajaxListing');
Route::get('admin/business-advisor/add',[BusinessAdvisorController::class,'add'])->name('admin.business-advisor.add');
Route::get('admin/business-advisor/edit/{vUniqueCode}',[BusinessAdvisorController::class,'edit'])->name('admin.business-advisor.edit');
Route::get('admin/business-advisor/view/{vUniqueCode}',[BusinessAdvisorController::class,'view'])->name('admin.business-advisor.view');
Route::post('admin/business-advisor/store',[BusinessAdvisorController::class, 'store'])->name('admin.business-advisor.store');
Route::post('admin/business-advisor/upload',[BusinessAdvisorController::class, 'upload'])->name('admin.business-advisor.upload');

/*  Investment */
Route::get('admin/investment/listing',[AdminInvestmentController::class,'listing'])->name('admin.investment.listing');
Route::post('admin/investment/ajax_listing',[AdminInvestmentController::class, 'ajax_listing'])->name('admin.investment.ajaxListing');
Route::get('admin/investment/add',[AdminInvestmentController::class,'add'])->name('admin.investment.add');
Route::get('admin/investment/view/{vUniqueCode}',[AdminInvestmentController::class,'view'])->name('admin.investment.view');
Route::get('admin/investment/edit/{vUniqueCode}',[AdminInvestmentController::class,'edit'])->name('admin.investment.edit');
Route::post('admin/investment/store',[AdminInvestmentController::class, 'store'])->name('admin.investment.store');
Route::post('admin/investment/upload',[AdminInvestmentController::class, 'upload'])->name('admin.investment.upload');


/* End New Route */

});
/************************** End of admin Routes *************************/
