@extends('auth.layout')

@section('body_class', 'user-page')

@section('content')
<div class="content-login py-5">
    <div class="container h-100">
        <div class="row justify-content-center">
            <div class="col-lg-6">
               <div class="content-box w-100">
                  <div class="wrap-log">
                 <div class="section-title">
                      <h3 class="text-center">@lang('Quên mật khẩu - Bước 2')</h3>
                    </div>
                     
                     @if (count($errors) >0)
                           @foreach($errors->all() as $error)
                             <div class="text-danger"> {{ $error }}</div>
                           @endforeach
                        @endif
                        @if (session('status'))
                           <div class="text-danger"> {{ session('status') }}</div>
                        @endif

                        <form class="form-horizontal" method="POST" action="{{ route('actionForgetPassword_step2') }}">
                           {{ csrf_field() }}
                           <div class="input-group form-group mb-3">
                              <input type="text" name="otp_mail" placeholder="OTP in email" class="txt_id form-control" required autofocus>
                              @if ($errors->has('otp_mail'))
                              <span class="help-block">
                              <strong>{{ $errors->first('otp_mail') }}</strong>
                              </span>
                              @endif
                           </div>
                           <div class="form-group text-center">
                              <button type="submit" class="btn btn-primary btn-login-page" style="max-width: unset;">@lang('Tiếp tục')</button>
                           </div>
                        </form>
                  </div>
                  </div>
               </div>
            </div>
        </div>
    </div>
</div>


@endsection
