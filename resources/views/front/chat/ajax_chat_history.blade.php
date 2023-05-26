@php

// dd($data);
    $session_data = session('user');
@endphp
@if (!empty($data))
    @foreach ($data as $key => $value )
        @if ($session_data['iUserId'] == $value->iSenderId)
            <div class="outgoing-message" data-session="{{$session_data['iUserId']}}" data-sender="{{$value->iSenderId}}">
                <p class="mb-0">{{$value->vMessage}}</p>
                <div class="time">
                    <p>{{date('d-M H:i A',strtotime($value->dtAddedDate))}}</p>
                </div>
            </div>
        @else
            <div class="incoming-message" data-session="{{$session_data['iUserId']}}" data-iReceiverId="{{$value->iReceiverId}}">
                <p class="mb-0">{{$value->vMessage}}</p>
                <div class="time">
                    <p>{{date('d-M H:i A',strtotime($value->dtAddedDate))}}</p>
                </div>
            </div>
        @endif
    @endforeach
@endif