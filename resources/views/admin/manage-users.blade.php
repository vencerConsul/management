@extends('layouts.app')

@section('title', $user->name)

@section('content')
<div class="main-panel manage-users">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-8 col-xl-1 mb-4 mb-xl-0 user-status">
                        <a href="{{ route('users') }}" class="btn d-flex align-items-center gap-2"><i class="ti-arrow-left"></i> Back</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="card py-4">
                    <div class="card-body d-flex flex-column align-items-center">
                        <img class="mu-profile" src="{{$user->avatar_url}}" alt="{{$user->name}}">
                        <h3 class="mt-4">{{$user->name}}</h3>
                        <p>{{$user->email}}</p>
                        <small class="mu-title">{{($user->informations ? $user->informations->title : 'No title yet')}}</small>
                        <p class="mt-4 font-weight-bold">Registration Status</p>
                        @if($user->informations)
                            @if($user->status == 'pending')
                            <form action="{{route('users.approve', $user->id)}}" method="POST">
                                @csrf
                                <p class="mt-1">Pending <i class="ti-pencil text-info cursor-p" data-bs-toggle="modal" data-bs-target="#approval_modal"></i></p>
                                <div class="modal fade" id="approval_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <div class="modal-header border-0 d-flex justify-content-end">
                                            <i class="ti-close cursor-p" data-bs-dismiss="modal"></i>
                                        </div>
                                        <div class="modal-body d-flex flex-column align-items-center">
                                            <img class="mu-profile" src="{{$user->avatar_url}}" alt="{{$user->name}}">
                                            <h3 class="mt-4">{{$user->name}}</h3>
                                            <p> The user's status is "pending"</p>
                                            <button type="submit" class="btn btn-info">Approve</button>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                            </form>
                            @else 
                            <small class="p-2 text-center text-dark approved">Approved <i class="ti-check text-success"></i></small>
                            @endif
                        @else
                            <small class="p-2 text-center text-dark pending">Information (pending)</small>
                        @endif
                        <hr class="hr-divider">
                        <img class="w-25" src="{{asset('/images/qrcodes/' . $user->qrcode)}}" alt="{{$user->name}}">
                        <a href="{{asset('/images/qrcodes/' . $user->qrcode)}}" class="btn btn-info btn-sm mt-2 text-light" download>Download <i class="ti-download"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card py-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <form class="forms-sample" method="POST" action="{{route('users.update', $user->id)}}">
                                    @csrf
                                    <div class="form-group">
                                        <label>Gender</label>
                                        <div>
                                            <select class="form-control round" name="gender" value="{{ old('gender') ?? $user->informations->gender ?? '' }}">
                                                <option value="Male" {{ ($user->informations ? $user->informations->gender == 'Male' ? 'selected' : '' : '') }}>Male</option>
                                                <option value="Female" {{ ($user->informations ? $user->informations->gender == 'Female' ? 'selected' : '' : '') }}>Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Date of birth</label>
                                        <div>
                                            <input type="date" class="form-control" placeholder="dd/mm/yyyy" name="date_of_birth" value="{{old('date_of_birth') ?? $user->informations->date_of_birth ?? ''}}"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Address 1</label>
                                        <div>
                                            <input type="text" class="form-control" placeholder="Address 1" name="address_1" value="{{old('address_1') ?? $user->informations->address_1 ?? ''}}"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Address 2</label>
                                        <div>
                                            <input type="text" class="form-control" placeholder="Address 2" name="address_2" value="{{old('address_2') ?? $user->informations->address_2 ?? ''}}"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Title</label>
                                        <div>
                                            <select class="form-control round" name="title" value="{{old('title') ?? $user->informations->title ?? ''}}">
                                                <option value="Web Developer" {{ ($user->informations ? $user->informations->title == 'Web Developer' ? 'selected' : '' : '') }}>Web Developer</option>
                                                <option value="Project Manager" {{ ($user->informations ? $user->informations->title == 'Project Manager' ? 'selected' : '' : '') }}>Project Manager</option>
                                                <option value="Sales" {{ ($user->informations ? $user->informations->title == 'Sales' ? 'selected' : '' : '') }}>Sales</option>
                                                <option value="Call Center" {{ ($user->informations ? $user->informations->title == 'Call Center' ? 'selected' : '' : '') }}>Call Center</option>
                                                <option value="Human Resources" {{ ($user->informations ? $user->informations->title == 'Human Resources' ? 'selected' : '' : '') }}>Human Resources</option>
                                                <option value="WIX" {{ ($user->informations ? $user->informations->title == 'WIX' ? 'selected' : '' : '') }}>WIX</option>
                                                <option value="SMM" {{ ($user->informations ? $user->informations->title == 'SMM' ? 'selected' : '' : '') }}>SMM</option>
                                                <option value="SEO" {{ ($user->informations ? $user->informations->title == 'SEO' ? 'selected' : '' : '') }}>SEO</option>
                                                <option value="PULS" {{ ($user->informations ? $user->informations->title == 'PULS' ? 'selected' : '' : '') }}>PULS</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Department</label>
                                        <div>
                                            <input type="text" class="form-control" placeholder="Department" name="department" value="{{old('department') ?? $user->informations->department ?? ''}}"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Shift Start</label>
                                        <div>
                                            <input type="time" class="form-control" step="60" name="shift_start" value="{{old('shift_start') ?? $user->informations->shift_start ?? ''}}"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Shift End</label>
                                        <div>
                                            <input type="time" class="form-control" step="60" name="shift_end" value="{{old('shift_end') ?? $user->informations->shift_end ?? ''}}"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Contact Number</label>
                                        <div>
                                            <input type="number" class="form-control" placeholder="exp. 09123456678" name="contact_number" value="{{old('contact_number') ?? $user->informations->contact_number ?? ''}}"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Emergency Contact</label>
                                        <div>
                                            <input type="number" class="form-control" placeholder="exp. 09123456678" name="emergency_contact_number" value="{{old('emergency_contact_number') ?? $user->informations->emergency_contact_number ?? ''}}"/>
                                        </div>
                                    </div></div>
                                </div>
                            
                            <button type="submit" class="btn btn-info mr-2 float-right">Update</button>
                        </form>
                    </div>
                </div>

                {{-- danger section --}}
                <h3 class="font-weight-normal mt-4">Danger Zone</h3>
                <div class="card py-4 danger-zone">
                    <div class="card-body">
                        <form action="{{route('users.archive', $user->id)}}" method="POST">
                            @csrf
                            <div class="d-flex justify-content-between align-items-center my-2">
                                <div>
                                    <p class="font-weight-bold">Archive this user</p>
                                    <p>Mark this user as archived and read-only.</p>
                                </div>
                                <button type="button" role="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#archive_user_model">Archive this user</button>
                                <div class="modal fade" id="archive_user_model" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <div class="modal-header border-0 d-flex justify-content-end">
                                            <i class="ti-close cursor-p" data-bs-dismiss="modal"></i>
                                        </div>
                                        <div class="modal-body d-flex flex-column align-items-center text-center">
                                            <img class="mu-profile" src="{{$user->avatar_url}}" alt="{{$user->name}}">
                                            <h3 class="mt-4">{{$user->name}}</h3>
                                            <p>Effective immediately, this account will be limited to read-only access. Nevertheless, you have the ability to restore it to its previous state by retrieving it and unarchiving it at your convenience.</p>
                                            <h4 class="text-center">Are you sure you want to move {{$user->name}} to archived?</h4>
                                            <p class="mt-2">Please type <strong>{{$user->email}}</strong> to confirm.</p>
                                            <input type="email" class="form-control" placeholder="Confirmation.." name="email_confirmation">
                                            <button type="submit" class="btn btn-danger mt-2">Archive</button>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <hr class="hr-divider">
                        <form action="{{route('users.delete', $user->id)}}" method="POST">
                            @csrf
                            <div class="d-flex justify-content-between align-items-center my-2">
                                <div>
                                    <p class="font-weight-bold">Delete this user</p>
                                    <p>Once you delete a user, there is no going back. Please be certain.</p>
                                </div>
                                <button type="button" role="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#delete_user_model">Delete this user</button>
                                <div class="modal fade" id="delete_user_model" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <div class="modal-header border-0 d-flex justify-content-end">
                                            <i class="ti-close cursor-p" data-bs-dismiss="modal"></i>
                                        </div>
                                        <div class="modal-body d-flex flex-column align-items-center text-center">
                                            <img class="mu-profile" src="{{$user->avatar_url}}" alt="{{$user->name}}">
                                            <h3 class="mt-4">{{$user->name}}</h3>
                                            <p>This deletion is irreversible and will result in permanent loss of data.</p>
                                            <p class="font-weight-bold">Are you sure you want to continue delete {{$user->name}}?</p>
                                            <p class="mt-2">Please type <strong>{{$user->email}}</strong> to confirm.</p>
                                            <input type="email" class="form-control" placeholder="Confirmation.." name="email_confirmation">
                                            <button type="submit" class="btn btn-danger mt-2">Delete</button>
                                        </div>
                                      </div>
                                    </div>
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
