@extends('layouts.main-site')

@push('styles')
    <!-- Animation CSS -->
    <link rel="stylesheet" href="/assets/css/animate.css"> 
    <!-- Latest Bootstrap min CSS -->
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Kaushan+Script&amp;display=swap" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:100,100i,300,300i,400,400i,600,600i,700,700i&amp;display=swap" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i&amp;display=swap" rel="stylesheet"> 
    <!-- Icon Font CSS -->
    <link rel="stylesheet" href="/assets/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/ionicons.min.css">
    <link rel="stylesheet" href="/assets/css/themify-icons.css">
    <link rel="stylesheet" href="/assets/css/linearicons.css">
    <link rel="stylesheet" href="/assets/css/flaticon.css">
    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" href="/assets/owlcarousel/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/assets/owlcarousel/css/owl.theme.css">
    <link rel="stylesheet" href="/assets/owlcarousel/css/owl.theme.default.min.css">
    <!-- Slick CSS -->
    <link rel="stylesheet" href="/assets/css/slick.css">
    <link rel="stylesheet" href="/assets/css/slick-theme.css">
    <!-- Magnific Popup CSS -->
    <link rel="stylesheet" href="/assets/css/magnific-popup.css">
    <!-- DatePicker CSS -->
    <link href="/assets/css/datepicker.min.css" rel="stylesheet">
    <!-- TimePicker CSS -->
    <link href="/assets/css/mdtimepicker.min.css" rel="stylesheet">
    <!-- Style CSS -->
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/responsive.css">
    <link id="layoutstyle" rel="stylesheet" href="/assets/color/theme-red.css">
@endpush

@push('scripts')
    <!-- Latest jQuery --> 
    <script src="/assets/js/jquery-1.12.4.min.js"></script> 
    <!-- Latest compiled and minified Bootstrap --> 
    <script src="/assets/bootstrap/js/bootstrap.min.js"></script> 
    <!-- Owl Carousel min js  --> 
    <script src="/assets/owlcarousel/js/owl.carousel.min.js"></script> 
    <!-- Magnific Popup min js  --> 
    <script src="/assets/js/magnific-popup.min.js"></script> 
    <!-- Waypoints min js  --> 
    <script src="/assets/js/waypoints.min.js"></script> 
    <!-- Parallax js  --> 
    <script src="/assets/js/parallax.js"></script> 
    <!-- Countdown js  --> 
    <script src="/assets/js/jquery.countdown.min.js"></script> 
    <!-- jQuery CountTo js  -->
    <script src="/assets/js/jquery.countTo.js"></script>
    <!-- ImagesLoaded js --> 
    <script src="/assets/js/imagesloaded.pkgd.min.js"></script>
    <!-- Isotope min js --> 
    <script src="/assets/js/isotope.min.js"></script>
    <!-- jQuery Appear js  -->
    <script src="/assets/js/jquery.appear.js"></script>
    <!-- jQuery DD min js -->
    <script src="/assets/js/jquery.dd.min.js"></script>
    <!-- Slick js -->
    <script src="/assets/js/slick.min.js"></script>
    <!-- DatePicker js -->
    <script src="/assets/js/datepicker.min.js"></script>
    <!-- TimePicker js -->
    <script src="/assets/js/mdtimepicker.min.js"></script>
    <!-- Scripts js --> 
    <script src="/assets/js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@endpush

@section('title', 'Payment Cancelled')

@section('header')
    <!-- START HEADER -->
    <header class="header_wrap fixed-top header_with_topbar light_skin main_menu_uppercase">
        <div class="container">
            @include('partials.nav')
        </div>
    </header>
    <!-- END HEADER -->
@endsection

@section('content')
    <!-- START SECTION BREADCRUMB -->
    <div class="breadcrumb_section background_bg overlay_bg_50 page_title_light" data-img-src="/assets/images/about_bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title text-center">
                        <h1>Payment Cancelled</h1>
                    </div>
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Payment Cancelled</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- END SECTION BREADCRUMB -->

    <!-- START SECTION CANCELLATION -->
    <div class="section">
        <div class="container">
          <div class="alert alert-default text-center">
            <hr>
            <img src="/assets/images/cancelled.png" alt="Payment Cancelled" style="width:20%" class="img-fluid rounded my-3">
            <p>We noticed that your payment was not successful. If this was a mistake, you can try placing your order again.</p>
            <p>If you have any questions or need assistance, please contact us at 
                @if($firstRestaurantPhoneNumber)
                    <a href="tel:{{ $firstRestaurantPhoneNumber->phone_number }}">{{ $firstRestaurantPhoneNumber->phone_number }}</a>
                @endif
                or email us at 
                <a href="mailto:{{ config('site.email') }}">{{ config('site.email') }}</a>.
            </p>
            <hr>
            <a href="{{ route('menu') }}" class="btn btn-danger">Return to Menu</a>
        </div>
        
        
        </div>
    </div>
    <!-- END SECTION CANCELLATION -->
@endsection
