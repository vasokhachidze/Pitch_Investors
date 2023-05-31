@extends('layouts.app.front-app')
@section('title', 'Investor Dashboard - '.env('APP_NAME'))

@section('content')
@php
    // dd($session_data);
@endphp
<style type="text/css">/* Style the tab */
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
  /*display: none;*/
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
}

.listings {
  list-style-type:disc;
  margin-left:6%;
}

.listings li {  
  margin-top:10px;
}
</style>
<section class="my-dashbord">
    <div class="container">
        <div class="row">
          @include('layouts.front.left_dashboard')
            <div class="col-lg-9 box2">
                <div class="right-panal-side">

                    <!-- Sell Your business section start -->
                    <div class="row mt-3 padding-no">
                        <div class="letest-activity">
                       
                      <!-- Investment tab start-->
                      <div id="Investment" class="tabcontent">
                          
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="sell-yiur-bussinrs-activity-listing margin-top-foruthy">
                                            <div class="left-text">
                                                
                                                <p style = "margin:10px">
                                                Welcome to PitchInvestors! We're excited to have you join our community of business owners and
investors. We know that presenting your business to potential investors can be a challenging task, which
is why we've put together this guide to help you create a strong profile that will catch the attention of
investors. We know that writing may be overwhelming to many of us. You can signup to chat.openai.com
to access ChatGPT to help you generate professional words to use for your listing.<br><br>
Here are some tips for creating a compelling profile:
                                                </p>
                                                <ul class="listings">
                                                <li>
                                                Clearly define your business: Start by clearly defining what your business does and what sets it apart from competitors. Be concise, but make sure to highlight the unique value proposition of your business.
                                                </li>
                                                <li>
                                                Highlight your achievements: Investors want to see evidence that your business has the potential for success. Highlight any milestones, awards, or recognitions that your business has achieved so far.
                                                </li>
                                                <li>
                                                Provide financial information: Investors want to see that your business is financially viable. Be transparent about your revenue, expenses, and any funding you've received so far. Include a realistic financial projection for the future.
                                                </li>
                                                <li>
                                                Showcase your team: Investors want to see that your business has a strong and capable team. Introduce your key team members and highlight their relevant experience and qualifications.
                                                </li>
                                                <li>
                                                Provide a clear call to action: Let investors know what you're looking for and how they can get involved. Are you looking for seed funding? Series A funding? Strategic partnerships? Make it clear what you're looking for and how investors can get in touch.
                                                </li>
                                               
                                                </ul>
                                                <br>
                                                <p>
                                                By following these tips, you'll be well on your way to creating a strong profile that will attract investors to
your business. We wish you the best of luck on your fundraising journey, and we look forward to seeing
your business grow with the support of our community.
                                                </p>
                                                <ul>
                                            <li>
                                                <span style="margin-right:5px"><input class="prices" amount="" onclick="$('#terns').hide();" type="checkbox"  value="1" /></span>                                                
                                                Please note that investment funds received through PitchInvestors should only be used for the intended purposes of the business, which may include expenses such as research and development, marketing, and the payment of salaries.<br> Any misuse of investment funds for personal use or other unauthorized purposes is a violation of our terms and conditions and may result in legal action. We take this matter seriously and will not hesitate to take legal action against any user found to be misusing investment funds. <br>Thank you for your understanding and cooperation in maintaining the integrity of the PitchInvestors platform.
                                            </li>                                        
                                            <li>
                                                <span style="margin-right:5px"><input class="prices" amount="" onclick="$('#terns').hide();" type="checkbox"  value="1" /></span>
                                                I confirm that the information provided in my business profile is accurate and up-to-date.
                                            </li>                                        
                                            <li>
                                                <span style="margin-right:5px"><input class="prices" amount="" onclick="$('#terns').hide();" type="checkbox"  value="1" /></span>
                                                <span>I understand that engaging in any outside deals or transactions outside of PitchInvestors will result in automatic disqualification and a ban from the platform.</span>
                                            </li>                                        
                                            <li>
                                            <span style="margin-right:5px"><input class="prices" amount="" onclick="$('#terns').hide();" type="checkbox"  value="1" /></span>
                                                I agree to cooperate and provide any necessary documentation or additional information requested during the due diligence process.
                                            </li>                                        
                                            <li>
                                                <span style="margin-right:5px"><input class="prices" amount="" onclick="$('#terns').hide();" type="checkbox"  value="1" /></span>
                                                I acknowledge that PitchInvestors reserves the right to conduct due diligence on my business to ensure its legitimacy and trustworthiness.
                                            </li>                                        
                                            <li>
                                                <span style="margin-right:5px"><input class="prices" amount="" onclick="$('#terns').hide();" type="checkbox"  value="1" /></span>
                                                I understand that the valuation report provided by PitchInvestors is an estimate and does not guarantee the actual value of my business.
                                            </li>                                        
                                            <li>
                                                <span style="margin-right:5px"><input class="prices" amount="" onclick="$('#terns').hide();" type="checkbox"  value="1" /></span>
                                                I agree to pay the specified fees for due diligence and valuation services if applicable.
                                            </li>
                                        </ul>
                                        <span id="terns" style="color:red; display:none">Please accept the investment use terms<br></span>
                                    </div>
                                    
                                </div>
                            </div>
                            
                                                    
                        </div>
                                
                          
                      </div>
                      <!-- investment tab end-->
                      <a style = "margin:20px;" href="javascript:void(0);" onclick="checkRules();"  id = "proceed_disable" class="btn btn-primary bg-blue">Proceed</a>
                      <!-- <a style = "margin:20px; display:none;" href="{{ url('/investment-add') }}"  id = "proceed" class="btn btn-primary bg-blue">Proceed</a> -->
                      
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
</section>
@endsection

<script type="text/javascript">

function checkRules()
{
  var rule_check = 1;
  $(".prices").each(function(){
      if (!$(this).is(":checked")) {
          rule_check = 0;
          }
        
			});
    if (rule_check == 0) {
        is_error = 1;
        $('#terns').show();
    } else {
        window.location.href = "{{ url('/investment-add') }}";
    }
}

// function checkTermsCondition(obj) {            
//   if ($(obj).is(":checked")) {
//             $("#proceed_disable").hide();  
//             $("#proceed").show();  
//   } else {
//     $("#proceed_disable").show();  
//       $("#proceed").hide();  
//   }
// }
</script>
