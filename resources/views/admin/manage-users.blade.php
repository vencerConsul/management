@extends('layouts.app')

@section('title', 'Manage | ' . $user->name)

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-8 col-xl-10 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">{{$user->name}}</h3>
                        <h6 class="font-weight-normal mb-0">{{$user->email}}</h6>
                    </div>
                    <div class="col-8 col-xl-2 mb-4 mb-xl-0">
                        <h6>Status</h6>
                        @if($user->informations)
                        <form action="" method="POST">
                            @csrf 
                            <input type="hidden" value="approve" name="status">
                            <button class="btn btn-info btn-block">Approved</button>
                        </form>
                        @else
                            <p class="bg-success p-2 text-center text-light rounded">Information (pending)</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Basic Information</h4>
                <form class="forms-sample">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Name</label>
                        <div class="col-sm-9">
                            <input class="form-control" disabled value="{{$user->name}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input class="form-control" disabled value="{{$user->email}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Mobile</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" placeholder="Mobile number">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Password</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Re Password</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" placeholder="Password">
                        </div>
                    </div>
                    <div class="form-check form-check-flat form-check-primary">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input">
                            Remember me
                        </label>
                        </div>
                    <button type="submit" class="btn btn-info mr-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
