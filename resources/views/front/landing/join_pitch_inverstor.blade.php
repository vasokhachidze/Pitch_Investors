<!DOCTYPE html>
<html lang="en">

<head>
    <!-- ========== Meta Tags ========== -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="pitch-investors is a one-stop solution for entrepreneurs and business">

    <!-- ========== Page Title ========== -->
    <title>Pitch Investor</title>

    <!-- ========== Favicon Icon ========== -->
    <link rel="shortcut icon" href="{{asset('landing-assets/img/favicon.png')}}" type="image/x-icon">

    <!-- ========== Start Stylesheet ========== -->
        <link href="{{asset('landing-assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('landing-assets/css/themify-icons.css')}}" rel="stylesheet">
    <link href="{{asset('landing-assets/css/flaticon-set.css')}}" rel="stylesheet">
    <link href="{{asset('landing-assets/css/elegant-icons.css')}}" rel="stylesheet">
    <link href="{{asset('landing-assets/css/magnific-popup.css')}}" rel="stylesheet">
    <link href="{{asset('landing-assets/css/owl.carousel.min.css')}}" rel="stylesheet">
    <link href="{{asset('landing-assets/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('landing-assets/css/bootsnav.css')}}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="{{asset('landing-assets/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('landing-assets/css/responsive.css')}}" rel="stylesheet">
 
    <!-- ========== End Stylesheet ========== -->
</head>

<body>

    <!-- Preloader Start -->
    <div class="se-pre-con"></div>
    <!-- Preloader Ends -->

      <!-- Header 
    ============================================= -->
    <header id="home">

        <!-- Start Navigation -->
        <nav class="navbar navbar-default attr-bg navbar-fixed dark no-background bootsnav">

            <!-- Start Top Search -->
            <div class="container">
                <div class="row">
                    <div class="top-search">
                        <div class="input-group">
                            <form action="#">
                                <input type="text" name="text" class="form-control" placeholder="Search">
                                <button type="submit">
                                    <i class="ti-search"></i>
                                </button>  
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Top Search -->

            <div class="container">

                <!-- Start Atribute Navigation -->
                <div class="attr-nav inc-border">
                    <ul>
                        <li class="search"><a href="#"><i class="fas fa-search"></i></a></li>
                    </ul>
                </div>        
                <!-- End Atribute Navigation -->

                <!-- Start Header Navigation -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                        <i class="fa fa-bars"></i>
                    </button>
                    <a class="navbar-brand" href="{{url('/')}}">
                        <img src="{{asset('landing-assets/img/logo.png')}}" class="logo" alt="Logo">
                    </a>
                </div>
                <!-- End Header Navigation -->

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="navbar-menu">
                    <ul class="nav navbar-nav navbar-right" data-in="fadeInDown" data-out="fadeOutUp">
                        <li><a href="{{url('/')}}">Home</a></li>
                        <li><a href="{{url('/investment')}}">Businesses</a></li>
                        <li><a href="{{url('/advisor')}}">Advisors</a></li>
                        <li><a href="{{url('/investor')}}">Investors</a></li>
                        <li><a href="{{url('/about-us')}}">About Us</a></li>
                        <li><a href="{{url('/contact_us')}}">Contact Us</a></li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div>

        </nav>
        <!-- End Navigation -->

    </header>
    <!-- End Header -->


   

<!-- Start Banner 
    ============================================= -->
    <div id="home" class="banner-area content-bg circle-shape">
        <!-- Background -->
        <div class="bg" style="background-image: url({{asset('landing-assets/img/banner.jpg')}}"></div>
        <!-- End Background -->
        <div class="item">
            <div class="container">
                <div class="row align-center">
                                    
                    <div class="col-lg-7 offset-lg-5">
                        <div class="content">
                            <h4 class="wow fadeInUp">Get The Investment</h4>
                            <h2 class="wow fadeInDown">Your Business Deserves <strong>With PitchInvestors</strong></h2>
                            <p class="wow fadeInLeft">
                                Are you an entrepreneur with a new startup idea, or an established business looking to expand? 
                            </p>
                            <a href="{{url('/register')}}" class="btn-animate wow fadeInRight">
                                <span class="circle">
                                  <span class="icon arrow"></span>
                                </span>
                                <span class="button-text">Get started</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Banner -->

  <!-- Start Why Choose Us 
    ============================================= -->
    <div id="why-choose-us" class="choose-us-area overflow-hidden reverse default-padding">
        <div class="container">
            <div class="row align-center">
                
                <div class="col-lg-6 info wow fadeInUp">
                    <h5>Why Choose Us</h5>
                    <h2 class="area-title">Add Your Business Now</h2>
                    <p> Are you an entrepreneur with a new startup idea, or an established business
                        looking to expand? PitchInvestors is the platform for you. We connect business owners with potential
                        investors, providing a space where you can showcase your business and pitch your ideas to a community
                        of investors who are looking for new investment opportunities.</p>
                    <ul>
                        <li>Experts around  the world</li>
                        <li>Best Practice for industry</li>
                    </ul>
                    <div class="contact">
                        <a class="btn-gradient" href="{{url('/register')}}">Sign Up</a>
                        <h4><i class="fas fa-phone"></i> +123 456 7890</h4>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="thumb wow fadeInRight" data-wow-delay="0.6s">
                        <img src="{{asset('landing-assets/img/illustration/1.png')}}" alt="Thumb">
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- End Why Choose Us Area -->

 <!-- Star Work Process Area
    ============================================= -->
    <div id="features" class="work-process-area bg-gray">
        <!-- Shape -->
        <div class="fixed-shape">
            <img src="{{asset('landing-assets/img/shape/12.png')}}" alt="Shape">
        </div>
        <!-- End Shape -->
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="site-heading text-center">
                        <h5>FEATURES</h5>
                        <h2 class="area-title">How we help of your business <br> Grow and successful</h2>
                       
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="process-items">
                <div class="row">
                    <!-- Single Item -->
                    <div class="single-item col-lg-3 col-md-6 col-lg-6">
                        <div class="item">
                            <div class="top">
                                <span>01</span>
                                <i class="flaticon-select"></i>
                            </div>
                            <h5>Wider Audience</h5>
                            <p>Reach a wider audience of investors.</p>
                        </div>
                    </div>
                    <!-- End Single Item -->
                    <!-- Single Item -->
                    <div class="single-item col-lg-3 col-md-6 col-lg-6">
                        <div class="item">
                            <h5>Securing Investment</h5>
                            <p>Increase your chances of securing investment.</p>
                            <div class="top">
                                <span>02</span>
                                <i class="flaticon-video-call"></i>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Item -->
                    <!-- Single Item -->
                    <div class="single-item col-lg-3 col-md-6 col-lg-6">
                        <div class="item">
                            <div class="top">
                                <span>03</span>
                                <i class="flaticon-strategy"></i>
                            </div>
                            <h5>Investors Feedback</h5>
                            <p>Get feedback from investors to improve your pitch.</p>
                        </div>
                    </div>
                    <!-- End Single Item -->
                    <!-- Single Item -->
                    <div class="single-item col-lg-3 col-md-6 col-lg-6">
                        <div class="item">
                            <h5>Valuable Resources</h5>
                            <p>Access valuable resources and tools to help you refine your pitch and communicate the potential of your business to investors.</p>
                            <div class="top">
                                <span>04</span>
                                <i class="flaticon-solution"></i>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Item -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Work Process Area -->
    <!-- Start Testimonials Area 
    ============================================= -->
    <div id="testimonials" class="testimonials-area carousel-shadow default-padding">
        <div class="container">
            <div class="heading-left">
                <div class="row">
                    <div class="col-lg-6">
                        <h5>Our Client's Review </h5>
                        <h2>
                            What client say about us?
                        </h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="testimonials-carousel owl-carousel owl-theme">
                        <!-- Single Item -->
                        <div class="item">
                            <div class="thumb">
                                <img src="{{asset('landing-assets/img/profile.png')}}" alt="Thumb">
                                <i class="fas fa-quote-right"></i>
                            </div>
                            <div class="info">
                                <p>I am a new user of Pitch-Investors but I am so glad that I took the step to reach out to them. Pitch-Investors gave me the best independent advice on my investment strategy. I am able to monitor the performance, switch funds and add to the investment with little or no hassle. I have a good feeling about investing through Pitch-Investors platform.</p>
                                <div class="bottom">
                                    <div class="provider">
                                        <h5>Hanna K.</h5>
                                    </div>
                                    <div class="raging">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Single Item -->
                        <!-- Single Item -->
                        <div class="item">
                            <div class="thumb">
                                <img src="{{asset('landing-assets/img/profile.png')}}" alt="Thumb">
                                <i class="fas fa-quote-right"></i>
                            </div>
                            <div class="info">
                                <p>Pitch-Investors have an outstanding analysis of the creditworthiness of a diverse range of investments The assistance provided by my investment advisor was phenomenal. Her recommendations to diversify into other asset classes have proved fruitful in recent years with the rebound of the stock market. I consider her advice and counsel very valuable and have recommended her services to friends.
                                </p>
                                <div class="bottom">
                                    <div class="provider">
                                        <h5>Wanjiku K. Kamau</h5>
                                        
                                    </div>
                                    <div class="raging">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Single Item -->
                        <!-- Single Item -->
                        <div class="item">
                            <div class="thumb">
                                <img src="{{asset('landing-assets/img/profile.png')}}" alt="Thumb">
                                <i class="fas fa-quote-right"></i>
                            </div>
                            <div class="info">
                                <p> Pitch-Investor has been a key partner in our success, and an invaluable asset for the growth and future of our company. The platform has made it possible for us to extend our business so more Kenyans to enjoy great hospitality services. I fully recommend this platform as a resource to get funding from venture capitalists from all over the world.
                                </p>
                                <div class="bottom">
                                    <div class="provider">
                                        <h5>Fransis Baraza</h5>
                                    </div>
                                    <div class="raging">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Single Item -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Testimonials Area -->
    <!-- Star Faq
    ============================================= -->
    <div id="faq" class="faq-area overflow-hidden rectangular-shape">
        <div class="container">
            <div class="faq-items">
                <div class="row">

                    <div class="col-lg-6">
                        <div class="thumb wow fadeInLeft" data-wow-delay="0.5s">
                            <img src="{{asset('landing-assets/img/illustration/4.png')}}" alt="Thumb">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="faq-content">
                            <h5>faq</h5>
                            <h2 class="area-title">Most common question about our services</h2>
                            <div class="accordion" id="accordionExample">
                                <div class="card">
                                    <div class="card-header" id="headingOne">
                                        <h4 class="mb-0" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            What types of businesses are eligible to join PitchInvestors?
                                        </h4>
                                    </div>

                                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <p>
                                                We welcome businesses of all sizes and stages, from early-stage startups to established companies.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="headingTwo">
                                        <h4 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            How does PitchInvestors help me secure investment?
                                        </h4>
                                    </div>
                                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <p>
                                                PitchInvestors provides a platform for you to showcase your business and pitch your ideas to potential investors. Our community of investors is actively looking for new investment opportunities, making it easier for you to connect with the right investors for your business.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="headingThree">
                                        <h4 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            How much does it cost to join PitchInvestors?
                                      </h4>
                                    </div>
                                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <p>It's free to add your business to PitchInvestors. We only charge a small fee if you successfully secure investment through our platform.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="headingFour">
                                        <h4 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                            What resources and tools does PitchInvestors provide to help me refine my pitch?
                                      </h4>
                                    </div>
                                    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <p>We provide a range of resources and tools, including pitch templates, investor feedback, and access to a community of fellow entrepreneurs who can provide support and advice.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <!-- End Faq -->

    <!-- Start Footer 
    ============================================= -->
    <footer class="bg-dark text-light mt-5">
        <!-- Fixed Shape -->
        <div class="fixed-shape">
            <img src="{{asset('landing-assets/img/shape/bg-3.png')}}" alt="Shape">
        </div>
        <!-- Fixed Shape -->

        <!-- Footer Top -->
        <div class="footer-top">
            <div class="container">
                <div class="footer-top-content">
                    <div class="row align-center">
                        <div class="col-lg-7">
                            <ul>
                                <li><a href="#">Membership</a></li>
                                <li><a href="#">Support</a></li>
                                <li><a href="{{url('terms-condition')}}">Terms</a></li>
                                <li><a href="{{url('contact_us')}}">Contact</a></li>
                            </ul>
                        </div>
                        <div class="col-lg-5">
                            <form action="#">
                                <input type="email" placeholder="Your Email" class="form-control" name="email">
                                <button type="submit"> <i class="fa fa-paper-plane"></i></button>  
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Footer Top -->
        <div class="container">
            <div class="f-items">
                <div class="row">
                    <div class="col-md-6 offset-md-3 item">
                        <div class="f-item about">
                            <img src="{{asset('landing-assets/img/logo-light.png')}}" alt="Logo">
                            <p>
                                Happen active county. Winding for the morning am shyness evident to poor. Garrets because elderly new. 
                            </p>
                            <div class="social">
                                <ul>
                                    <li>
                                        <a href="#">
                                            <i class="fab fa-facebook-f"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fab fa-twitter"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fab fa-linkedin-in"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fab fa-instagram"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                  
                   

                   
                </div>
            </div>
        </div>
        <!-- Start Footer Bottom -->
        <div class="footer-bottom text-center">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <p>Copyright &copy;  2021. PitchInvestors</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Footer Bottom -->
    </footer>
    <!-- End Footer -->

    <!-- jQuery Frameworks
    ============================================= -->
    <script src="{{asset('landing-assets/js/jquery-1.12.4.min.js')}}"></script>    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>        
    <script src="{{asset('landing-assets/js/bootstrap.min.js')}}"></script>    
    <script src="{{asset('landing-assets/js/popper.min.js')}}"></script>    
    <script src="{{asset('landing-assets/js/jquery.appear.js')}}"></script>
    <script src="{{asset('landing-assets/js/jquery.easing.min.js')}}"></script>
    <script src="{{asset('landing-assets/js/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{asset('landing-assets/js/modernizr.custom.13711.js')}}"></script>
    <script src="{{asset('landing-assets/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('landing-assets/js/wow.min.js')}}"></script>
    <script src="{{asset('landing-assets/js/progress-bar.min.js')}}"></script>
    <script src="{{asset('landing-assets/js/isotope.pkgd.min.js')}}"></script>
    <script src="{{asset('landing-assets/js/imagesloaded.pkgd.min.js')}}"></script>
    <script src="{{asset('landing-assets/js/count-to.js')}}"></script>
    <script src="{{asset('landing-assets/js/jquery.backgroundMove.js')}}"></script>
    <script src="{{asset('landing-assets/js/YTPlayer.min.js')}}"></script>
    <script src="{{asset('landing-assets/js/jquery.nice-select.min.js')}}"></script>
    <script src="{{asset('landing-assets/js/bootsnav.js')}}"></script>
    <script src="{{asset('landing-assets/js/main.js')}}"></script>
    
</body>
</html>