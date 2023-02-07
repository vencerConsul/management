@extends('layouts.app')

@section('title', 'Users')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Users</h3>
                        <h6 class="font-weight-normal mb-0">List of Users by Title</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin">
                @include('layouts.alert')
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
     async function showUsers(){
      await axios.get(`/show-users`)
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

     showUsers();
  </script>
@endsection