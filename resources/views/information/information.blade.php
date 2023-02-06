@extends('layouts.app')

@section('title', 'Basic Information')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Welcome {{Auth::user()->name}}</h3>
                        <h6 class="font-weight-normal mb-0">{{empty($information) ? 'Please fill out the required fields below and click on the "Submit" button to save your information.' : $information->title }}</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin">
                @include('layouts.alert')
                <div class="card">
                    <div class="card-body">
                        <p class="card-description font-weight-bold text-dark">
                            Personal Information
                        </p>
                        <form class="form-sample" method="POST" action="{{ empty($information) ? route('information.store') : route('information.update')}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Name</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" disabled value="{{Auth::user()->name}}"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Email</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" disabled value="{{Auth::user()->email}}"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Gender</label>
                                        <div class="col-sm-9">
                                            <select class="form-control round" name="gender" value="{{ old('gender') ?? $information->gender ?? '' }}">
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Date of Birth</label>
                                        <div class="col-sm-9">
                                            <input type="date" class="form-control" placeholder="dd/mm/yyyy" name="date_of_birth" value="{{old('date_of_birth') ?? $information->date_of_birth ?? ''}}"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Address 1</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" placeholder="Address 1" name="address_1" value="{{old('address_1') ?? $information->address_1 ?? ''}}"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Address 2</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" placeholder="Address 2" name="address_2" value="{{old('address_2') ?? $information->address_2 ?? ''}}"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="card-description font-weight-bold text-dark">
                                Work Information
                            </p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Title</label>
                                        <div class="col-sm-9">
                                            <select class="form-control round" name="title" value="{{old('title') ?? $information->title ?? ''}}">
                                                <option>Web Developer</option>
                                                <option>Project Manager</option>
                                                <option>Sales</option>
                                                <option>Call Center</option>
                                                <option>Human Resources</option>
                                                <option>SMM</option>
                                                <option>SEO</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Department</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" placeholder="Department" name="department" value="{{old('department') ?? $information->department ?? ''}}"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Shift Start</label>
                                        <div class="col-sm-9">
                                            <input type="time" class="form-control" step="60" name="shift_start" value="{{old('shift_start') ?? $information->shift_start ?? ''}}"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Shift End</label>
                                        <div class="col-sm-9">
                                            <input type="time" class="form-control" step="60" name="shift_end" value="{{old('shift_end') ?? $information->shift_end ?? ''}}"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Contact Number</label>
                                        <div class="col-sm-9">
                                            <input type="number" class="form-control" placeholder="exp. 09123456678" name="contact_number" value="{{old('contact_number') ?? $information->contact_number ?? ''}}"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Emergency Contact</label>
                                        <div class="col-sm-9">
                                            <input type="number" class="form-control" placeholder="exp. 09123456678" name="emergency_contact_number" value="{{old('emergency_contact_number') ?? $information->emergency_contact_number ?? ''}}"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-10"></div>
                                <div class="col-lg-2">
                                    @if($information)
                                    <button type="submit" class="btn btn-block btn-info">Update</button>
                                    @else 
                                    <button type="submit" class="btn btn-block btn-info">Submit</button>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection