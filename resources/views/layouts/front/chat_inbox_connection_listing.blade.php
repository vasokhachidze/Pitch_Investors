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

<div class="col-lg-12 col-md-6 ">
    <div class="chat-box-warp mt-3">
        <h3 class="chat-heading">Inbox</h3>
        <hr>
        {{-- <div class="search-baar-chats">
            <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="search">
        </div> --}}
        <div class="chat-peopel">
            <ul id="connectionList_ul" class="connectionList_ul">

            </ul>

        </div>
    </div>
</div>