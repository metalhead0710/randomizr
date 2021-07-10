@if (Session::has('info'))
    <div class="alert alert-info">
        <button class="close" data-dismiss="alert">
            <i class="fa fa-times"></i>
        </button>
        {{ Session::get('info') }}
    </div>
@endif
@if (Session::has('success'))
    <div class="alert alert-success">
        <button class="close" data-dismiss="alert">
            <i class="fa fa-times"></i>
        </button>
        <strong>{{ __('Success!') }}</strong> {{ Session::get('success') }}
    </div>
@endif
@if (Session::has('error'))
    <div class="alert alert-danger">
        <button class="close" data-dismiss="alert">
            <i class="fa fa-times"></i>
        </button>
        <strong>{{ __('Error') }}</strong> {{ Session::get('error') }}
    </div>
@endif
