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
                      <h3 class="text-center">@lang('Quên mật khẩu - Bước 3')</h3>
                    </div>
                     
                     @if (count($errors) >0)
                           @foreach($errors->all() as $error)
                             <div class="text-danger"> {{ $error }}</div>
                           @endforeach
                        @endif
                        @if (session('status'))
                           <div class="text-danger"> {{ session('status') }}</div>
                        @endif

                        <form class="form-horizontal" method="POST" action="{{ route('actionForgetPassword_step3') }}">
                           {{ csrf_field() }}
                           <div class="input-group form-group mb-3">
                              <input type="password" name="new_password" class="form-control" placeholder="Mật khẩu mới" required autofocus>
                              @if ($errors->has('new_password'))
                              <span class="help-block">
                              <strong>{{ $errors->first('new_password') }}</strong>
                              </span>
                              @endif
                           </div>
                           <div class="input-group form-group mb-3">
                              <input type="password" class="form-control" placeholder="Xác nhận mật khẩu mới" name="confirm_new_password" required>
                              @if ($errors->has('confirm_new_password'))
                              <span class="help-block">
                              <strong>{{ $errors->first('confirm_new_password') }}</strong>
                              </span>
                              @endif
                           </div>
                           <div class="form-group text-center">
                              <button type="submit" class="btn btn-primary btn-login-page" style="max-width: unset;">@lang('Đổi mật khẩu')</button>
                           </div>
                        </form>
                  </div>
               </div>
            </div>
        </div>
    </div>
</div>


@endsection

