@extends('layouts.app')

@section('title', 'My Timesheet')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="row">
                <div class="col-5 col-xl-9 mb-4 mb-xl-0">
                    <h2 class="font-weight-normal" data-aos="fade-up" data-aos-delay="100">Timesheet</h2>
                    <h6 class="font-weight-normal mb-0" data-aos="fade-up" data-aos-delay="200">Time is precious, track it wisely.</h6>
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
                            <p data-aos="fade-in" data-aos-delay="700" id="totalBreak">0</p>
                            <small class="mt-4 font-weight-bold" id="timeType">Sec</small>
                        </div>
                        <p class="p-2">
                            {{ date('l, F j, Y') }}
                        </p>
                    </div>
                    <div class="mt-0">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="p-2 text-center">
                                    <h6 data-aos="fade-up" data-aos-delay="400">{{ date('h:i A', strtotime(Auth::user()->informations->shift_start . '+1 hour')) }}</h6>
                                    <p data-aos="fade-up" data-aos-delay="500">Break Resume</p>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="p-2 text-center border-start border-end">
                                    <h6 data-aos="flip-up" data-aos-delay="400">1 Hour</h6>
                                    <p data-aos="flip-up" data-aos-delay="500">Break</p>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="p-2 text-center">
                                    <h6 data-aos="fade-up" data-aos-delay="400" id="remaining">1 Hour</h6>
                                    <p data-aos="fade-up" data-aos-delay="500" id="overbreak">Remaining</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="hr-divider">
                    <button class="btn btn-lg btn-block btn-info" id="time-button" onclick="toggleTimeSheet()">Break Out</button>
                    <hr class="hr-divider">
                    <div class="__time_adjustment_request_container mt-4">
                        <div class="d-flex justify-content-between align-items-center my-3">
                            <h4 class="my-2" data-aos="fade-up" data-aos-delay="600">Request time adjustment</h4>
                            <span class="badge rounded-pill bg-info">2</span>
                        </div>
                        <div id="request_time_adjustment_list">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 grid-margin">
            <h4 class="my-4" data-aos="fade-up" data-aos-delay="300">Breakdown</h4>
            <div class="table-responsive" id="loadTimeSheetData">
                
            </div>
            <div class="text-center mt-2 d-flex align-items-center justify-content-between" data-aos="fade-in" data-aos-delay="200">
                <div class="page_of" data-aos="fade-right" data-aos-delay="300"></div>
                <ul id="pagination_link" data-aos="fade-up" data-aos-delay="300"></ul>
                <div class="page_total" data-aos="fade-left" data-aos-delay="300"></div>
            </div>
        </div>
    </div>
    {{-- End Users logs section --}}
</div>

<div class="modal fade" id="request_time_adjustment">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body d-flex flex-column align-items-center text-center">
                <form action="{{route('submit.time.adjustment')}}" method="POST" id="adjustment_form_action"></form>
            </div>
        </div>
    </div>
</div>

<span id="message"></span>
@endsection

@section('scripts')
    <script>
        window.onload = () =>{
            loadTimeSheetData('/load-time-sheet-data');
            loadTimeAdjustmentRequest();
        }

        const breakButton = document.querySelector('#time-button');
        
        async function loadTimeSheetData(url){
            const timesheetOutput = document.querySelector('#loadTimeSheetData');
            const totalBreak = document.querySelector('#totalBreak');
            const timeType = document.querySelector('#timeType');
            const remaining = document.querySelector('#remaining');
            
            const overbreak = document.querySelector('#overbreak');

            const totalUserLog = document.querySelector('.__user_timesheet_container .__total_user_log');

            // paginations
            const paginationLink = document.querySelector('#pagination_link')
            const page_of = document.querySelector('.page_of')
            const page_total = document.querySelector('.page_total')

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
                        if (data.data.breakData.toggle === 'Break Out') {
                            breakButton.classList.remove('btn-danger')
                            breakButton.classList.add('btn-info')
                        } else {
                            breakButton.classList.remove('btn-info')
                            breakButton.classList.add('btn-danger')
                        }

                        timesheetOutput.innerHTML = data.data.table;
                        totalBreak.innerHTML = data.data.breakData.totalBreak;
                        timeType.innerHTML = data.data.breakData.timeType;
                        remaining.innerHTML = data.data.breakData.remaining;
                        breakButton.innerHTML = data.data.breakData.toggle;
                        overbreak.innerHTML = data.data.breakData.obType;
                        if(data.data.breakData.is_overbreak){
                            totalUserLog.style.background = 'rgb(247 195 195)';
                            remaining.style.color = '#ff3c3c';
                        }else{
                            totalUserLog.style.background = '#fff';
                        }

                        let pagination = data.data.pagination.links;
                        if(data.data.pagination.total > 7){
                            paginationLink.innerHTML = '';
                            pagination.forEach(elem => {
                                if(elem.url != null){
                                    paginationLink.innerHTML += `<li style="cursor:pointer;" class="page-item ${elem.active ? 'active' : '' } ">
                                    <a onclick="loadTimeSheetData('${elem.url}')" class="page-link">${elem.label}</a>
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

        async function toggleTimeSheet() {
            breakButton.classList.add('disabled')
            breakButton.innerHTML = 'Calculating';
            await axios.post('/time-sheet/toggle', { _token: `{{csrf_token()}}` })
                .then(function (response) {
                    if(response.status == 200){
                        loadTimeSheetData('/load-time-sheet-data');
                        breakButton.classList.remove('disabled')
                    }
                })
                .catch(function (error) {
                    message(error.response.data.message, 'error')
                });
        }

        async function showTimeAdjustmentModal(id){
            const adjustmentFormBody = document.querySelector('#adjustment_form_action');
            await axios.post('/show-timesheet-adjustment/', { _token: `{{csrf_token()}}`, ID: `${id}` })
                .then(function (response) {
                    adjustmentFormBody.innerHTML = '';
                    if(response.status == 200){
                        let request_time_adjustment_modal = new bootstrap.Modal(document.getElementById('request_time_adjustment'))
                        request_time_adjustment_modal.show()
                        adjustmentFormBody.innerHTML = response.data.adjustment_form;
                    }
                })
                .catch(function (error) {
                    console.log(error);
                    // message(error.response.data.message, 'error')
                });
        }

        async function loadTimeAdjustmentRequest(){
            let request_time_adjustment_list = document.querySelector('#request_time_adjustment_list');
            await axios.post('/load-time-adjustment-request', { _token: `{{csrf_token()}}` })
                .then(function (response) {
                    if(response.status == 200){
                        request_time_adjustment_list.innerHTML = response.data.adjustment_request;
                        // console.log(response);
                    }
                })
                .catch(function (error) {
                    message(error.response.data.message, 'error')
                });
        }

        function message(message, status){
            const msg = `<div class="alert alert-dismissible a-${status == 'success' ? 'success' : 'error'}" role="alert">
                <div class="d-flex align-items-center">
                    <strong class="alert-${status == 'success' ? 'success' : 'danger'}">
                        ${status == 'success' ? '<i class="ti-check"></i>' : '<i class="ti-hand-stop"></i>'}
                        </strong>
                    <div>
                        <strong>${status == 'success' ? 'Success' : 'Error'}</strong>
                        <p class="mt-2">${message}</p>
                    </div>
                </div>
                <i class="ti-close close-alert-btn" data-bs-dismiss="alert" aria-label="Close"></i>
            </div>`;
            document.querySelector('#message').innerHTML = msg;
        }
        
    </script>
@endsection