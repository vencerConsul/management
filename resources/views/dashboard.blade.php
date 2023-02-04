@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-md-12 grid-margin">
          <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
              <h3 class="font-weight-bold">Welcome {{Auth::user()->name}}</h3>
              <h6 class="font-weight-normal mb-0">{{Auth::user()->position}}</h6>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
          <div class="card tale-bg">
            <div class="card-people mt-auto">
              <img class="weather-img" src="" alt="weather">
              <div class="weather-info">
                <div class="d-flex">
                  <div>
                    <h2 class="mb-0 font-weight-normal"><i class="ti-pin mr-2"></i><span class="weather-tamp">0</span><sup>C</sup></h2>
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
        <div class="col-md-6 grid-margin transparent">
          <div class="row">
            <div class="col-md-6 mb-4 stretch-card transparent">
              <div class="card card-tale">
                <div class="card-body">
                  <p class="mb-4">Today’s Bookings</p>
                  <p class="fs-30 mb-2">4006</p>
                  <p>10.00% (30 days)</p>
                </div>
              </div>
            </div>
            <div class="col-md-6 mb-4 stretch-card transparent">
              <div class="card card-dark-blue">
                <div class="card-body">
                  <p class="mb-4">Total Bookings</p>
                  <p class="fs-30 mb-2">61344</p>
                  <p>22.00% (30 days)</p>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
              <div class="card card-light-blue">
                <div class="card-body">
                  <p class="mb-4">Number of Meetings</p>
                  <p class="fs-30 mb-2">34040</p>
                  <p>2.00% (30 days)</p>
                </div>
              </div>
            </div>
            <div class="col-md-6 stretch-card transparent">
              <div class="card card-light-danger">
                <div class="card-body">
                  <p class="mb-4">Number of Clients</p>
                  <p class="fs-30 mb-2">47033</p>
                  <p>0.22% (30 days)</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 stretch-card grid-margin">
          <div class="card">
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
        <div class="col-md-6 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">To Do Lists</h4>
                <div class="list-wrapper pt-2">
                    <ul class="d-flex flex-column-reverse todo-list todo-list-custom">
                        <li>
                            <div class="form-check form-check-flat">
                                <label class="form-check-label">
                                    <input class="checkbox" type="checkbox">
                                    Meeting with Urban Team
                                </label>
                            </div>
                            <i class="remove ti-close"></i>
                        </li>
                        <li class="completed">
                            <div class="form-check form-check-flat">
                                <label class="form-check-label">
                                    <input class="checkbox" type="checkbox" checked>
                                    Duplicate a project for new customer
                                </label>
                            </div>
                            <i class="remove ti-close"></i>
                        </li>
                        <li>
                            <div class="form-check form-check-flat">
                                <label class="form-check-label">
                                    <input class="checkbox" type="checkbox">
                                    Project meeting with CEO
                                </label>
                            </div>
                            <i class="remove ti-close"></i>
                        </li>
                        <li class="completed">
                            <div class="form-check form-check-flat">
                                <label class="form-check-label">
                                    <input class="checkbox" type="checkbox" checked>
                                    Follow up of team zilla
                                </label>
                            </div>
                            <i class="remove ti-close"></i>
                        </li>
                        <li>
                            <div class="form-check form-check-flat">
                                <label class="form-check-label">
                                    <input class="checkbox" type="checkbox">
                                    Level up for Antony
                                </label>
                            </div>
                            <i class="remove ti-close"></i>
                        </li>
                    </ul>
                  </div>
                <div class="add-items d-flex mb-0 mt-2">
                    <input type="text" class="form-control todo-list-input"  placeholder="Add new task">
                    <button class="add btn btn-icon text-primary todo-list-add-btn bg-transparent"><i class="icon-circle-plus"></i></button>
                </div>
            </div>
          </div>
        </div>
      </div>
      {{-- <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <p class="card-title">Advanced Table</p>
              <div class="row">
                <div class="col-12">
                  <div class="table-responsive">
                    <table id="example" class="display expandable-table" style="width:100%">
                      <thead>
                        <tr>
                          <th>Quote#</th>
                          <th>Product</th>
                          <th>Business type</th>
                          <th>Policy holder</th>
                          <th>Premium</th>
                          <th>Status</th>
                          <th>Updated at</th>
                          <th></th>
                        </tr>
                      </thead>
                  </table>
                  </div>
                </div>
              </div>
              </div>
            </div>
          </div>
        </div>
    </div> --}}
    <!-- content-wrapper ends -->
</div>
@endsection