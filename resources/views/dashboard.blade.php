@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="content-wrapper">
  <div class="row">
    <div class="col-md-12 grid-margin">
      <div class="row">
        <div class="col-12 col-xl-12 mb-4 mb-xl-0">
          <h3 class="font-weight-normal" data-aos="fade-up" data-aos-delay="100">Welcome {{Auth::user()->name}}</h3>
          <h6 class="font-weight-normal mb-0" data-aos="fade-up" data-aos-delay="200">{{Auth::user()->informations->title}}</h6>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-9 grid-margin">
      <div class="row">
        <div class="col-lg-12 grid-margin">
          <div class="card" data-aos="fade-up" data-aos-delay="300">
            <div class="card-people mt-auto">
              <img class="weather-img" src="{{asset('images/dashboard/weather/clear.png')}}" alt="weather">
              <div class="weather-info">
                <div class="d-flex">
                  <div>
                    <h1 class="mb-0 font-weight-normal"><i class="ti-pin mr-2"></i><span class="weather-tamp">0</span><sup>C</sup></h1>
                  </div>
                  <div class="ml-2">
                    <h4 class="weather-location font-weight-normal">--</h4>
                    <h6 class="font-weight-normal weather-type text-capitalize">--</h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-12 stretch-card grid-margin">
          <div class="card" data-aos="fade-up" data-aos-delay="400">
            <div class="card-body">
              <p class="card-title mb-0">Departments</p>
              <div class="table-responsive">
                <table class="table table-borderless">
                  <thead>
                    <tr>
                      <th class="pl-0  pb-2 border-bottom"></th>
                      <th class="border-bottom pb-2">Users</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if($usersByDepartment->count() > 0)
                      @forEach($usersByDepartment as $deptGroup)
                      <tr>
                        <td class="pl-0">{{$deptGroup->department}}</td>
                        <td class="text-muted">{{$deptGroup->count}}</td>
                      </tr>
                      @endforeach
                    @else 
                      <img class="w-50 my-4" src="{{asset('images/dashboard/online-users/no-online-users.png')}}" alt="No Department found">
                      <h4>No Department sssociate with users</h4>';
                    @endif
                  </tbody>
                </table>
              </div>
              @if ($usersByDepartment->hasPages())
                  @if ($usersByDepartment->currentPage() > 1)
                      <a href="{{ $usersByDepartment->previousPageUrl() }}" class="btn btn-info">Previous</a>
                  @endif
                  @if (!$usersByDepartment->onLastPage())
                      <a href="{{ $usersByDepartment->nextPageUrl() }}" class="btn btn-info">Next</a>
                  @endif
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 grid-margin col-md-12">
      <div class="card __online_users" data-aos="fade-up" data-aos-delay="500">
          <div class="card-header bg-transparent border-0" data-aos="fade-up" data-aos-delay="450"><h4 class="mt-4">Users <small id="__user_count">(--)</small></h4></div>
          <div class="card-body">
            <div class="__online_users_list text-center"></div>
          </div>
      </div>
    </div>
</div>
</div>
@endsection

@section('scripts')
<script defer>
  window.onload = ()=>{
      const onlineUserOutput = document.querySelector('.__online_users_list');
      const userCount = document.querySelector('#__user_count');
      // const channel = Echo.channel(`public.onlineusers.1`)

      // channel.subscribed(() => {
      //   console.log('You are now online.');
      // }).listen('.online-users', (event) => {
      //   if(event.online){
      //     loadUserOnline();
      //   }
      // })
      Echo.channel('public.onlineusers.1')
      .listen('.online-users', (event) => {
        if(event.online){
          loadUserOnline();
        }
      });

      // get all user online
      async function loadUserOnline(){
        await axios.get('/load-user-online')
            .then(function (response) {
                if(response.status == 200){
                    onlineUserOutput.innerHTML = response.data.online_users;
                    userCount.innerHTML = `(${response.data.all_users})`;
                }
            })
            .catch(function (error) {
                console.log(error);
            })
      }
      loadUserOnline()
  }
</script>
@endsection