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
    <link rel="stylesheet" href="{{ asset('css/aos.css') }}" />
    @auth
    <link href="{{ asset('vendors/feather/feather.css') }}" rel="stylesheet">
    @endauth
</head>
<body>
    
    @auth 
        <div class="container-scroller">
            <div class="container-fluid page-body-wrapper">
                <nav class="sidebar sidebar-offcanvas" id="sidebar" data-aos="fade-right" data-aos-delay="100">
                <ul class="nav">
                    <div class="profile align-self-center text-center">
                        <img src="{{Auth::user()->avatar_url}}" alt="profile" data-aos="fade-up" data-aos-delay="200"/>
                        <p class="my-2" data-aos="fade-up" data-aos-delay="300">{{Auth::user()->name}}</p>
                    </div>
                    <li class="nav-item" data-aos="fade-up" data-aos-delay="400">
                        <a class="nav-link" data-toggle="collapse" href="#__profile" aria-expanded="false" aria-controls="__profile">
                            <i class="ti-more menu-icon"></i>
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
                    <li class="nav-item" data-aos="fade-up" data-aos-delay="800">
                        <a class="nav-link" data-toggle="collapse" href="#__timesheet" aria-expanded="false" aria-controls="__timesheet">
                            <i class="ti-alarm-clock menu-icon"></i>
                            <span class="menu-title">Timesheet</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="__timesheet">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="{{route('timesheet')}}"><i class="ti-link menu-icon"></i> Timesheet</a></li>
                                @if(Auth::user()->role == 1)
                                <li class="nav-item"> <a class="nav-link" href="{{route('timesheet.logs')}}"><i class="ti-link menu-icon"></i> Timesheet Logs</a></li>
                                @endif
                            </ul>
                        </div>
                    </li>
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
                            @if(Auth::user()->role == 1)
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('attendance.logs')}}"><i class="ti-link menu-icon"></i> Attendance Logs</a>
                            </li>
                            @endif
                        </ul>
                    </div>
                    </li>
                    <li class="nav-item" data-aos="fade-up" data-aos-delay="900">
                        <a class="nav-link" href="pages/documentation/documentation.html">
                        <i class="icon-paper menu-icon"></i>
                        <span class="menu-title">Documentation</span>
                        </a>
                    </li>
                    <hr class="hr-divider">
                </ul>
                <div class="p-2">
                    <div class="card p-0 session-timeout">
                        <div class="card-body p-3">
                            <small>Stay secure with automatic session timeout. Session will expire if inactive.</small>
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <div class="p-3 shadow-sm hours">0</div>
                                <div class="p-3 shadow-sm minutes">0</div>
                                <div class="p-3 shadow-sm seconds">0</div>
                            </div>
                        </div>
                    </div>
                </div>
                </nav>

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
            </div>
        </div>
    @endauth

    @guest
        @yield('content')
    @endguest
    
    @include('layouts.alert')
    
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('vendors/js/vendor.bundle.base.js') }}" defer></script>
    <script src="{{ asset('js/off-canvas.js') }}" defer></script>
    <script src="{{ asset('js/template.js') }}" defer></script>
    <script src="{{ asset('js/aos.js') }}"></script>
    <script> AOS.init(); </script>
    @auth
    <script src="{{ asset('js/axios.js') }}"></script>
    <script>
        var sessionTimeout = {{ config('session.lifetime') }} * 60; 
            var countdownTimer = setInterval(function() {
                sessionTimeout--;
                var hours = Math.floor(sessionTimeout / 3600);
                var minutes = Math.floor((sessionTimeout % 3600) / 60);
                var seconds = sessionTimeout % 60;
                document.querySelector('.hours').innerHTML = (hours < 10 ? '0' : '') + hours;
                document.querySelector('.minutes').innerHTML = (minutes < 10 ? '0' : '') + minutes;
                document.querySelector('.seconds').innerHTML = (seconds < 10 ? '0' : '') + seconds;
                if (sessionTimeout <= 0) {
                    clearInterval(countdownTimer);
                    loggedOut();
                }
            }, 1000);
            function loggedOut(){
                document.getElementById('logout-form').submit();
            }
    </script>
        @if(\Route::currentRouteName() == 'dashboard')
            <script src="{{ asset('js/weather.js') }}" defer></script>
        @endif
    @endauth
    @yield('scripts')
</body>
</html>