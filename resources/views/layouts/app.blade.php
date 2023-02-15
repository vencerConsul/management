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
    @auth
    <link href="{{ asset('vendors/feather/feather.css') }}" rel="stylesheet">
    @endauth
</head>
<body>
    @auth 
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <a class="navbar-brand brand-logo mr-5" href="index.html"><img src="{{asset('/images/logo.png')}}" class="mr-2" alt="logo"/></a>
                <a class="navbar-brand brand-logo-mini" href="index.html"><img src="{{asset('/images/logo.png')}}" alt="logo"/></a>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                <i class="ti-align-justify navbar-toggler navbar-toggler align-self-center" data-toggle="minimize"></i>
            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                    <img src="{{Auth::user()->avatar_url}}" alt="profile"/>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                    <a href="{{route('information.create')}}" class="dropdown-item">
                        <i class="ti-settings text-primary"></i>
                        Settings
                    </a>
                    <a class="dropdown-item" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <i class="ti-power-off text-primary"></i>
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
                </li>
            </ul>
            <i class="ti-align-justify navbar-toggler navbar-toggler-right d-lg-none align-self-center" data-toggle="offcanvas"></i>
            </div>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- SIDEBAR -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <ul class="nav">
                <div class="profile align-self-center text-center">
                    <img src="{{Auth::user()->avatar_url}}" alt="profile"/>
                    <p class="my-2">{{Auth::user()->name}}</p>
                </div>
                <li class="nav-item">
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
                <li class="nav-item @if(Route::currentRouteName() == 'dashboard') active @endif">
                    <a href="{{route('dashboard')}}" class="nav-link" href="index.html">
                        <i class="icon-grid menu-icon"></i>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </li>
                @if(Auth::user()->role == 1)
                <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                        <i class="ti-user menu-icon"></i>
                            <span class="menu-title">Manage Users</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="ui-basic">
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
                <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
                    <i class="icon-columns menu-icon"></i>
                    <span class="menu-title">Attendance</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="form-elements">
                    <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="pages/forms/basic_elements.html"><i class="ti-link menu-icon"></i> User Logs</a></li>
                    </ul>
                </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts">
                        <i class="ti-alarm-clock menu-icon"></i>
                        <span class="menu-title">Timesheet</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="charts">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="pages/charts/chartjs.html"><i class="ti-link menu-icon"></i> Logs</a></li>
                            <li class="nav-item"> <a class="nav-link" href="pages/charts/chartjs.html"><i class="ti-link menu-icon"></i> Reports</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pages/documentation/documentation.html">
                      <i class="icon-paper menu-icon"></i>
                      <span class="menu-title">Documentation</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pages/documentation/documentation.html">
                      <i class="icon-paper menu-icon"></i>
                      <span class="menu-title">Documentation</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pages/documentation/documentation.html">
                      <i class="icon-paper menu-icon"></i>
                      <span class="menu-title">Documentation</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pages/documentation/documentation.html">
                      <i class="icon-paper menu-icon"></i>
                      <span class="menu-title">Documentation</span>
                    </a>
                </li>
            </ul>
            </nav>

            <!-- partial -->
            @yield('content')
            <!-- end partial -->
        </div>
    </div>
    
    @include('layouts.alert')
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
    @endauth
</body>
</html>
