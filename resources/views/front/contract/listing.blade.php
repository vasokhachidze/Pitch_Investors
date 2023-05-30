@extends('layouts.app.front-app')
@section('title', 'Contract '.env('APP_NAME'))
@php
$session_data = session('user');
$userData = '';
if ($session_data !== '') {
    $userToken = App\Helper\GeneralHelper::get_myAvailable_token($session_data['iUserId']);
}
$session_withdraw_data = session('withdraw_amount');
@endphp
@section('custom-css')
@endsection
@section('content')
<section class="my-dashbord">
    <div class="container">
        <div class="row">
            @include('layouts.front.left_dashboard')
            <div class="col-lg-12">
                <div class="right-panal-side">
                    <div class="row padding-no">
                        <div class="wallet-warrap">
                            @if($session_data['iUserId'] == $wallet_balance->iSenderId)
                            <div class="col-md-12">
                                <div class="wallet-inside-blance">
                                    <div class="wallet-balence">
                                        <h3>Wallet</h3>
                                        <h2 class="balence-value">Amount @if(!empty($wallet_balance)){{$wallet_balance->walletAmount}}@else {{'0'}} @endif</h2>
                                        <p>Current Wallet Balance </p>
                                    </div>
                                    <div class="add-money bg-green">
                                        <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#withdrawModal1"><i class="fa fa-money"></i>Withdraw</a>
                                    </div>
                                </div>
                            </div>
                            @else
                             <div class="col-md-12">
                                <div class="wallet-inside-blance">
                                    <div class="wallet-balence">
                                        <h3>Paid</h3>
                                        <h2 class="balence-value">Amount {{$wallet_balance->walletAmount}}</h2>
                                        <p>Total Paid Amount </p>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if(count($contract_list) > 0)
                            <div class="row">
                                <div class="col-md-12 mt-4">
                                    <div class="transaction-table">
                                        <h4 class="table-heading">History of Contract</h4>
                                        <div class="table-responsive">
                                            <table class="table table-striped transaction-value-table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Date</th>
                                                        <th class="transaction-text-center" scope="col">Contract Sender Name</th>
                                                        <th class="transaction-text-center" scope="col">Contract Created With</th>
                                                        <th class="transaction-text-center" scope="col">Contract Amount</th>
                                                        <th class="transaction-text-center" scope="col">Phone No</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($contract_list as $key => $cotValue)
                                                    <tr>
                                                        <td scope="row">{{date('d-m-Y',strtotime($cotValue->dtAddedDate))}}</td>
                                                        <td class="transaction-text-center">{{$cotValue->contractSenderName}}</td>
                                                        <td class="transaction-text-center">{{$cotValue->contractReceiverName}}</td>
                                                        <td class="transaction-text-center"><label class="kes">KES </label> {{$cotValue->vContractAmount}}
                                                        </td>
                                                        <td class="transaction-text-center">{{$cotValue->vPhone}}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                             <div class="row">
                                <div class="col-md-12 mt-4">
                                    <div class="transaction-table">
                                        <h4 class="table-heading">Contract Record Not Found</h4>
                                        <div class="table-responsive">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="col-xl-4 col-lg-12">
    <div class="row">
        @csrf
        <div class="modal fade contact-business-model-frist withdraw-btn-popup" id="withdrawModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">

                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body contact-business-model">
                        <div class="row">
                            <div class="col-lg-12">

                                <div class="contace-business-model-detail" id="forWithdraw">
                                    <h2>Withdraw Amount</h2>

                                    <p class="mb-0">You can withdraw a perticuler amount from your Mpesa account</p>
                                    <div class="mt-2">
                                        <label for="amount">Amount</label>
                                        <input type="hidden" name="loginUserId" id="loginUserId" value="{{$session_data['iUserId']}}">
                                        <input type="hidden" name="vUniqueCode" id="vUniqueCode" value="{{$session_data['vUniqueCode']}}">

                                        <label for="iPhoneNumber">Phone Number</label>
                                        <input type="text" id="iPhoneNumber1" name="iPhoneNumber" class="form-control" placeholder="Your mPesa register number">
                                        <div id="iPhoneNumber1_error" class="error mt-1" style="color:red;display: none;">Please enter phone number</div>
                                        <br>
                                        <label for="iAmount">Amount</label>
                                        <input type="number" name="iAmount" id="iAmount" class="form-control numeric"placeholder="Please enter amount you want to withdraw">
                                        <div id="iAmount_error" class="error mt-1" style="color:red;display: none;">Please enter amount</div>
                                    </div>
                                    <div class="send-model-btn text-center">
                                        <a href="javascript:;" class="all-btn" id="withdrawAmount">Withdraw</a>
                                    </div>  
                                    <div class="text-center" id="ajax-loader2" style="display: none;">
                                        <img src="{{ asset('admin/assets/images/ajax-loader.gif') }}" width="100px" height="auto" />
                                     </div>                                     
                                </div>
                                 <div class="contace-business-model-detail" id="forVerifyWithdraw" style="display:none;">
                                    <h2>Verify Withdrawal</h2>
                                    <p class="mb-0">You can withdraw a perticuler amount from your Mpesa account</p>
                                    <div class="mt-2">                                        
                                        <input type="hidden" name="CheckoutRequestID" id="CheckoutRequestID" value="">                                        
                                    </div>
                                    <div class="send-model-btn text-center">
                                        <a href="javascript:;" class="all-btn" id="verifywithdraw">Verify Payment</a>
                                    </div>                                       
                                </div> 
                                <div class="contace-business-model-detail" id="forVerifyWithdrawMessage" style="display:none;">
                                    <h2>Verify Withdrawal</h2>
                                    <p class="mb-0">You can withdraw a perticuler amount from your Mpesa account</p>
                                    <div class="mt-5">
                                          <strong id="withdrawalmessage"></strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
        <!---close model--->
    </div>
</div>
@endsection
@section('custom-js')

<script type="text/javascript">
      $(document).on('click', '#withdrawAmount', function() 
     {  
        var amount=$('#iAmount').val();
        var iPhoneNumber1 = $('#iPhoneNumber1').val();
        var loginUserId = $('#loginUserId').val();
        var vUniqueCode = $('#vUniqueCode').val();


        error = false;
        if (amount.length == 0) 
        {
            $("#iAmount_error").show();
            $("#iAmount").addClass('has-error');
            error = true;
        } else {
            $("#iAmount_error").hide();
            $("#iAmount").removeClass('has-error');
        }  
        if (iPhoneNumber1.length == 0) 
        {
            $("#iPhoneNumber1_error").show();
            $("#iPhoneNumber1").addClass('has-error');
            error = true;
        } else {
            $("#iPhoneNumber1_error").hide();
            $("#iPhoneNumber1").removeClass('has-error');
        }  
         setTimeout(function() 
         {
            if (error == true) {
                $('.has-error').first().focus();
                return false;
            } else 
            {

                 var Toast = Swal.mixin({
                       toast: true,
                       position: 'top-end',
                       showConfirmButton: false,
                       timer: 3000
                 });
            
                
                    $("#ajax-loader2").show();
                    $("#withdrawAmount").hide();
                    // $("#myPaymentModal").hide();

                $.ajax({
                    url: "{{ url('withdraw-amount') }}",
                    type: "POST",
                    dataType: "JSON",
                    headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                    data: {
                        amount:amount,iPhoneNumber:iPhoneNumber1,loginUserId:loginUserId,vUniqueCode:vUniqueCode
                    },
                    success: function(response) 
                    {  
                        if(response.key == 'true')
                        {
                           var session ='<?php if(!empty($session_withdraw_data)){  echo $session_withdraw_data['ConversationID'];} ?>';
                            $('#forWithdraw').hide()
                            $('#forVerifyWithdraw').show();
                            $('#ConversationID').val(session);
                        }else
                        {
                            Toast.fire({
                            icon: 'error',
                            title: 'Mpesa withdrawal not successful'
                            })
                            // location.reload();
                        }
                    }
                });        
            }
        }, 1000);
    });
$(document).on('click', '#verifywithdraw', function() {         
var session_withdraw ='<?php if(!empty($session_withdraw_data)){  echo $session_withdraw_data['ConversationID']; } ?>';
  setTimeout(function() 
     {
        $.ajax({
            url: "{{url('verify-withdraw')}}",
            type: "POST",
            headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
            data: {
                session_withdraw: session_withdraw
            },
            success: function(response) 
            {
                $('#forWithdraw').hide()
                $('#forVerifyWithdraw').hide();
                $('#forVerifyWithdrawMessage').show();
                $('#withdrawalmessage').text(response);                        
                if(response.key == 'true')
                {
                    $('#forWithdraw').hide()
                    $('#forVerifyWithdraw').hide();
                    $('#forVerifyWithdrawMessage').show();
                    $('#message').text(response);                        
                }else{
                    $('#forWithdraw').hide()
                    $('#forVerifyWithdraw').hide();
                    $('#forVerifyWithdrawMessage').show();
                    $('#message').text(response); 
                }
            }
        });
     }, 500);
});
</script>
@endsection

