
@extends($templatePath .'.layout')

@section('seo')
@include($templatePath .'.layouts.seo', $seo??[])
@endsection

@section('content')
<!--=================================
Login -->
<section class="space-ptb bg-light login py-lg-5 py-4">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-6 col-md-8 bg-white shadow p-lg-5 p-3 rounded-3">
         <h2 class="text-center mb-4">@lang('Đăng nhập')</h2>

         @if (count($errors) >0)
            @foreach($errors->all() as $error)
              <div class="text-danger"> {{ $error }}</div>
            @endforeach
         @endif
         @if (session('status'))
            <div class="text-danger"> {{ session('status') }}</div>
         @endif
         <div class="list-content-loading">
             <div class="half-circle-spinner">
                 <div class="circle circle-1"></div>
                 <div class="circle circle-2"></div>
             </div>
         </div>
         <form id="form-login-page" class="form-horizontal login row align-items-center" method="POST" action="">
            <div class="error-message text-danger fs-sm"></div>
               {{ csrf_field() }}
               <input type="hidden" name="url_back" value="{{ url()->previous() }}">
               <div class="mb-3 col-sm-12">
                  <label>Tên đăng nhập <span class="required">*</span></label>
                  <input type="text" class="form-control" name="username" id="username" value=""/>
               </div>
               <div class="mb-3 col-sm-12">
                  <label>Mật khẩu <span class="required">*</span></label>
                  <input class="form-control" type="password" name="password" id="password"/>
               </div>
               <div class="mb-3 col-sm-12">
                  <div class="form-check mb-2">
                     <input type="checkbox" class="form-check-input" name="remember_me" id="remember_me" value="1">
                     <label class="custom-control-label" for="remember_me">@lang('Ghi nhớ')</label>
                  </div>
               </div>
               <div class="col-12 mb-3 d-grid">
                  <button type="button" class="btn btn-primary btn-login-page">@lang('Đăng nhập')</button>
               </div>
               <div class="col-12">
                  <ul class="list-unstyled mb-1 mt-sm-0 mt-3">
                     <li class="me-1">
                        <a href="{{route('forget')}}" rel="noindex nofollow"><b>Quên mật khẩu?</b></a>
                     </li>
                     
                     <li class="me-1">
                        <a href="{{ route('register') }}" rel="noindex nofollow">
                           <b>Click vào đây để đăng ký nếu chưa có tài khoản</b>
                        </a>
                     </li>                     
                  </ul>
               </div>
         </form>

      </div>
    </div>
  </div>
</section>
<!--=================================
Login -->

@endsection

@push('scripts')
@endpush