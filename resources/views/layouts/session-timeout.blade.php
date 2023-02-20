<div class="modal show" id="session_time_out" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body pt-0 d-flex flex-column align-items-center text-center">
                <h3 class="py-4">Your Session Expired</h3>
                <div class="w-100 d-flex justify-content-center gap-4 align-items-center">
                    <p>Your session has expired. Don't worry, just log back in to pick up where you left off.</p>
                </div>
                <hr class="hr-divider">
                <div class="d-flex align-items-center justify-content-center gap-4">
                    <a href="{{ url()->current() }}" class="btn btn-info mt-2" ata-bs-dismiss="modal">Okay</a>
                </div>
            </div>
        </div>
    </div>
</div>