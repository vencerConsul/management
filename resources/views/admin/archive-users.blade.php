@extends('layouts.app')

@section('title', 'Users Archived')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="row">
                <div class="col-8 col-xl-9 mb-4 mb-xl-0">
                    <h2 class="font-weight-normal" data-aos="fade-up" data-aos-delay="100">Archived Users</h2>
                    <h6 class="font-weight-normal mb-0" data-aos="fade-up" data-aos-delay="200">List of Archived Users</h6>
                </div>
                <div class="col-4 col-xl-3 mb-4 mb-xl-0">
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text bg-transparent" id="addon-wrapping"><i class="ti-search"></i></span>
                        <input type="search" class="form-control py-1" id="search_users" oninput="showUsers('/show-users-archive')" placeholder="Search for Users">
                        </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="table-responsive" id="showUsers">
                
            </div>
            <div class="text-center mt-2 d-flex align-items-center justify-content-between" data-aos="fade-down" data-aos-delay="900">
                <div class="page_of"></div>
                <ul id="pagination_link"></ul>
                <div class="page_total"></div>
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
                    let pagination = response.data.pagination.links;
                    usersOutput.innerHTML = data.table;
                    if(response.data.pagination.total < 0){
                        page_of.innerHTML = `Page ${response.data.pagination.current_page} of ${response.data.pagination.last_page}`;
                        page_total.innerHTML = `Total of ${response.data.pagination.total}`;
                        paginationLink.innerHTML = '';
                        pagination.forEach(elem => {
                            if(elem.url != null){
                                paginationLink.innerHTML += `<li style="cursor:pointer;" class="page-item ${elem.active ? 'active' : '' } ">
                                <a onclick="showUsers('${elem.url}')" class="page-link">${elem.label}</a>
                            </li>`;
                            }
                        });
                    }
                }
            })
            .catch(function (error) {
                console.log(error);
            })
    }

     showUsers('/load-users-archive');
  </script>
@endsection