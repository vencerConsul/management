@extends('layouts.app')

@section('title', 'My Timesheet')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="row">
                <div class="col-5 col-xl-9 mb-4 mb-xl-0">
                    <h2 class="font-weight-normal" data-aos="fade-up" data-aos-delay="100">Timesheet</h2>
                    <h6 class="font-weight-normal mb-0" data-aos="fade-up" data-aos-delay="200">My Daily Record</h6>
                </div>
                <div class="col-7 col-xl-3 mb-8">
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text bg-transparent" id="addon-wrapping"><i class="ti-search"></i></span>
                        <input type="search" class="form-control py-1" id="search_users" oninput="loadUsers('/time-sheet-users-logs')" placeholder="Search for Users">
                    </div>
                </div>
            </div>
        </div>
    </div>
   {{-- Users logs section --}}
    <div class="row">
        <div class="col-lg-4 grid-margin">
            <div class="card __user_timesheet_container" data-aos="fade-up" data-aos-delay="300">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-center flex-column p-4">
                        <h3>Total Break</h3>
                        <div class="__total_user_log">
                            <p data-aos="fade-in" data-aos-delay="700">23</p>
                            <small class="mt-4">Mins</small>
                        </div>
                        <p class="p-2">
                            {{ date('l, F j, Y') }}
                        </p>
                    </div>
                    <div class="mt-0">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="p-2 text-center">
                                    <h4 data-aos="fade-up" data-aos-delay="400">{{ date('h:i A', strtotime(Auth::user()->informations->shift_start . '+1 hour')) }}</h4>
                                    <p data-aos="fade-up" data-aos-delay="500">Break Resume</p>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="p-2 text-center border-start border-end">
                                    <h4 data-aos="fade-up" data-aos-delay="400">1 Hour</h4>
                                    <p data-aos="fade-up" data-aos-delay="500">Break</p>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="p-2 text-center">
                                    <h4 data-aos="fade-up" data-aos-delay="400">1 Hour</h4>
                                    <p data-aos="fade-up" data-aos-delay="500">Remaining</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="hr-divider">
                    <button class="btn btn-lg btn-block btn-info" id="breakHandle()">Break Out</button>
                    <hr class="hr-divider">
                    <div class="__time_adjustment_request_container mt-4">
                        <div class="d-flex justify-content-between align-items-center my-3">
                            <h4 class="my-2" data-aos="fade-up" data-aos-delay="600">Request time adjustment</h4>
                            <i class="ti-plus"></i>
                        </div>
                        <div class="__time_adjustment_request_list d-flex align-items-center justify-content-between mb-2 gap-4" data-aos="fade-up" data-aos-delay="600">
                            <div>
                                <p class="m-0 font-weight-bold">10:23 PM</p>
                                <small class="badge bg-warning text-dark">Pending</small>
                            </div>
                            <div>
                                @php
                                    $paragraph = 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Obcaecati, saepe? awd awd awd awd awd awd awd awdawd ';
                                @endphp
                                @if(strlen($paragraph) > 50)
                                    <p>{{ substr($paragraph, 0, 50) }}</p>
                                @else
                                    {{ $paragraph }}
                                @endif
                            </div>
                            <button class="btn btn-sm btn-info">Edit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 grid-margin">
            <h4 class="my-4">Users on Break</h4>
            <div class="table-responsive" id="loadUsers">
                
            </div>
            <div class="text-center mt-2 d-flex align-items-center justify-content-between" data-aos="fade-down" data-aos-delay="900">
                <div class="page_of"></div>
                <ul id="pagination_link"></ul>
                <div class="page_total"></div>
            </div>
        </div>
    </div>
    {{-- End Users logs section --}}
</div>
@endsection

@section('scripts')
    <script>
        let page = 0;
        
        async function loadUsers(url){
            let usersOutput = document.querySelector('#loadUsers');
            let searchInput = document.querySelector('#search_users');
            const paginationLink = document.querySelector('#pagination_link')
            const page_of = document.querySelector('.page_of')
            const page_total = document.querySelector('.page_total')

            usersOutput.innerHTML = `<div class="text-center">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                </div>`;

            let URL = searchInput.value == '' ? url : url + `?search_input=${searchInput.value}`

            await axios.get(URL)
                .then(function (response) {
                    if(response.status == 200){
                        let data = response.data;
                        usersOutput.innerHTML = data.table;
                        let pagination = data.pagination.links;
                        if(data.pagination.total > 0){
                            paginationLink.innerHTML = '';
                            pagination.forEach(elem => {
                                if(elem.url != null){
                                    paginationLink.innerHTML += `<li style="cursor:pointer;" class="page-item ${elem.active ? 'active' : '' } ">
                                    <a onclick="loadUsers('${elem.url}')" class="page-link">${elem.label}</a>
                                </li>`;
                                }
                            });
                            page_of.innerHTML = `Page ${data.pagination.current_page} of ${data.pagination.last_page}`;
                            page_total.innerHTML = `Total of ${data.pagination.total}`;
                        }else{
                            paginationLink.innerHTML = '';
                            page_of.innerHTML = '';
                            page_total.innerHTML = '';
                        }
                    }
                })
                .catch(function (error) {
                    console.log(error);
                })
        }

        loadUsers('/time-sheet-users-logs');
    </script>
@endsection