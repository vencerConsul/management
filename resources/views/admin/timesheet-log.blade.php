@extends('layouts.app')

@section('title', 'Time Sheet Logs')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="row">
                <div class="col-5 col-xl-9 mb-4 mb-xl-0">
                    <h2 class="font-weight-normal" data-aos="fade-up" data-aos-delay="100">Timesheet Logs</h2>
                    <h6 class="font-weight-normal mb-0" data-aos="fade-up" data-aos-delay="200">List of Users Log for today</h6>
                </div>
                <div class="col-7 col-xl-3 mb-8">
                    <div class="input-group flex-nowrap" data-aos="fade-up" data-aos-delay="100">
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
            <div class="card __total_user_log_container" data-aos="fade-up" data-aos-delay="300">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-center flex-column p-4">
                        <h3>On Break</h3>
                        <div class="__total_user_log">
                            <p data-aos="fade-in" data-aos-delay="700">23</p>
                        </div>
                        <p class="p-2">
                            {{ date('l, F j, Y') }}
                        </p>
                    </div>
                    <div class="mt-0">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="p-2 text-center">
                                    <h4 data-aos="fade-up" data-aos-delay="400">34</h4>
                                    <p data-aos="fade-up" data-aos-delay="500">Over Break</p>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="p-2 text-center border-start border-end">
                                    <h4 data-aos="fade-up" data-aos-delay="400">59</h4>
                                    <p data-aos="fade-up" data-aos-delay="500">Active User</p>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="p-2 text-center">
                                    <h4 data-aos="fade-up" data-aos-delay="400">1 Hour</h4>
                                    <p data-aos="fade-up" data-aos-delay="500">Break</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="hr-divider">
                    <div class="__time_adjustment_request_container mt-4">
                        <div class="my-3">
                            <h4 class="my-3" data-aos="fade-up" data-aos-delay="600">Time adjustment request</h4>
                        </div>
                        <div class="__time_adjustment_request_list d-flex align-items-center justify-content-between mb-2" data-aos="fade-up" data-aos-delay="600">
                            <div class="d-flex align-items-center gap-4">
                                <img class="img-fluid" src="{{Auth::user()->avatar_url}}" alt="profile">
                                <div>
                                    <p class="m-0">{{Auth::user()->name}}</p>
                                    <small>{{Auth::user()->created_at->diffForHumans()}}</small>
                                </div>
                            </div>
                            <button class="btn btn-sm btn-primary">View</button>
                        </div>
                        <div class="__time_adjustment_request_list d-flex align-items-center justify-content-between mb-2" data-aos="fade-up" data-aos-delay="700">
                            <div class="d-flex align-items-center gap-4">
                                <img class="img-fluid" src="{{Auth::user()->avatar_url}}" alt="profile">
                                <div>
                                    <p class="m-0">{{Auth::user()->name}}</p>
                                    <small>{{Auth::user()->created_at->diffForHumans()}}</small>
                                </div>
                            </div>
                            <button class="btn btn-sm btn-primary">View</button>
                        </div>
                        <div class="__time_adjustment_request_list d-flex align-items-center justify-content-between mb-2" data-aos="fade-up" data-aos-delay="800">
                            <div class="d-flex align-items-center gap-4">
                                <img class="img-fluid" src="{{Auth::user()->avatar_url}}" alt="profile">
                                <div>
                                    <p class="m-0">{{Auth::user()->name}}</p>
                                    <small>{{Auth::user()->created_at->diffForHumans()}}</small>
                                </div>
                            </div>
                            <button class="btn btn-sm btn-primary">View</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 grid-margin">
            <h4 class="my-4">Users on Break</h4>
            <div class="table-responsive" id="timeSheetData">
                
                {{-- <div class="v-100 text-center" data-aos="fade-up" data-aos-delay="400">
                    <div class="card">
                        <div class="card-body" id="timeSheetData">
                            <img class="img-fluid" src="{{asset('/images/attendance/under-construction.jpg')}}" alt="Under constructiont">
                            <h3 class="font-weight-normal mt-4">Under Development</h3>
                            <p>Stay tuned, something great is coming.</p>
                        </div>
                    </div>
                </div> --}}

            </div>
            <div class="text-center mt-2 d-flex align-items-center justify-content-between" data-aos="fade-down" data-aos-delay="900">
                <div class="page_of" data-aos="fade-right" data-aos-delay="300"></div>
                <ul id="pagination_link" data-aos="fade-up" data-aos-delay="300"></ul>
                <div class="page_total" data-aos="fade-left" data-aos-delay="300"></div>
            </div>
        </div>
    </div>
    {{-- End Users logs section --}}
</div>
@endsection

@section('scripts')
    <script>
        const breakButton = document.querySelector('#time-button');
        
        async function loadTimeSheetData(url){
            const timesheetOutput = document.querySelector('#timeSheetData');
            timesheetOutput.innerHTML = `<div class="text-center">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                </div>`;

            let URL = url

            await axios.get(URL)
                .then(function (response) {
                    let data = response;
                    if(response.status == 200){
                        // if (data.data.breakData.toggle === 'Break Out') {
                        //     breakButton.classList.remove('btn-danger')
                        //     breakButton.classList.add('btn-info')
                        // } else {
                        //     breakButton.classList.remove('btn-info')
                        //     breakButton.classList.add('btn-danger')
                        // }

                        timesheetOutput.innerHTML = data.data.table;
                        // totalBreak.innerHTML = data.data.breakData.totalBreak;
                        // timeType.innerHTML = data.data.breakData.timeType;
                        // remaining.innerHTML = data.data.breakData.remaining;
                        // breakButton.innerHTML = data.data.breakData.toggle;
                        // overbreak.innerHTML = data.data.breakData.obType;
                        // if(data.data.breakData.seconds > 3600){
                        //     totalUserLog.style.border = '5px solid #ff3c3c';
                        //     remaining.style.color = '#ff3c3c';
                        // }else{
                        //     totalUserLog.style.border = '5px solid #fff';
                        // }

                        // let pagination = data.data.pagination.links;
                        // if(data.data.pagination.total > 7){
                        //     paginationLink.innerHTML = '';
                        //     pagination.forEach(elem => {
                        //         if(elem.url != null){
                        //             paginationLink.innerHTML += `<li style="cursor:pointer;" class="page-item ${elem.active ? 'active' : '' } ">
                        //             <a onclick="loadTimeSheetData('${elem.url}')" class="page-link">${elem.label}</a>
                        //         </li>`;
                        //         }
                        //     });
                        //     page_of.innerHTML = `Page ${data.pagination.current_page} of ${data.pagination.last_page}`;
                        //     page_total.innerHTML = `Total of ${data.pagination.total}`;
                        // }else{
                        //     paginationLink.innerHTML = '';
                        //     page_of.innerHTML = '';
                        //     page_total.innerHTML = '';
                        // }
                    }
                })
                .catch(function (error) {
                    console.log(error);
                })
        }
        loadTimeSheetData('/load-time-sheet-data');

        // function toggleTimeSheet() {
        //     breakButton.classList.add('disabled')
        //     axios.post('/time-sheet/toggle', { _token: `{{csrf_token()}}` })
        //         .then(function (response) {
        //             if(response.status == 200){
        //                 loadTimeSheetData('/load-time-sheet-data');
        //                 breakButton.classList.remove('disabled')
        //             }
        //         })
        //         .catch(function (error) {
        //             message(error.response.data.message)
        //         });
        // }

        // function message(message){
        //     const msg = `<div class="alert alert-dismissible a-error" role="alert">
        //         <div class="d-flex align-items-center">
        //             <strong class="alert-danger"><i class="ti-hand-stop"></i></strong>
        //             <div>
        //                 <strong>Error</strong>
        //                 <p class="mt-2">${message}</p>
        //             </div>
        //         </div>
        //         <i class="ti-close close-alert-btn" data-bs-dismiss="alert" aria-label="Close"></i>
        //     </div>`;
        //     document.querySelector('#message').innerHTML = msg;
        // }
    </script>
@endsection