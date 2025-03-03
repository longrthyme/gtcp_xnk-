@extends('auth.layout')

@section('body_class', 'user-page')

@section('content')
<div class="content-login py-5">
    <div class="container h-100">
        <div class="row justify-content-center">
            <div class="col-lg-6">
               <div class="content-box w-100">
                  <div class="wrap-log">
                    <!--Page Title-->
                    <div class="page section-header text-center">
                        <div class="page-title">
                            <div class="wrapper"><h3 class="page-width mb-4">@lang('Forget password')</h3></div>
                          </div>
                    </div>
                    <!--End Page Title-->

                     @if (count($errors) >0)
                        @foreach($errors->all() as $error)
                          <div class="text-danger"> {{ $error }}</div>
                        @endforeach
                     @endif
                     @if (session('status'))
                        <div class="text-danger"> {{ session('status') }}</div>
                     @endif

                     <form class="form-horizontal" method="POST" action="{{ route('actionForgetPassword') }}">
                        {{ csrf_field() }}
                        <div class="form-group mb-3">
                           <input type="text" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required autofocus>
                           @if ($errors->has('email'))
                           <span class="help-block">
                           <strong>{{ $errors->first('email') }}</strong>
                           </span>
                           @endif
                        </div>
                        <div class="text-center">
                           <button type="submit" class="btn btn-primary btn-login-page" style="max-width: unset;">@lang('Tiếp tục')</button>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
        </div>
    </div>
</div>


@endsection