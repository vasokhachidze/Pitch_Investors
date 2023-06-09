@php
$session_data = (session('user') !== null )?session('user'):'';
$userData = '';
if ($session_data !== '') {
    $userData = App\Helper\GeneralHelper::get_user_by_id($session_data['iUserId']);
}

$url = Request::segment(1);
$display_dashboard_left_page = 'style=display:none;';

$allow_dashboard_left_page = ['dashboard','investmentDashboard','advisorDashboard','investorDashboard','investor-add','investment-add','advisor-add','editUser','changePassword','investment-edit','investor-edit','advisor-edit'];
@endphp

<div class="col-lg-12 col-md-6 mt-4" style="background: #FFFFFF; border-bottom: 2px solid #2B7292; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);">
    <div class="chat-box-warp mt-3">
        <h3 class="chat-heading add-card-title" style="font-size:18px; color: #2B7292;">Inbox</h3>
        <div class="px-3">  
            <div class="border-bottom"></div>  
        </div>
        {{-- <div class="search-baar-chats">
            <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="search">
        </div> --}}
        <div class="chat-peopel">
            <ul id="connectionList_ul" class="connectionList_ul pt-2" style="font-weight: 500;">
            </ul>
        </div>
    </div>
</div>