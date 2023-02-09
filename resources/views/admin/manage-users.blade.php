@extends('layouts.app')

@section('title', 'Manage | ' . $user->name)

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-8 col-xl-9 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">{{$user->name}}</h3>
                        <h6 class="font-weight-normal mb-0">{{$user->email}}</h6>
                    </div>
                    <div class="col-lg-1">
                        <small>QRCode</small>
                        <p class="text-center p-2 text-dark qrcode" data-bs-toggle="modal" data-bs-target="#exampleModal">View</p>
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content p-0">
                                    <div class="modal-body p-2">
                                        <img class="w-100" src="{{asset('/images/qrcodes/' . $user->qrcode . '.png')}}" alt="{{$user->name}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-8 col-xl-2 mb-4 mb-xl-0 user-status">
                        <small>Status</small>
                        @if($user->informations)
                            @if($user->status == 0)
                            <form action="{{route('users.approve', $user->id)}}" method="POST">
                                @csrf 
                                <input type="hidden" value="approve" name="status">
                                <button class="btn btn-info btn-block">Approved</button>
                            </form>
                            @else 
                            <p class="p-2 text-center text-dark approved">Approved</p>
                            @endif
                        @else
                            <p class="p-2 text-center text-dark pending">Information (pending)</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Basic Information</h4>
                <form class="forms-sample" method="POST" action="{{route('users.update', $user->id)}}">
                    @csrf
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
                        <label class="col-sm-3 col-form-label">Gender</label>
                        <div class="col-sm-9">
                            <select class="form-control round" name="gender" value="{{ old('gender') ?? $user->informations->gender ?? '' }}">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Date of birth</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" placeholder="dd/mm/yyyy" name="date_of_birth" value="{{old('date_of_birth') ?? $user->informations->date_of_birth ?? ''}}"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Address 1</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" placeholder="Address 1" name="address_1" value="{{old('address_1') ?? $user->informations->address_1 ?? ''}}"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Address 2</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" placeholder="Address 2" name="address_2" value="{{old('address_2') ?? $user->informations->address_2 ?? ''}}"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Title</label>
                        <div class="col-sm-9">
                            <select class="form-control round" name="title" value="{{old('title') ?? $user->informations->title ?? ''}}">
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
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Department</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" placeholder="Department" name="department" value="{{old('department') ?? $user->informations->department ?? ''}}"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Shift Start</label>
                        <div class="col-sm-9">
                            <input type="time" class="form-control" step="60" name="shift_start" value="{{old('shift_start') ?? $user->informations->shift_start ?? ''}}"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Shift End</label>
                        <div class="col-sm-9">
                            <input type="time" class="form-control" step="60" name="shift_end" value="{{old('shift_end') ?? $user->informations->shift_end ?? ''}}"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Contact Number</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" placeholder="exp. 09123456678" name="contact_number" value="{{old('contact_number') ?? $user->informations->contact_number ?? ''}}"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Emergency Contact</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" placeholder="exp. 09123456678" name="emergency_contact_number" value="{{old('emergency_contact_number') ?? $user->informations->emergency_contact_number ?? ''}}"/>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-info mr-2">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        setTimeout(() => {
            document.querySelector('.alert').style.display = 'none';
        }, 5000);
    </script>
@endsection
