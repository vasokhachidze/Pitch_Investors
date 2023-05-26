@php
$session_data = (session('user') !== null )?session('user'):'';
$userData = $vAccNo = '';
if ($session_data !== '') {
    $vAccNo = $session_data['vAccNo'];
    $userData = App\Helper\GeneralHelper::get_user_by_id($session_data['iUserId']);
}

$payment_data = App\Helper\GeneralHelper::setting_info('payment');

$url = Request::segment(1);
$display_dashboard_left_page = 'style=display:none;';

$allow_dashboard_left_page = ['dashboard','investmentDashboard','advisorDashboard','investorDashboard','investor-add','investment-add','advisor-add','editUser','changePassword','investment-edit','investor-edit','advisor-edit'];

$session_payment_data = session('contract_payment');

@endphp
<div id="chating-box" class="chating-box" style="display:none;">
    <div class="cheating-header">
        <div class="cheating-profile-logo">
            <div class="cheating-image-profile">
                @php
                $image = asset('front/assets/images/defaultuser.png');
                if (!empty($userData)) {
                    $vImage = $session_data['vImage'];
                }

                if (isset($vImage) && file_exists(asset('uploads/user/' . $vImage))) {
                    if ($vImage != '') {
                        $image = asset('uploads/user/' . $vImage);
                    }
                }

                @endphp
                <img src="{{ $image }}" alt="" id="current_chat_profile_image" class="current_chat_profile_image">

            </div>
            <div class="cheating-user-name">
                <h4 class="persom-name mb-0" id="persom-name" class="persom-name"></h4>
                <label style="font-size: 12px">Mob. :
                    <span style="font-size: 12px" class="person-message mb-0 persom-phone" id="persom-phone"></span>
                </label>
                
                <a href="javascript:;" id="advisor_create_contract" data-bs-toggle="modal" data-bs-target="#myPaymentContractModal" class="btn btn-primary bg-blue advisor" style="display:none;">Create Contract</a>
                <a id="new_contract" class="btn btn-primary bg-orange" style="display:none;">New Contract Created</a>

                 <a href="javascript:;" id="contract_make_payment" data-bs-toggle="modal" data-bs-target="#myPaymentModal" class="btn btn-primary bg-blue advisor" style="display:none;">Pay Now</a>

                <!-- <br><button id="contract_make_payment"  class="btn btn-primary advisor" style="display:none;">Pay Now</button> -->
            </div>                
        </div>
        <div class="close-buttton-side">
            {{-- <a href="#"><img src="{{ asset('front/assets/images/gallary-icon.png') }}" alt=""></a> --}}
            <a href="javascript:;" class="close-chat"><img src="{{ asset('front/assets/images/Close_square_duotone.png') }}" alt=""></a>
        </div>
    </div>
    <div class="cheating-area">
    </div>
    <div class="send-message-input new-position-mesaage">
        <input type="text" class="form-control" id="vMessage" placeholder="Type your message...">
        <div class="upload-file">
            {{-- <a href="" style="border-right: 1px solid #D9D9D9;">
                <input type="file" id="avatar" name="avatar">
                <img src="{{ asset('front/assets/images/fileattch.png') }}" alt="">
            </a> --}}
            <a href="javascript:;" id="msg_send">
                <img src="{{ asset('front/assets/images/message.png') }}" alt="">
            </a>
        </div>
    </div>
        <!-- Modal -->
        
        <input type="hidden" name="iConnectionId" id="iConnectionId">
        <input type="hidden" name="iContractId" id="iContractId">
        <input type="hidden" name="iSenderId" id="iSenderId">
        <input type="hidden" name="iReceiverId" id="iReceiverId">
        <div class="modal chat-header-btn-popup fade chat-model-btn" id="myPaymentContractModal" tabindex="-1" aria-labelledby="myContractModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <!-- <h5 class="modal-title" id="myContractModalLabel">Modal title</h5> -->
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="ine-details">
                            <h5>Create Contract Payment</h5>
                            <p>You can contract with this user as long as you want.</p>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-input margin-bottom-five">
                                    <label for="vFirstName">Description</label>
                                    <input type="text" id="vContractDescription" name="vContractDescription" class="form-control" placeholder="e.g Milestone for the design">
                                     <div id="vContractDescription_error" class="error mt-1" style="color:red;display: none;">Please enter Description</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-input margin-bottom-five">
                                    <label for="vFirstName">Amount (KES)</label>
                                    <input type="number" id="vContractAmount" name="vContractAmount" class="form-control" placeholder="Amount">
                                    <div id="vContractAmount_error" class="error mt-1" style="color:red;display: none;">Please enter amount</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit"  id="create_contract" class="btn btn-primary">Create Contract</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- for payment model  start-->
        <div class="modal chat-header-btn-popup fade chat-model-btn" id="myPaymentModal" tabindex="-1" aria-labelledby="myContractModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content" >
                    <div class="modal-header">
                        <!-- <h5 class="modal-title" id="myContractModalLabel">Modal title</h5> -->
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="forPayment">
                        <div class="ine-details">
                            <h5>Contract Payment</h5>
                            <p>You can release this payment once you are 100% satisfied with the work provided.</p>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-input margin-bottom-five">
                                    <label for="iPhoneNumber">Phone Number</label>
                                    <input type="number" id="iPhoneNumber" name="iPhoneNumber" class="form-control" placeholder="Your mPesa register number">
                                    <div id="iPhoneNumber_error" class="error mt-1" style="color:red;display: none;">Please enter phone number</div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center" id="ajax-loader" style="display: none;">
                            <img src="{{ asset('admin/assets/images/ajax-loader.gif') }}" width="100px"
                                height="auto" />
                        </div>
                    </div>

                    <div class="modal-footer" id="payment-button">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit"  id="contract_make_payment1" class="btn btn-primary">Pay Now</button>
                    </div>
                    <div class="row modal-body" id="alternativly_modal_body">
                        <div class="col-md-12">
                            <div class="form-input margin-bottom-five">
                                <label>Alternativly</label>
                                @php
                                $BusinessNo = $payment_data['C2B_SHORT_CODE_LIVE']['vValue'];
                                $AccountNo = $vAccNo;
                                @endphp
                                <ul>
                                    <li> Go To Mpesa >Lipa na Mpesa > PayBill </li>
                                    <li> Business No : {{$BusinessNo}} </li>
                                    <li> Account No : {{$vAccNo.'#'}}<span id="contractCode"> </span></li>
                                    <li> Amount : <span id="contractAmount"></span></li>
                                    <li> Enter Your Mpesa PIN</li>
                                    <li> Press Ok</li>
                                </ul>   
                            </div>
                        </div>
                    </div>
                     <div class="modal-body" id="forVerifyPayment" style="display:none;">
                        <div class="ine-details">
                            <h5>Verify Payment</h5>
                            <p>You can release this payment once you are 100% satisfied with the work provided.</p>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-input margin-bottom-five">
                                    <input type="hidden" name="CheckoutRequestID" id="CheckoutRequestID" value="">
                                </div>
                            </div>
                        </div>
                        <div class="send-model-btn text-center">
                                <a href="javascript:;" class="all-btn" id="verifyPayment">Verify Payment</a>
                        </div>                                       
                    </div>

                    <div class="modal-body" id="forVerifyPaymentMessage" style="display:none;">
                        <!-- <div class="ine-details">
                            <h5>Verify Payment</h5>
                            <p>You can release this payment once you are 100% satisfied with the work provided.</p>
                        </div> -->
                        <!-- <div class="row">
                            <div class="col-md-12"> -->
                                <div class="alert alert-success mt-2">
                                      <strong id="message"></strong>
                                </div>                                
                            <!-- </div>
                        </div> -->                      
                    </div>
                </div>
            </div>
        </div>
        <!-- for payment model end -->
        
</div>
<script type="text/javascript">
    $(document).on('click', '#create_contract', function() {
        var iConnectionId = $('#iConnectionId').val();
        var vContractAmount = $('#vContractAmount').val();
        var vContractDescription = $('#vContractDescription').val();
        var iSenderId = $('#iSenderId').val();
        var iReceiverId = $('#iReceiverId').val();
        error = false;

        if (vContractDescription.length == 0) {
            $("#vContractDescription_error").show();
            $("#vContractDescription").addClass('has-error');
            error = true;
        } else {
            $("#vContractDescription_error").hide();
            $("#vContractDescription").removeClass('has-error');
            
        }  
        if (vContractAmount.length == 0) {
            $("#vContractAmount_error").show();
            $("#vContractAmount").addClass('has-error');
            error = true;
        } else {
            $("#vContractAmount_error").hide();
            $("#vContractAmount").removeClass('has-error');
            
        }

        setTimeout(function() {
        if (error == true) {
            $('.has-error').first().focus();
            return false;
        } else {
              $.ajax({
                    url: "{{ url('advisor-create-contract') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        iConnectionId:iConnectionId,
                        vContractDescription: vContractDescription,
                        vContractAmount: vContractAmount,
                        iSenderId:iSenderId,
                        iReceiverId:iReceiverId
                    },
                    success: function(response) {
                        if(response == 0)
                        {
                            $('#myPaymentContractModal').hide();
                            location.reload();
                        }
                    }
                });
                return true;
            }
        }, 1000);
    });

     $(document).on('click', '#contract_make_payment1', function() 
     {
        $("#alternativly_modal_body").hide();
        var iConnectionId = $('#iConnectionId').val();
        var iContractId = $('#iContractId').val();
        var iPhoneNumber = $('#iPhoneNumber').val();
        error = false;
         if (iPhoneNumber.length == 0) 
            {
                $("#iPhoneNumber_error").show();
                $("#iPhoneNumber").addClass('has-error');
                error = true;
            } else {
                $("#iPhoneNumber_error").hide();
                $("#iPhoneNumber").removeClass('has-error');
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
                        $("#ajax-loader").show();
                        $("#contract_make_payment1").hide();
                        $("#payment-button").hide();
                        // $("#myPaymentModal").hide();
                        $("#contract_make_payment").hide();

                    $.ajax({
                        url: "{{ url('contract-payment') }}",
                        type: "POST",
                        dataType: "JSON",
                        headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                        data: {
                            iConnectionId:iConnectionId,iContractId: iContractId,iPhoneNumber:iPhoneNumber
                        },
                        success: function(response) 
                        {
                            if(response == true)
                            {
                                var session ='<?php if(!empty($session_payment_data)){  echo $session_payment_data['CheckoutRequestID'];} ?>';
                                $('#forPayment').hide()
                                $('#forVerifyPayment').show();
                                $('#CheckoutRequestID').val(session);
                            }else
                            {
                                Toast.fire({
                                    icon: 'error',
                                    title: 'Payment not completed'
                                });
                                location.reload();
                            }
                        }
                    });        
                }
            }, 1000);
    });
 $(document).on('click', '#verifyPayment', function() {
    $('#forVerifyPaymentMessage').hide();
    var session_payment ='<?php if(!empty($session_payment_data)){  echo $session_payment_data['CheckoutRequestID']; } ?>';
    setTimeout(function() 
    {
        $.ajax({
            url: "{{url('verify-contract-payment')}}",
            type: "POST",
            headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
            data: {
                session_payment1: session_payment
            },
            success: function(response) 
            {
                var response1 = JSON.parse(response);
                if (response1.status == 1) {
                    $('#forVerifyPaymentMessage div strong').html(response1.error_msg);
                    $('#forPayment').hide()
                    $('#forVerifyPayment').hide();
                    $('#forVerifyPaymentMessage').show();
                }
                else{
                    $('#forVerifyPaymentMessage div strong').html(response1.error_msg);
                    $('#forPayment').hide()
                    $('#forVerifyPaymentMessage').show();
                }
            }
        });
    }, 500);
});

</script>