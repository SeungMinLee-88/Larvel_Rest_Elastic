@if (session()->has('flash_notification.0.message'))
    <div class="alert alert-{{ session('flash_notification.0.level') }} alert-dismissible flash-message" role="alert">
        <button type="button" class="close" data-dismiss="alert">
            <span aria-hidden="true">&times;</span>
            <span class="sr-only">Close</span>
        </button>
        {{ session('flash_notification.0.message') }}
    </div>
@endif

@if ($errors->count())
    <div class="alert alert-danger alert-dismissible flash-message" role="alert">
        <button type="button" class="close" data-dismiss="alert">
            <span aria-hidden="true">&times;</span>
            <span class="sr-only">Close</span>
        </button>
        Some errors found in the form. Please review and correct them and retry !
    </div>
@endif
