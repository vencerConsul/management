@extends('layouts.app')

@section('title', 'Technodream')

@section('content')
<div class="container-scroller bg-dark __home">
    <div class="row">
        <div class="col-lg-6 vh-100 bg-light pr-0 d-none d-lg-block">
            <div class="h-100">
                <div class="card rounded-0 h-100 p-0 __home_bg">
                    <div class="card-body border-0 d-flex align-items-center justify-content-center flex-column">
                      <img class="w-50" src="{{asset('images/home/hero.png')}}" alt="logo" data-aos="zoom-in-up" data-aos-delay="700">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 vh-100 bg-light">
          <div class="row justify-content-center align-items-center vh-100">
            <div class="col-lg-8 vh-100">
              <div class="p-3 h-100 align-middle d-flex align-items-center justify-content-center">
                <div class="card bg-transparent rounded p-0 w-100">
                  <div class="card-body p-4 border-0">
                    <img class="w-25 my-4" src="{{asset('images/logo.png')}}" alt="logo" data-aos="fade-down" data-aos-delay="800">
                    {{-- <h3 class="display-2">Sign in</h3> --}}
                    <form action="{{route('login')}}" method="POST">
                      @csrf
                      <div class="form-group" data-aos="fade-up" data-aos-delay="200">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" autofocus placeholder="Username">
                          @error('email')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                      </div>
                      <div class="form-group" data-aos="fade-up" data-aos-delay="300">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="current-password" placeholder="Password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                      </div>
                      <div class="my-2 d-flex justify-content-between align-items-center" data-aos="fade-up" data-aos-delay="400">
                        <div class="form-check">
                          <label class="form-check-label text-muted">
                            <input type="checkbox" class="form-check-input">
                            Keep me signed in
                          </label>
                        </div>
                      </div>
                      <div class="mt-3">
                        <button type="submit" class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn" data-aos="fade-up" data-aos-delay="500">SIGN IN</button>
                      </div>
                    </form>
    
                    <form action="{{route('login.google')}}" method="GET" class="pt-3">
                      <div class="mb-2">
                        <button type="submit" class="btn p-3 btn-block auth-form-btn btn-outline-dark btn-lg font-weight-medium" data-aos="fade-up" data-aos-delay="600">
                          <img class="img-fluid" src="{{asset('images/home/google-login.png')}}" alt="logo"> Sign in with Google
                        </button>
                      </div>
                    </form>
    
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
</div>
@endsection