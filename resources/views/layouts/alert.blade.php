{{-- ERRORS MESSAGE --}}
@if ($errors->any())
<div class="alert alert-danger d-flex align-items-center" role="alert">
    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
    <div>
        <ul>
            @php $counter = 0; @endphp
            @foreach ($errors->all() as $error)
                @php $counter++; @endphp
                  <li><small>{{ $error }}</small></li>
            @endforeach
        </ul>
    </div>
  </div>
@endif

{{-- session MESSAGE --}}
@if(session()->has('info'))
<div class="alert alert-info alert-dismissible fade show" role="alert">
    <strong>Information!</strong> {{ session()->get('info') }}
    <i class="ti-close float-right" data-bs-dismiss="alert" aria-label="Close"></i>
</div>
@endif

{{-- session MESSAGE --}}
@if(session()->has('warning'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Information!</strong> {{ session()->get('warning') }}
    <i class="ti-close float-right" data-bs-dismiss="alert" aria-label="Close"></i>
</div>
@endif