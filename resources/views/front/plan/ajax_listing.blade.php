@php
$session_data = session('user');
$loginID=$session_data['iUserId'];
$vAccNo=$session_data['vAccNo'];
$payment_data = App\Helper\GeneralHelper::setting_info('payment');
//dd($payment_data);
@endphp

@if ($data->count())
    @foreach ($data as $key => $value)
        <div class="col-lg-3 col-md-12 mb-4">
            <div class="card h-100 shadow-lg">
                <div class="card-body">
                    <div class="text-center p-3">
                        <h5 class="card-title">{{ $value->vPlanTitle }}</h5>
                        <span class="h2">KES {{ $value->vPlanPrice }}</span>
                    </div>
                    {!! $value->vPlanDetail !!}
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                            <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
                        </svg> Connections : <b>{{ $value->iNoofConnection }}</b>
                    </li>
                </ul>
                <div class="card-body text-center">
                    <a href="javascript:;" data-bs-toggle="modal" data-loginid="{{$loginID}}"  data-id="{{$value->vUniqueCode}}" data-planPrice="{{$value->vPlanPrice}}" data-bs-target="#exampleModal1" id="token_model"  class="w-100 btn btn-lg btn-outline-primary token_model" style="border-radius:30px">Buy</a>
                </div>               
                 
            </div>
        </div>
    </div>
    @endforeach
@else
    <tr class="text-center">
        <td colspan="9">No Record Found</td>
    </tr>
@endif

<div class="col-xl-4 col-lg-12 mt-2">
    <div class="row">
        @csrf
        <div class="modal fade contact-business-model-frist purchase-btn-popup" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body contact-business-model ">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="success" id="c2b_response"></div>
                                <div class="contace-business-model-detail" id="forPlanPayment">
                                    <h2>Purchase Plan</h2>
                                    <p class="mb-0">Buying this plan will add the given token to your token balance and then you can connect to any business.</p>
                                    <div class="mt-2">
                                        <label for="phone">Your Mobile Number</label>
                                        <input type="hidden" name="iPlanId" id="iPlanId" value="">
                                        <input type="hidden" name="loginUserId" id="loginUserId" value="">
                                        <input type="text" name="vPhoneNumber" id="vPhoneNumber" class="form-control numeric" maxlength="10" placeholder="Please enter your phone number">
                                        <label style="color:grey; font-size: small; font-weight: bold;">Mobile Number Format : 0123456789 ( Start with zero )  </label>
                                        <input type="session" name="session" id="session" style="display:none;">
                                        <div id="phone_error" class="error mt-1" style="color:red;display: none;">Please enter your phone number</div>
                                        <div id="phone_zero_start_error" class="error mt-1" style="color:red;display: none;">Please enter your phone number in correct format</div>
                                    </div>
                                    <div class="send-model-btn text-center">
                                        <a href="javascript:;" class="all-btn" id="purchaseToken">Buy Now </a>
                                    </div>
                                     <div class="text-center" id="ajax-loader2" style="display: none;">
                                        <img src="{{ asset('admin/assets/images/ajax-loader.gif') }}" width="100px" height="auto" />
                                     </div>
                                     <div class="contace-business-model-detail" id="requestError" style="display:none;">
                                       
                                        <div class="alert alert-danger mt-2">
                                              <strong id="message"></strong>
                                        </div>                        
                                    </div>
                                     <div class="contace-business-model-detail" id="alternativly_contace_modal_div">
                                        <label>Alternativly</label>
                                        @php
                                        $BusinessNo = $payment_data['C2B_SHORT_CODE_LIVE']['vValue'];
                                        $AccountNo = $vAccNo;
                                        @endphp
                                        <ul>
                                            <li> Go To Mpesa >Lipa na Mpesa > PayBill </li>
                                            <li> Business No : {{$BusinessNo}} </li>
                                            <li> Account No : {{ $AccountNo.'#'.$value->vPlanCode }} </li>
                                            <li> Amount : <span id="modal_plan_price"></span></li>
                                            <li> Enter Your Mpesa PIN</li>
                                            <li> Press Ok</li>
                                        </ul>   
                                    </div> 
                                </div>
                                </div>
                                <div class="contace-business-model-detail" id="forVerifyPlanPayment" style="display:none;">
                                    <h2>Verify Payment</h2>
                                    <p class="mb-0">Buying this plan will add the given token to your token balance and then you can connect to any business.</p>
                                    <div class="mt-2">                                        
                                        <input type="hidden" name="CheckoutRequestID" id="CheckoutRequestID" value="">                                        
                                    </div>
                                    <div class="text-center" id="ajax-loader3" style="display: none;">
                                        <img src="{{ asset('admin/assets/images/ajax-loader.gif') }}" width="100px" height="auto" />
                                     </div>
                                    <div class="send-model-btn text-center" style="display: none;" id="verifyPlanPaymentSec">
                                        <a href="javascript:;" class="all-btn" id="verifyPlanPayment">Verify Payment</a>
                                    </div>                                      
                                </div> 
                                <div class="contace-business-model-detail" id="forVerifyPlanPaymentMessage" style="display:none;">
                                    <!-- <h2>Verify Payment</h2>
                                    <p class="mb-0">Buying this plan will add the given token to your token balance and then you can connect to any business.</p> -->
                                    <div class="alert alert-success mt-2">
                                          <strong id="message"></strong>
                                    </div>                        
                                </div>
                                <div class="contace-business-model-detail" id="forVerifyPlanPaymentMessageError" style="display:none;">
                                    <!-- <h2>Verify Payment</h2>
                                    <p class="mb-0">Buying this plan will add the given token to your token balance and then you can connect to any business.</p> -->
                                    <div class="alert alert-danger mt-2">
                                          <strong id="message"></strong>
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
<script type="text/javascript">
    $(".token_model").click(function(){ 
        var iPlanID = $(this).data("id");
        var loginUserId = $(this).data("loginid");
        var planPrice = $(this).data("planprice");

        $("#modal_plan_price").html(planPrice);
        $("#iPlanId").val(iPlanID);
        $("#loginUserId").val(loginUserId);
    });
    $(".btn-close").click(function(event) {
        location.reload();
    });
</script>