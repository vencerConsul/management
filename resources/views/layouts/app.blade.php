<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('/images/logo.png')}}">
    <link href="{{ asset('vendors/ti-icons/css/themify-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('css/vertical-layout-light/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    @auth
    <link href="{{ asset('vendors/feather/feather.css') }}" rel="stylesheet">
    @endauth
</head>
<body>
    @auth 
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- SIDEBAR -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar" data-aos="fade-right" data-aos-delay="100">
            <ul class="nav">
                <div class="profile align-self-center text-center">
                    <img src="{{Auth::user()->avatar_url}}" alt="profile" data-aos="fade-up" data-aos-delay="200"/>
                    <p class="my-2" data-aos="fade-up" data-aos-delay="300">{{Auth::user()->name}}</p>
                </div>
                <li class="nav-item" data-aos="fade-up" data-aos-delay="400">
                    <a class="nav-link" data-toggle="collapse" href="#__profile" aria-expanded="false" aria-controls="__profile">
                        <i class="ti-user menu-icon"></i>
                        <span class="menu-title">Manage Profile</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="__profile">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('information.create')}}">
                                    <i class="ti-link menu-icon"></i> Settings
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                    <i class="ti-power-off menu-icon text-primary"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </li>
                <hr class="hr-divider">
                <li class="nav-item @if(Route::currentRouteName() == 'dashboard') active @endif" data-aos="fade-up" data-aos-delay="500">
                    <a href="{{route('dashboard')}}" class="nav-link" href="index.html">
                        <i class="icon-grid menu-icon"></i>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </li>
                @if(Auth::user()->role == 1)
                <li class="nav-item" data-aos="fade-up" data-aos-delay="600">
                    <a class="nav-link" data-toggle="collapse" href="#manage__users" aria-expanded="false" aria-controls="manage__users">
                        <i class="ti-user menu-icon"></i>
                            <span class="menu-title">Manage Users</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="manage__users">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('users')}}"><i class="ti-link menu-icon"></i> All Users</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('archive')}}"><i class="ti-link menu-icon"></i> Archive Users</a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endif
                <li class="nav-item" data-aos="fade-up" data-aos-delay="700">
                <a class="nav-link" data-toggle="collapse" href="#__attendance" aria-expanded="false" aria-controls="__attendance">
                    <i class="icon-columns menu-icon"></i>
                    <span class="menu-title">Attendance</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="__attendance">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('attendance')}}"><i class="ti-link menu-icon"></i> My Attendance</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('attendance.logs')}}"><i class="ti-link menu-icon"></i> Attendance Logs</a>
                        </li>
                    </ul>
                </div>
                </li>
                <li class="nav-item" data-aos="fade-up" data-aos-delay="800">
                    <a class="nav-link" data-toggle="collapse" href="#__timesheet" aria-expanded="false" aria-controls="__timesheet">
                        <i class="ti-alarm-clock menu-icon"></i>
                        <span class="menu-title">Timesheet</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="__timesheet">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="pages/charts/chartjs.html"><i class="ti-link menu-icon"></i> Logs</a></li>
                            <li class="nav-item"> <a class="nav-link" href="pages/charts/chartjs.html"><i class="ti-link menu-icon"></i> Reports</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item" data-aos="fade-up" data-aos-delay="900">
                    <a class="nav-link" href="pages/documentation/documentation.html">
                      <i class="icon-paper menu-icon"></i>
                      <span class="menu-title">Documentation</span>
                    </a>
                </li>
            </ul>
            </nav>

            <!-- partial -->
            <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
                <div class="container">
                    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                        <a class="navbar-brand brand-logo mr-5" href="index.html"><img src="{{asset('/images/logo.png')}}" class="mr-2" alt="logo"/></a>
                        <a class="navbar-brand brand-logo-mini" href="index.html"><img src="{{asset('/images/logo.png')}}" alt="logo"/></a>
                    </div>
                    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                        
                    <i class="ti-align-justify navbar-toggler navbar-toggler-right d-lg-none align-self-center" data-toggle="offcanvas"></i>
                    </div>
                </div>
            </nav>
            <div class="main-panel">
                @yield('content')
            </div>
            <!-- end partial -->
        </div>
    </div>
    @else 
        @yield('content')
    @endauth
    
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('vendors/js/vendor.bundle.base.js') }}" defer></script>
    <script src="{{ asset('js/off-canvas.js') }}" defer></script>
    <script src="{{ asset('js/hoverable-collapse.js') }}" defer></script>
    <script src="{{ asset('js/template.js') }}" defer></script>
    <script src="{{ asset('js/settings.js') }}" defer></script>
    <script src="{{ asset('js/todolist.js') }}" defer></script>
    @auth
    <script src="{{ asset('vendors/chart.js/Chart.min.js') }}" defer></script>
    <script src="{{ asset('vendors/datatables.net/jquery.dataTables.js') }}" defer></script>
    <script src="{{ asset('vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}" defer></script>
    <script src="{{ asset('js/dataTables.select.min.js') }}" defer></script>
    <script src="{{ asset('js/dashboard.js') }}" defer></script>
    <script src="{{ asset('js/Chart.roundedBarCharts.js') }}" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.3.2/axios.min.js"></script>
    @yield('scripts')
        @if(\Route::currentRouteName() == 'dashboard')
            <script src="{{ asset('js/weather.js') }}" defer></script>
        @endif
        <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
        <script>
            AOS.init();
        </script>
    @endauth
    @include('layouts.alert')
</body>
</html>
