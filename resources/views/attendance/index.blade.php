@extends('layouts.app')

@section('title', 'Attendance')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="row">
                <div class="col-5 col-xl-9 mb-4 mb-xl-0">
                    <h2 class="font-weight-normal" data-aos="fade-up" data-aos-delay="100">Attendance</h2>
                    <h6 class="font-weight-normal mb-0" data-aos="fade-up" data-aos-delay="200">List of Users Log for today</h6>
                </div>
                <div class="col-7 col-xl-3 mb-8">
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text bg-transparent" id="addon-wrapping"><i class="ti-search"></i></span>
                        <input type="search" class="form-control py-1" id="search_users" oninput="showUsers('/show-users')" placeholder="Search for Users">
                        </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="table-responsive" id="showUsers">
                
            </div>
            <div class="text-center mt-2 d-flex align-items-center justify-content-between">
                <div class="page_of">
                    
                </div>
                <ul id="pagination_link">

                </ul>
                <div class="page_total">
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
  <script>
    let page = 0;
    
    async function showUsers(url){
        let usersOutput = document.querySelector('#showUsers');
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
                                <a onclick="showUsers('${elem.url}')" class="page-link">${elem.label}</a>
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

     showUsers('/show-users');
  </script>
@endsection