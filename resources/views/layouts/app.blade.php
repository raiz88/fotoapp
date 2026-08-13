<!DOCTYPE html>
<html lang="en" data-layout="twocolumn" data-sidebar="light" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>
    <meta charset="utf-8" />
    <title>@yield('title', 'Fotographer') | Booking Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta content="Fotographer Booking Management" name="description" />
    <link rel="shortcut icon" href="{{ asset('velzon/assets/images/favicon.ico') }}" />
    <script src="{{ asset('velzon/assets/js/layout.js') }}"></script>
    <script>
        (function () {
            const browserTheme = window.matchMedia('(prefers-color-scheme: dark)');
            const applyTheme = (theme) => {
                const dark = theme === 'dark' || (theme === 'system' && browserTheme.matches);
                document.documentElement.setAttribute('data-layout-mode', dark ? 'dark' : 'light');
                document.documentElement.setAttribute('data-sidebar', dark ? 'dark' : 'light');
                document.documentElement.setAttribute('data-topbar', dark ? 'dark' : 'light');
            };
            window.fotographerTheme = localStorage.getItem('fotographer-theme') || 'system';
            applyTheme(window.fotographerTheme);
            browserTheme.addEventListener?.('change', () => {
                if (window.fotographerTheme === 'system') applyTheme('system');
            });
            window.applyFotographerTheme = (theme) => {
                window.fotographerTheme = theme;
                localStorage.setItem('fotographer-theme', theme);
                applyTheme(theme);
            };
        })();
    </script>
    <link href="{{ asset('velzon/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('velzon/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('velzon/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('velzon/assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .fotographer-brand { color: var(--vz-heading-color); font-size: 16px; font-weight: 700; letter-spacing: .01em; text-decoration: none; }
        .fotographer-brand small { color: var(--vz-secondary-color); font-size: 9px; font-weight: 500; letter-spacing: .16em; margin-left: 6px; text-transform: uppercase; }
        [data-layout-mode="dark"] .fotographer-brand { color: #fff; }
        .fotographer-brand:hover { color: var(--vz-primary); }
        .theme-picker { position:fixed; left:18px; bottom:18px; z-index:1100; }
        .theme-picker-toggle { width:40px; height:40px; border:1px solid var(--vz-border-color); border-radius:50%; color:var(--vz-body-color); background:var(--vz-card-bg-custom); box-shadow:0 4px 16px rgba(30,32,37,.14); cursor:pointer; transition:all .2s; }
        .theme-picker-toggle:hover { color:var(--vz-primary); transform:translateY(-2px); }
        .theme-picker-menu { display:none; position:absolute; left:0; bottom:49px; width:145px; padding:6px; border:1px solid var(--vz-border-color); border-radius:9px; background:var(--vz-card-bg-custom); box-shadow:0 8px 24px rgba(30,32,37,.16); }
        .theme-picker.open .theme-picker-menu { display:block; }
        .theme-option { display:flex; align-items:center; gap:8px; width:100%; border:0; border-radius:6px; padding:8px 10px; color:var(--vz-body-color); background:transparent; font-size:13px; text-align:left; cursor:pointer; }
        .theme-option:hover, .theme-option.active { color:var(--vz-primary); background:var(--vz-light); }
        .app-primary-nav { display:flex; align-items:center; gap:22px; margin-left:28px; font-size:12px; text-transform:uppercase; letter-spacing:.06em; }
        .app-primary-nav a { color:var(--vz-body-color); text-decoration:none; opacity:.72; transition:all .2s; }
        .app-primary-nav a:hover, .app-primary-nav a.active { color:var(--vz-primary); opacity:1; }
        .app-primary-nav .app-nav-cta { color:#fff; opacity:1; background:var(--vz-primary); padding:9px 14px; border-radius:999px; }
        [data-layout-mode="dark"] .app-primary-nav .app-nav-cta { color:#10131a; }
        @media (max-width: 900px) { .app-primary-nav { display:none; } }
    </style>
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
                            <a href="{{ url('/') }}" class="fotographer-brand">
                                LENS & LIGHT <small>fotographer</small>
                            </a>
                        </div>
                        <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                            <span class="hamburger-icon">
                                <span></span><span></span><span></span>
                            </span>
                        </button>
                    </div>
                    <div class="d-flex align-items-center">
                        <nav class="app-primary-nav" aria-label="Primary navigation">
                            <a href="{{ url('/') }}">Home</a>
                            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
                            <a href="{{ route('bookings.calendar') }}" class="{{ request()->routeIs('bookings.calendar') ? 'active' : '' }}">Calendar</a>
                            <a href="{{ route('bookings.index') }}" class="{{ request()->routeIs('bookings.index') ? 'active' : '' }}">Booking List</a>
                            <a href="{{ route('bookings.create') }}" class="app-nav-cta">New Booking <i class="ri-arrow-right-up-line align-middle"></i></a>
                        </nav>
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
                <a href="{{ url('/') }}" class="fotographer-brand">
                    LENS & LIGHT <small>fotographer</small>
                </a>
            </div>
            <div class="scrollbar">
                <ul class="menu-nav">
                    <li class="menu-title">STUDIO</li>
                    <li class="menu-item">
                        <a href="{{ route('dashboard') }}" class="menu-link">
                            <i class="ri-dashboard-2-line"></i>
                            <span class="menu-text">Dashboard</span>
                        </a>
                    </li>
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

    <div class="theme-picker" id="theme-picker">
        <div class="theme-picker-menu" role="menu" aria-label="Theme options">
            <button class="theme-option" data-theme="system" type="button"><i class="ri-computer-line"></i> System</button>
            <button class="theme-option" data-theme="light" type="button"><i class="ri-sun-line"></i> Light</button>
            <button class="theme-option" data-theme="dark" type="button"><i class="ri-moon-line"></i> Dark</button>
        </div>
        <button class="theme-picker-toggle" id="theme-picker-toggle" type="button" aria-label="Change theme" aria-expanded="false"><i class="ri-contrast-2-line"></i></button>
    </div>

    <!-- Vendor Scripts -->
    <script src="{{ asset('velzon/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('velzon/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('velzon/assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('velzon/assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('velzon/assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('velzon/assets/js/plugins.js') }}"></script>
    <script src="{{ asset('velzon/assets/js/app.js') }}"></script>
    <script>
        (function () {
            const picker = document.getElementById('theme-picker');
            const toggle = document.getElementById('theme-picker-toggle');
            const options = document.querySelectorAll('.theme-option');
            const refreshActive = () => options.forEach(option => option.classList.toggle('active', option.dataset.theme === window.fotographerTheme));
            toggle.addEventListener('click', () => {
                const open = picker.classList.toggle('open');
                toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
                refreshActive();
            });
            options.forEach(option => option.addEventListener('click', () => {
                window.applyFotographerTheme(option.dataset.theme);
                refreshActive();
                picker.classList.remove('open');
                toggle.setAttribute('aria-expanded', 'false');
            }));
            document.addEventListener('click', event => {
                if (!picker.contains(event.target)) picker.classList.remove('open');
            });
        })();
    </script>
    @stack('scripts')

</body>
</html>
