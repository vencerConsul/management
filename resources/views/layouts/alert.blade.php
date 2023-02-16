{{-- ERRORS MESSAGE --}}
@if ($errors->any())
<div class="alert alert-dismissible a-error" role="alert" data-aos="fade-left" data-aos-delay="400">
    <div class="d-flex align-items-center">
        {{-- <strong class="alert-danger"><i class="ti-close"></i></strong> --}}
        <div>
            <strong>Error</strong>
            <ul>
                @php $counter = 0; @endphp
                @foreach ($errors->all() as $error)
                    @php $counter++; @endphp
                      <li class="d-flex align-items-center mt-2"><i class="ti-control-forward"></i> <small> {{ $error }}</small></li>
                @endforeach
            </ul>
        </div>
    </div>
    <i class="ti-close close-multi-msg close-alert-btn" data-bs-dismiss="alert" aria-label="Close"></i>
</div>
@endif

{{-- session MESSAGE --}}
@if(session()->has('success'))
<div class="alert alert-dismissible a-success" role="alert" data-aos="fade-left" data-aos-delay="400">
    <div class="d-flex align-items-center">
        <strong class="alert-success"><i class="ti-check"></i></strong>
        <div>
            <strong>Success</strong>
            <p class="mt-2">{{ session()->get('success') }}</p>
        </div>
    </div>
    <i class="ti-close close-alert-btn" data-bs-dismiss="alert" aria-label="Close"></i>
</div>
@endif

{{-- session MESSAGE --}}
@if(session()->has('info'))
<div class="alert alert-dismissible a-info" role="alert" data-aos="fade-left" data-aos-delay="400">
    <div class="d-flex align-items-center">
        <strong class="alert-info"><i class="ti-info-alt"></i></strong>
        <div>
            <strong>Information</strong>
            <p class="mt-2">{{ session()->get('info') }}</p>
        </div>
    </div>
    <i class="ti-close close-alert-btn" data-bs-dismiss="alert" aria-label="Close"></i>
</div>
@endif

{{-- session MESSAGE --}}
@if(session()->has('warning'))
<div class="alert alert-dismissible a-warning" role="alert" data-aos="fade-left" data-aos-delay="400">
    <div class="d-flex align-items-center">
        <strong class="alert-warning"><i class="ti-hand-stop"></i></strong>
        <div>
            <strong>Warning</strong>
            <p class="mt-2">{{ session()->get('warning') }}</p>
        </div>
    </div>
    <i class="ti-close close-alert-btn" data-bs-dismiss="alert" aria-label="Close"></i>
</div>
@endif

{{-- session MESSAGE --}}
@if(session()->has('error'))
<div class="alert alert-dismissible a-error" role="alert" data-aos="fade-left" data-aos-delay="400">
    <div class="d-flex align-items-center">
        <strong class="alert-danger"><i class="ti-hand-stop"></i></strong>
        <div>
            <strong>Error</strong>
            <p class="mt-2">{{ session()->get('error') }}</p>
        </div>
    </div>
    <i class="ti-close close-alert-btn" data-bs-dismiss="alert" aria-label="Close"></i>
</div>
@endif