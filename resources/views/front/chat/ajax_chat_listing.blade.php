@php
    $session_data = session('user');
    $user_id_array = [];
    $user_id_sender_array = [];
    $user_id_receiver_array = [];
    $sender_receiver_id_array = [];
    $count = 0;
    
    // dd($data);
@endphp
@if(count($data) >= 1)
    @foreach ($data as $key => $value )
        @php
            $data_repeat = false;
            if(in_array($value->iReceiverId,$user_id_receiver_array))
            {
                /* check this condition to display list of conneciton in left panel dashboard */
                // continue;
            }
            elseif(in_array($value->iSenderId,$user_id_sender_array))
            {
                /* check this condition to display list of conneciton in left panel dashboard */
                // continue;
            }
        @endphp

        @php
            foreach ($sender_receiver_id_array as $key_exists => $value_exists) {
                if (($value_exists['sender'] == $value->iSenderId && $value_exists['receiver'] == $value->iReceiverId) || ($value_exists['sender'] == $value->iReceiverId && $value_exists['receiver'] == $value->iSenderId)) {
                    $data_repeat = true;
                }
            }
            if ($data_repeat)
            {
                continue;
            }
        @endphp
            
        @php
            $count++;
            $sender_receiver_id_array[$count]['sender'] = $value->iSenderId;
            $sender_receiver_id_array[$count]['receiver'] = $value->iReceiverId;
            $displayName = '';
            $receiverPhoneNo = '';
            $vImage = '';
            $image = asset('front/assets/images/defaultuser.png');
        @endphp

        @if ($session_data['iUserId'] == $value->iReceiverId)
            @php
                $displayName = $value->senderName;
                $receiverPhoneNo = $value->vSenderMobNo;
                array_push($user_id_receiver_array,$value->iReceiverId);
                if ($value->senderImage !== null && file_exists(public_path('uploads/user/'.$value->senderImage))) {
                    $image = asset('uploads/user/'.$value->senderImage);
                }
            @endphp
        @elseif($session_data['iUserId'] == $value->iSenderId)
        @php
                array_push($user_id_sender_array,$value->iSenderId);
                $displayName = $value->receiverName;
                $receiverPhoneNo = $value->vReceiverMobNo;
                if ($value->receiverImage !== null && file_exists(public_path('uploads/user/'.$value->senderImage))) {
                    $image = asset('uploads/user/'.$value->receiverImage);
                }
            @endphp
        @endif
        <input type="hidden" value="{{asset('uploads/user/'.$image)}}">
        <input type="hidden" value="{{asset('uploads/user/'.$value->receiverImage)}}">
        <input type="hidden" value="{{asset('uploads/user/'.$value->senderImage)}}">

        @php
        if($contract_data)
        {
            if($value->iSenderId == $contract_data->iContractSenderUserID && $value->iReceiverId == $contract_data->iContractReceiverUserID)
            {
                $contractStatus=$contract_data->eContractStatus;
            }else{
                $contractStatus="";
            }
        }
        else{
                $contractStatus="";
            }
            if($session_data['iUserId'] == $value->iMessageReceiverId && $value->eRead == 'No')
            {
                $MessageStatus="No";
            }else{
                $MessageStatus="";
            }
            
        @endphp    
            <li class="chat-person-profile" data-read="{{$value->eRead}}"  data-msgSenderId="{{$value->iMessageSenderId}}" data-msgRecId="{{$value->iMessageReceiverId}}" data-loginid="{{$session_data['iUserId']}}" data-eConnectionStatus="{{$value->eConnectionStatus}}" data-iSenderId="{{$value->iSenderId}}" data-iReceiverId="{{$value->iReceiverId}}" data-vReceiverContactPersonName="{{$displayName}}" data-senderProfile="{{$value->eSenderProfileType}}" data-receiverProfile="{{$value->eReceiverProfileType}}"  data-vReceiverContactPersonPhoneNo="{{$receiverPhoneNo}}" data-iConnectionId="{{$value->iConnectionId}}" data-current_chat_profile_image="{{$image}}" data-contractStatus="@if($value->eContractStatus){{$value->eContractStatus}}@endif" data-iContractId="@if($contract_data){{$contract_data->iContractId}}@endif" data-contractAmount="@if($contract_data){{$contract_data->vContractTotalAmount}}@endif" data-contractCode="@if($contract_data){{$contract_data->vContractCode}} @endif" @if(!empty($MessageStatus)){{'style=background:#dfe9f1;'}} @endif>
            <div class="profile-info-chat pull-left">
                <div class="chat-profile-logo ">
                    <img src="{{$image}}" alt="">
                </div>                    
                <div class="message-detail">
                    <h4 class="persom-name">{{$displayName}} </h4>
                    {{-- @if ($session_data['iUserId'] == $value->iReceiverId)
                        <h4 class="persom-name">{{$value->receiverName}}</h4>
                    @else
                        <h4 class="persom-name">{{$value->senderName}}</h4>
                    @endif --}}
                    <p class="person-message">{{$value->vMessage}}</p>
                </div>
            </div>
            <!-- <div class="message-time">
            {{-- <p class="message-number">2</p> --}}
            </div> -->
        </li>
    @endforeach
    {{-- @php
        dd($sender_receiver_id_array);
    @endphp --}}
@else
    <li class="text-center">No messages</li>
@endif
@php
$notificationData = App\Helper\GeneralHelper::get_mychat_notification($session_data['iUserId']);
$notifiaction_status = $notificationData;
if($notificationData != null)
{
    $notifiaction_status = $notificationData->eRead;
}
@endphp
<input type="hidden" name="chat_notification_status" id="chat_notification_status" value="{{$notifiaction_status}}">