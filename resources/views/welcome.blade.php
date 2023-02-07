@extends('layouts.app')

@section('title', 'Technodream')

@section('content')

<div class="container-scroller">
  <div class="container-fluid page-body-wrapper full-page-wrapper">
    <div class="content-wrapper d-flex align-items-center auth px-0">
      <div class="row w-100 mx-0">
        <div class="col-lg-4 mx-auto">
          @include('layouts.alert')
          <div class="auth-form-light text-center py-5 px-4 px-sm-5">
            <div class="brand-logo">
              <img src="{{asset('/images/logo.png')}}" alt="logo">
            </div>
            <form action="{{route('login')}}" method="POST" class="pt-3">
              @csrf
              <div class="form-group">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" autofocus placeholder="Username">
                  @error('email')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
              <div class="form-group">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="current-password" placeholder="Password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
              <div class="my-2 d-flex justify-content-between align-items-center">
                <div class="form-check">
                  <label class="form-check-label text-muted">
                    <input type="checkbox" class="form-check-input">
                    Keep me signed in
                  </label>
                </div>
              </div>
              <div class="mt-3">
                <button type="submit" class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn">SIGN IN</button>
              </div>
            </form>
            <form action="{{route('login.google')}}" method="GET" class="pt-3">
              <div class="mb-2">
                <button type="submit" class="btn btn-block auth-form-btn bg-info text-light">
                  <i class="ti-google mr-2"></i>Connect using Gmail
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- content-wrapper ends -->
  </div>
  <!-- page-body-wrapper ends -->
</div>
@endsection