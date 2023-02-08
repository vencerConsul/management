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
                        <input type="search" class="form-control py-1 border-0" id="search_users" oninput="showUsers(this.value)" placeholder="Search for Users">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="table-responsive" id="showUsers">
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

  <script>

    let usersOutput = document.querySelector('#showUsers');
        async function showUsers(searchInput){

            usersOutput.innerHTML = `<div class="text-center">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                </div>`;

        await axios.get(`/show-users/${searchInput}`)
            .then(function (response) {
                console.log(response);
                if(response.status == 200){
                    usersOutput.innerHTML = response.data.data;
                }
            })
            .catch(function (error) {
                console.log(error);
            })
        }

     showUsers(undefined);
  </script>
@endsection