@extends('layouts.app.front-app')
@section('title', 'Plan Listing - ' . env('APP_NAME'))
@section('content')
@php
$session_payment_data = session('payment');
// after dd => 'CheckoutRequestID' => 'ws_CO_24012023062551577727057310' 
//so i  had to find where does this come from?! 
//here: PlanController::payment(...) {
    // after user receives stk push...
    // session()->put('payment.CheckoutRequestID', $curl_response->CheckoutRequestID);
    //does the session get cleared?? what happens if i pay twice? 
//}
@endphp
    <!-- Main content -->
    <div class="container-fluid" style="margin-top:5%">
        <div class="container p-5">
            <div class="row" id="ajax_data_show">
                <div class="text-center" id="ajax-loader">
                    <img src="{{ asset('admin/assets/images/ajax-loader.gif') }}" width="100px" height="auto" />
                </div>
            </div>
        </div>
    </div>
    <div id="success">
        
    </div>
@endsection

@section('custom-css')
    <style>
        .card {
            border: none;
        }

        .card::after {
            position: absolute;
            z-index: -1;
            opacity: 0;
            -webkit-transition: all 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
            transition: all 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .card:hover {
            transform: scale(1.02, 1.02);
            -webkit-transform: scale(1.02, 1.02);
            backface-visibility: hidden;
            will-change: transform;
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, .75) !important;
        }

        .card:hover::after {
            opacity: 1;
        }
    </style>
@endsection

@section('custom-js')
    <script>
        $(document).ready(function() {
            $("#ajax-loader").show();
            setTimeout(function() {
                $.ajax({
                    url: "{{ url('ajax_listing') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: "",
                    success: function(response) {
                        $("#ajax_data_show").html(response);
                        $("#ajax-loader").hide();
                    }
                });
            }, 1000);
        });

    $(document).on('click', '#purchaseToken', function() {
        var iPlanId = $("#iPlanId").val(); 
        var loginUserId = $("#loginUserId").val(); 
        var vPhoneNumber = $('#vPhoneNumber').val(); 

        error = false;
        if (vPhoneNumber.length == 0)
        {
            $("#phone_error").show();
            $("#phone_zero_start_error").hide();
            $("#vPhoneNumber").addClass('has-error');
            error = true;
        } else {
            if (Array.from(vPhoneNumber)[0] != 0) {
                $("#phone_zero_start_error").show();
                error = true;
            }
            else{
                $("#phone_zero_start_error").hide();
            }
            $("#phone_error").hide();
            $("#vPhoneNumber").removeClass('has-error');
        }

        // setTimeout(function() 
        // {
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

                if (loginUserId != "") 
                {
                    $("#ajax-loader2").show();
                    $("#purchaseToken").hide();
                    $("#alternativly_contace_modal_div").hide();
                    // $("#exampleModal1").hide();

                    
                    $.ajax({
                        url: "{{ url('plan-purchase') }}",
                        type: "POST",
                        dataType: "JSON",
                        headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                        data: {
                            loginUserId: loginUserId,iPlanId:iPlanId,vPhoneNumber:vPhoneNumber
                        },
                        timeout: 10000,
                        success: function(response) 
                        {
                            console.log(response)

                            if(response == true)
                            {
                                var session ='<?php if(!empty($session_payment_data)){  echo $session_payment_data['CheckoutRequestID'];} ?>';
                                $('#forPlanPayment').hide();
                                $('#forVerifyPlanPayment').show();
                                $("#ajax-loader3").show();
                                
                                // $('#forVerifyPlanPayment').show();
                                $('#CheckoutRequestID').val(session);
                            } else {
                                Toast.fire({
                                    icon: 'error',
                                    title: 'DS timeout user cannot be reached'
                                })
                              location.reload();
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            if (textStatus === "timeout") {
                                console.log("Request timed out");
                                // $("#ajax-loader2").hide();
                                $('#requestError div strong').html('Mpesa server taking time to respond, please hold on a memoment...');
                                $('#requestError').show();
                            } else {
                                console.log("Request failed: " + textStatus + " " + errorThrown);
                                var error = "Request failed: " + textStatus + " " + errorThrown;
                                $("#ajax-loader2").hide();
                                $('#requestError div strong').html(error);
                                $('#requestError').show();
                                Toast.fire({
                                        icon: 'error',
                                        title: "Request failed: " + textStatus + " " + errorThrown
                                    })
                            }
                            
                        },
                        fail: function(qXHR, textStatus, errorThrown){
                            console.log("Request timed out");
                            // $("#ajax-loader2").hide();
                            $('#requestError div strong').html('Mpesa server taking time to respond, please hold on a memoment...');
                            $('#requestError').show();
                        },
                        
                    });
                    
                    
                } else {
                    alert('login first');
                }
            }
        // }, 500);
    });

    $(document).on('click', '#verifyPlanPayment', function() {
        $('#forVerifyPlanPaymentMessage').hide();
        var session_payment ='<?php if(!empty($session_payment_data)){  echo $session_payment_data['CheckoutRequestID']; } ?>';
        setTimeout(function() 
        {
            $.ajax({
                url: "{{url('verify-payment')}}",
                type: "POST",
                headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                data: {
                    session_payment: session_payment
                },
                success: function(response) 
                {
                    console.log(response);
                    if (response == "1") {
                        $('#forVerifyPlanPaymentMessage div strong').html('Waiting for response');
                        $('#forVerifyPlanPaymentMessage').show();
                        setTimeout(() => {
                            $('#forVerifyPlanPaymentMessage').hide();
                        }, 3000);
                        // toastr.success('Waiting for response');
                    }else{
                        $('#forPlanPayment').hide()
                        // $('#forVerifyPlanPayment').hide();
                        $('#forVerifyPlanPaymentMessage div strong').html(response);
                        $('#forVerifyPlanPaymentMessage').show();
                        // toastr.success(response);
                    }
                }
            });
        }, 500);
    });


    Echo.channel(`loader-switch`)
    // Echo.private(`loader-switch.${GetUserToken()}`)
        .listen('.loader-switch-event', (e) => {
            console.log(e)
            if (e.value) {
                console.log('--loader switch on--')
                 $("#ajax-loader3").show();
            } else {
                console.log('--loader switch off--')
                $("#ajax-loader3").hide();
                $("#verifyPlanPaymentSec").show();
            }
        });
    Echo.channel(`mpesa-response`)
        .listen('.mpesa-response-event', (e) => {
            console.log(e.response['ResultDesc']);
            if (e.response['ResultCode']==0) {
                // Toast.fire({
                //     icon: 'success',
                //     title: e.response['ResultDesc']
                // })
                $('#forVerifyPlanPayment').show();
            } else {
                $("#verifyPlanPaymentSec").hide();
                $('#forVerifyPlanPaymentMessageError div strong').html(e.response['ResultDesc']);
                $('#forVerifyPlanPaymentMessageError').show();
                // Toast.fire({
                //     icon: 'error',
                //     title: e.response['ResultDesc']
                // })
            }
        });
</script>
@endsection