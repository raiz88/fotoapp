<!DOCTYPE html>
<html lang="en" data-layout="twocolumn" data-sidebar="light" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>
    <meta charset="utf-8" />
    <title>@yield('title', 'Fotographer') | Booking Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta content="Fotographer Booking Management" name="description" />
    <link rel="shortcut icon" href="{{ asset('velzon/assets/images/favicon.ico') }}" />
    <script src="{{ asset('velzon/assets/js/layout.js') }}"></script>
    <link href="{{ asset('velzon/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('velzon/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('velzon/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('velzon/assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
    @stack('css')
</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <header id="page-topbar">
            <div class="layout-width">
                <div class="navbar-header">
                    <div class="d-flex">
                        <div class="navbar-brand-box horizontal-logo">
                            <a href="{{ route('bookings.index') }}" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="{{ asset('velzon/assets/images/logo-sm.png') }}" alt="" height="22">
                                </span>
                                <span class="logo-lg">
                                    <img src="{{ asset('velzon/assets/images/logo-dark.png') }}" alt="" height="17">
                                </span>
                            </a>
                        </div>
                        <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                            <span class="hamburger-icon">
                                <span></span><span></span><span></span>
                            </span>
                        </button>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="dropdown d-inline-block ms-2">
                            <button type="button" class="btn header-item" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="ri-user-3-line fs-18"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#"><i class="ri-user-line align-bottom me-1"></i> Profile</a>
                                <a class="dropdown-item" href="#"><i class="ri-logout-box-line align-bottom me-1"></i> Logout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- ========== App Menu ========== -->
        <div class="app-menu navbar-menu">
            <div class="navbar-brand-box">
                <a href="{{ route('bookings.index') }}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('velzon/assets/images/logo-sm.png') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('velzon/assets/images/logo-dark.png') }}" alt="" height="17">
                    </span>
                </a>
            </div>
            <div class="scrollbar">
                <ul class="menu-nav">
                    <li class="menu-title">MENU</li>
                    <li class="menu-item">
                        <a href="{{ route('bookings.index') }}" class="menu-link">
                            <i class="ri-calendar-check-line"></i>
                            <span class="menu-text">Booking List</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('bookings.calendar') }}" class="menu-link">
                            <i class="ri-calendar-2-line"></i>
                            <span class="menu-text">Calendar</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('bookings.create') }}" class="menu-link">
                            <i class="ri-add-circle-line"></i>
                            <span class="menu-text">New Booking</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="sidebar-background"></div>
        </div>
        <!-- Left Sidebar End -->

        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="ri-check-double-line me-2 align-middle"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @yield('content')

                </div>
            </div>

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>document.write(new Date().getFullYear())</script> © Fotographer.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Velzon Theme
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Vendor Scripts -->
    <script src="{{ asset('velzon/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('velzon/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('velzon/assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('velzon/assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('velzon/assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('velzon/assets/js/plugins.js') }}"></script>
    <script src="{{ asset('velzon/assets/js/app.js') }}"></script>
    @stack('scripts')

</body>
</html>
