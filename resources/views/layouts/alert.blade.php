{{-- ERRORS MESSAGE --}}
@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Warning!</strong>
    <ul>
        @php $counter = 0; @endphp
        @foreach ($errors->all() as $error)
            @php $counter++; @endphp
              <li><small>{{ $error }}</small></li>
        @endforeach
    </ul>
    <i class="ti-close close-multi-msg" data-bs-dismiss="alert" aria-label="Close"></i>
</div>
@endif

{{-- session MESSAGE --}}
@if(session()->has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success!</strong> {{ session()->get('success') }}
    <i class="ti-close float-right" data-bs-dismiss="alert" aria-label="Close"></i>
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