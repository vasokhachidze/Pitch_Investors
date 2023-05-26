@php
$general_company = \App\Helper\GeneralHelper::setting_info('Company');
$company_number     = $general_company['COMPANY_NUMBER']['vValue'];
$company_email     = $general_company['COMPANY_EMAIL']['vValue'];
$company_address     = $general_company['COMPANY_ADDRESS']['vValue'];
@endphp
@extends('layouts.app.front-app')
@section('title', 'Contact Us - '.env('APP_NAME'))
@section('content')
    <!-- banner section start -->
    <section class="contact-bread-camp">
      <div class="container">
          <div class="bread-text-head">
              <h4><a class="bread-tag-hover" href="{{ route('front.home') }}">Home</a> / Contact Us</h4>
              <h1>Contact Us</h1>
          </div>
      </div>
    </section>
    <!-- banner section end -->

    <!-- contact section start -->
    <section class="contact-inform">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-12">
                    <div class="row">
                        <div class="col-lg-12 col-md-6">
                            <div class="gental-inq">
                                <h4>General Inquiries</h4>

                                <div class="contact-part">
                                    <div class="contact-info-icon">
                                        <i class="far fa-phone-alt"></i>
                                    </div>
                                    <div class="contact-us-direct">
                                        <ul>
                                            <a href="tel:{{ $company_number }}"><li>+{{ $company_number }}</li></a>
                                        </ul>
                                    </div>
                                </div>

                                <div class="contact-part">
                                    <div class="contact-info-icon">
                                        <i class="fal fa-envelope"></i>
                                    </div>
                                    <div class="contact-us-direct">
                                        <ul>
                                            <a href="mailto:{{$company_email}}"><li>{{ $company_email }}</li></a>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-6">
                            <div class="gental-inq">
                                <h4>Our Location</h4>

                                <div class="contact-part">
                                    <div class="contact-info-icon">
                                        <i class="fal fa-map-marker-alt"></i>
                                    </div>
                                    <div class="contact-us-direct">
                                        <ul>
                                            <a><li>{{ $company_address }}
                                                </li></a>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-12">
                    <div class="contact-form">
                        <h3>Contact Us</h3>
                        <p>Use this form to submit general inquiries to PitchInvestors. We will respond to you as soon as possible. </p>
                    </div>
                    <form id="frm" action="{{url('contactus_submit')}}" method="Post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 fix-height">
                                <div class="mb-3">
                                    <label>Name</label>
                                    <input type="text" class="form-control" id="vName" name="vName" placeholder="Please Enter Name">
                                    <div id="vName_error" class="error_show">Please Enter Name</div>
                                </div>
                            </div>
                            <div class="col-md-6 fix-height">
                                <div class="mb-3">
                                    <label>Email</label>
                                    <input type="email" class="form-control" id="vEmail" name="vEmail" placeholder="Please Enter Email">
                                    <div id="vEmail_error" class="error_show">Please Enter Email</div>
                                    <div id="vEmail_valid_error" class="error_show">Please Enter Valid Email</div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label>Mesaage</label>
                                    <textarea class="form-control" id="tComments" name="tComments" rows="10" placeholder="Please Enter Message"></textarea>
                                    <div id="tComments_error" class="error_show">Please Enter Message</div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn submit">Send Now</button>
                        {{-- <a href="javascript:;" class="btn submit">Send Now</a> --}}
                    </form>
                </div>
            </div>

        </div>
    </section>
    <!-- contact section end -->
@endsection
@section('custom-js')
<script>
    $(document).ready(function() {
        var error_msg = $('#error_msg').val();
        var success_msg = $('#success_msg').val();
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
        if(error_msg)
        {
            Toast.fire({
            icon: 'error',
            title: error_msg
            })
        }
        if(success_msg)
        { 
            Toast.fire({
            icon: 'success',
            title: success_msg
            })
        }
    });
</script>
<script>
$(document).on('click', '.submit', function() {
    vEmail = $("#vEmail").val();
    vName = $("#vName").val();
    tComments = $("#tComments").val();
    
    var error = false;

    <?php if (!isset($data->iUserId)) { ?>
    if (vEmail.length == 0) {
        $("#vEmail_error").show();
        $("#vEmail_valid_error").hide();
        error = true;
    } else {
        if (validateEmail(vEmail)) {
            $("#vEmail_valid_error").hide();
            $("#vEmail_error").hide();
        } else {
            $("#vEmail_valid_error").show();
            $("#vEmail_error").hide();
            error = true;
        }
    }
    <?php } ?>
    if (vName.length == 0) {
        $("#vName_error").show();
        error = true;
    } else {
        $("#vName_error").hide();
    }
    if (tComments.length == 0) {
        $("#tComments_error").show();
        error = true;
    } else {
        $("#tComments_error").hide();
    }
    
    setTimeout(function() {
        if (error == true) {
            return false;
        } else {
            $("#frm").submit();
            return true;
        }
    }, 1000);
});

//Function for validate Email
function validateEmail(sEmail) {
    var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    if (filter.test(sEmail)) {
        return true;
    } else {
        return false;
    }
}
</script>
@endsection