<div class="login-form">
    <div class="list-content-loading">
        <div class="half-circle-spinner">
            <div class="circle circle-1"></div>
            <div class="circle circle-2"></div>
        </div>
    </div>
    <form action="{{route('customer.login')}}" method="POST" id="loginModalForm">
        @csrf
        <input type="hidden" name="current_url" value="{{ url()->current() }}">
        <div class="input-group mb-3">
            <span class="input-group-text"><i class="far fa-user"></i></span>
            <input type="email" required class="form-control" name="account" placeholder="Email / Phone">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text"><i class="far fa-lock-alt"></i></span>
            <input type="password" required class="form-control" name="password" placeholder="Password">
        </div>
        <div class="col-12 mb-3 ">
            <div class="error-message text-danger fs-sm"></div>
        </div>
        <button type="button" class="btn btn-primary w-100 mb-3 btn-login">{{ __('login') }}</button>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1" name="remember_me" id="remember">
            <label class="form-check-label" for="remember">{{ __('keep-login') }}</label>
            <a href="{{route('forgetPassword')}}" class="small text-decoration-none float-end">{{ __('forgot-pass') }}?</a>
        </div>
    </form>
    <div class="social-login-box text-center mt-3">
        <hr style="opacity: 0.3">
        <p class="small text-center"><em>{{ __('social-login') }}</em></p>
        <a href="#" class="btn btn-primary"><i class="fab fa-facebook-square"></i> Facebook</a>
        <a href="#" class="btn btn-secondary"><i class="fab fa-google"></i> Google</a>
        <p class="mt-3">{{ __('no-account') }}? <a href="{{ route('customer.register') }}" class="text-decoration-none text-primary">{{ __('register-here') }}!</a></p>
    </div>
</div>

@push('foot-script')
    <script src="{{ asset($templatePath.'/js/customer.js?ver=1') }}"></script>
@endpush