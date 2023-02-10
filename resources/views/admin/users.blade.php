@extends('layouts.app')

@section('title', 'Users')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-8 col-xl-9 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Users</h3>
                        <h6 class="font-weight-normal mb-0">List of Users by Title</h6>
                    </div>
                    <div class="col-4 col-xl-3 mb-4 mb-xl-0">
                        <input type="search" class="form-control py-1 border-0" id="search_users" oninput="showUsers()" placeholder="Search for Users">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="table-responsive" id="showUsers">
                    
                </div>
                <ul class="pagination" id="pagination_link">

                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
  <script>
    
    async function showUsers(){
        let usersOutput = document.querySelector('#showUsers');
        let searchInput = document.querySelector('#search_users');
        const paginationLink = document.querySelector('#pagination_link')

        usersOutput.innerHTML = `<div class="text-center">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            </div>`;

        let data = {
            'search_input': searchInput.value
        }

        await axios.post('/show-users/', data)
            .then(function (response) {
                if(response.status == 200){
                    let data = response.data;
                    let pagination = response.data.pagination.links;
                    usersOutput.innerHTML = data.table;
                    paginationLink.innerHTML = '';
                    pagination.forEach(elem => {
                        paginationLink.innerHTML += `<li style="cursor:pointer;" class="page-item ${elem.active ? 'active' : '' } "><a class="page-link" style="background-color: #ffffff;">${elem.label}</a></li>`;
                    });
                    
                }
            })
            .catch(function (error) {
                console.log(error);
            })
    }

     showUsers();
  </script>
@endsection