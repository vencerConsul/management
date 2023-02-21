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
    <div class="col-md-8 grid-margin">
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
                      <th class="border-bottom pb-2">Orders</th>
                      <th class="border-bottom pb-2">Users</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="pl-0">Programmer</td>
                      <td><p class="mb-0"><span class="font-weight-bold mr-2">65</span>(2.15%)</p></td>
                      <td class="text-muted">65</td>
                    </tr>
                    <tr>
                      <td class="pl-0">IT</td>
                      <td><p class="mb-0"><span class="font-weight-bold mr-2">54</span>(3.25%)</p></td>
                      <td class="text-muted">51</td>
                    </tr>
                    <tr>
                      <td class="pl-0">SEO</td>
                      <td><p class="mb-0"><span class="font-weight-bold mr-2">22</span>(2.22%)</p></td>
                      <td class="text-muted">32</td>
                    </tr>
                    <tr>
                      <td class="pl-0">WIX</td>
                      <td><p class="mb-0"><span class="font-weight-bold mr-2">46</span>(3.27%)</p></td>
                      <td class="text-muted">15</td>
                    </tr>
                    <tr>
                      <td class="pl-0">CS</td>
                      <td><p class="mb-0"><span class="font-weight-bold mr-2">17</span>(1.25%)</p></td>
                      <td class="text-muted">25</td>
                    </tr>
                    <tr>
                      <td class="pl-0">WHOLE SALE</td>
                      <td><p class="mb-0"><span class="font-weight-bold mr-2">52</span>(3.11%)</p></td>
                      <td class="text-muted">71</td>
                    </tr>
                    <tr>
                      <td class="pl-0 pb-0">Louisiana</td>
                      <td class="pb-0"><p class="mb-0"><span class="font-weight-bold mr-2">25</span>(1.32%)</p></td>
                      <td class="pb-0">14</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4 grid-margin">
      <div class="card __online_users" data-aos="fade-up" data-aos-delay="500">
          <div class="card-body">
            <h4 class="mb-4" data-aos="fade-up" data-aos-delay="450">Online Users</h4>

            <div class="__online_users_list text-center"></div>
            
          </div>
      </div>
    </div>
</div>
@endsection

@section('scripts')
<script defer>
  window.onload = ()=>{
      const onlineUserOutput = document.querySelector('.__online_users_list');
      // const channel = Echo.channel(`public.onlineusers.1`)

      // channel.subscribed(() => {
      //   console.log('You are now online.');
      // }).listen('.online-users', (event) => {
      //   if(event.online){
      //     loadUserOnline();
      //   }
      // })


      const channel = Echo.join(`online-users`)

      channel.here((users) => {
          var usersArr = [];
          users.forEach(item => {
            usersArr.push(item.id)
          });
          loadUserOnline(usersArr)
      })
      channel.joining((user) => {
          console.log(user);
      })
      channel.leaving((user) => {
        console.log(user);
      })
      channel.error((error) => {
          console.error(error);
      });


      // get all user online
      async function loadUserOnline(data){

        await axios.post('/load-user-online', data)
            .then(function (response) {
                if(response.status == 200){
                    onlineUserOutput.innerHTML = response.data.online_users;
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