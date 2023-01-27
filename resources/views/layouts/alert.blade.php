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
<div class="alert alert-info" role="alert">
    <small>{{ session()->get('info') }}</small>
</div>
@endif

{{-- session MESSAGE --}}
@if(session()->has('warning'))
<div class="alert-container">
    <div class="alert-error">
        <div class="alert-header">
            <i class='bx bx-error-circle'></i>
        </div>
        <div class="alert-body">
            <small>{{ session()->get('warning') }}</small>
        </div>
        <div class="alert-footer">
            <button class="alert-close">Ok</button>
        </div>
    </div>
</div>
@endif