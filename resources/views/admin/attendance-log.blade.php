@extends('layouts.app')

@section('title', 'Attendance Logs')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="row">
                <div class="col-5 col-xl-9 mb-4 mb-xl-0">
                    <h2 class="font-weight-normal" data-aos="fade-up" data-aos-delay="100">Attendance Logs</h2>
                    <h6 class="font-weight-normal mb-0" data-aos="fade-up" data-aos-delay="200">List of Users Log for today</h6>
                </div>
                <div class="col-7 col-xl-3 mb-8">
                    <div class="input-group flex-nowrap" data-aos="fade-up" data-aos-delay="100">
                        <span class="input-group-text bg-transparent" id="addon-wrapping"><i class="ti-search"></i></span>
                        <input type="search" class="form-control py-1" id="search_users" oninput="showUsers('/show-users')" placeholder="Search for Users">
                        </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 grid-margin">
            <div id="reader" width="100%"></div>
        </div>
        <div class="col-md-8 grid-margin">
            <div class="table-responsive" id="showUsers">
                
            </div>
            <div class="text-center mt-2 d-flex align-items-center justify-content-between" data-aos="fade-down" data-aos-delay="900">
                <div class="page_of" data-aos="fade-right" data-aos-delay="300"></div>
                <ul id="pagination_link" data-aos="fade-up" data-aos-delay="300"></ul>
                <div class="page_total" data-aos="fade-left" data-aos-delay="300"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{asset('/js/scanner.js')}}" type="text/javascript"></script>
    <script type="text/javascript">

    function onScanSuccess(decodedText, decodedResult) {
        console.log(`Code matched = ${decodedText}`, decodedResult);
        speakMsg(decodedText)
        html5QrcodeScanner.clear()
    }

    function onScanFailure(error) {
    //   console.warn(`Code scan error = ${error}`);
    }

    let html5QrcodeScanner = new Html5QrcodeScanner(
    "reader",
    { fps: 10, qrbox: {width: 300, height: 300} },false);
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
        

    function speakMsg(messageToSpeak){
        var synth = window.speechSynthesis;
        voices = synth.getVoices();
        var toSpeak = new SpeechSynthesisUtterance(messageToSpeak);
        toSpeak.voice=voices[6];
        synth.speak(toSpeak);
    }

        // let page = 0;
        
        // async function showUsers(url){
        //     let usersOutput = document.querySelector('#showUsers');
        //     let searchInput = document.querySelector('#search_users');
        //     const paginationLink = document.querySelector('#pagination_link')
        //     const page_of = document.querySelector('.page_of')
        //     const page_total = document.querySelector('.page_total')

        //     usersOutput.innerHTML = `<div class="text-center">
        //         <div class="spinner-border" role="status">
        //             <span class="visually-hidden">Loading...</span>
        //         </div>
        //         </div>`;

        //     let URL = searchInput.value == '' ? url : url + `?search_input=${searchInput.value}`

        //     await axios.get(URL)
        //         .then(function (response) {
        //             if(response.status == 200){
        //                 let data = response.data;
        //                 usersOutput.innerHTML = data.table;
        //                 let pagination = data.pagination.links;
        //                 if(data.pagination.total > 0){
        //                     paginationLink.innerHTML = '';
        //                     pagination.forEach(elem => {
        //                         if(elem.url != null){
        //                             paginationLink.innerHTML += `<li style="cursor:pointer;" class="page-item ${elem.active ? 'active' : '' } ">
        //                             <a onclick="showUsers('${elem.url}')" class="page-link">${elem.label}</a>
        //                         </li>`;
        //                         }
        //                     });
        //                     page_of.innerHTML = `Page ${data.pagination.current_page} of ${data.pagination.last_page}`;
        //                     page_total.innerHTML = `Total of ${data.pagination.total}`;
        //                 }else{
        //                     paginationLink.innerHTML = '';
        //                     page_of.innerHTML = '';
        //                     page_total.innerHTML = '';
        //                 }
        //             }
        //         })
        //         .catch(function (error) {
        //             console.log(error);
        //         })
        // }

        // showUsers('/show-users');
    </script>
@endsection