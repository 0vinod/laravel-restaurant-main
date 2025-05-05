<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token Meta for AJAX Calls -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    @stack('styles')
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <link rel="stylesheet" href="{{ asset('admin_resources/css/typicons.css') }}">
    <link rel="stylesheet" href="/admin_resources/vendors/typicons.font/font/typicons.css">
    <link rel="stylesheet" href="/admin_resources/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="/admin_resources/css/vertical-layout-light/style.css">
    <link rel="stylesheet" href="/assets/css/toast.css">

    <!-- Add Font Awesome if you're using its icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="/favicon_io/favicon.ico" />
</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <a class="navbar-brand brand-logo" href="{{ route('admin.index') }}"><img
                        src="/assets/images/logo_dashboard.png" alt="logo" /></a>
                <a class="navbar-brand brand-logo-mini" href="{{ route('admin.index') }}"><img
                        src="/admin_resources/images/logo-mini.svg" alt="logo" /></a>
                <button class="navbar-toggler navbar-toggler align-self-center d-none d-lg-flex" type="button"
                    data-toggle="minimize">
                    <span class="typcn typcn-th-menu"></span>
                </button>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">

                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item d-none d-lg-flex  mr-2"> <a class="nav-link"
                            href="{{ route('admin.view.myprofile') }}"> <i class="typcn typcn-user-outline mr-0"></i>
                            {{ $loggedInUser->first_name }} </a> </li>
                    <li class="nav-item d-none d-lg-flex  mr-2"> <a class="nav-link" href="{{ route('admin.logout') }}">
                            <i class="typcn typcn-power-outline mr-0"></i> Logout </a> </li>
                </ul>

                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                    data-toggle="offcanvas">
                    <span class="typcn typcn-th-menu"></span>
                </button>
            </div>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">


            @include('partials.admin.sidebar')

            @yield('content')

            @include('partials.logout')

        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    <script src="/admin_resources/vendors/js/vendor.bundle.base.js"></script>
    <script src="/admin_resources/js/off-canvas.js"></script>
    <script src="/admin_resources/js/hoverable-collapse.js"></script>
    <script src="/admin_resources/js/template.js"></script>
    <script src="/admin_resources/js/settings.js"></script>
    <script src="/admin_resources/js/todolist.js"></script>

    <!-- Plugin JS -->
    <script src="/admin_resources/vendors/progressbar.js/progressbar.min.js"></script>
    <script src="/admin_resources/vendors/chart.js/Chart.min.js"></script>
    <script src="/admin_resources/js/dashboard.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/toast.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    

    <script>
        function success(msg) {
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": true,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "3000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
            toastr.success(msg);
        }

        function error(msg) {
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": true,
                "showDuration": "300",
                "hideDuration": "2000",
                "timeOut": "3000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
            toastr.error(msg)
        }
    </script>
    @stack('scripts')

    <x-message />
</body>

</html>