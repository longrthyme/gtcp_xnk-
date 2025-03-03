@extends('admin.auth.layout')
@section('seo')
@include('admin.layouts.seo', [
   'title'  => 'Đăng nhập'
])
@endsection
@section('content')
   <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
         <div class="authentication-inner">
            <!-- Register -->
            <div class="card">
               <div class="card-body">
                  <!-- Logo -->
                  <div class="app-brand justify-content-center">
                     <a href="javascript:;" class="app-brand-link gap-2">
                        <span class="app-brand-logo demo">
                           <img src="{{ asset('assets/images/logo-admin.png') }}" alt="">
                        </span>
                     </a>
                  </div>
                  <!-- /Logo -->
                  <h4 class="mb-4 text-center">Welcome to Admin Manager! 👋</h4>
                  <form id="formAuthentication" class="mb-3" action="{{ route('admin.login') }}" method="POST">
                     @csrf
                     <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email" autofocus />
                     </div>
                     <div class="mb-3 form-password-toggle">
                        <div class="d-flex justify-content-between">
                           <label class="form-label" for="password">Password</label>
                        </div>
                        <div class="input-group input-group-merge">
                           <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                           <span class="input-group-text cursor-pointer">
                              <i class="bx bx-hide"></i>
                           </span>
                        </div>
                     </div>
                     <div class="mb-3">
                        <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                     </div>
                  </form>
               </div>
            </div>
            <!-- /Register -->
         </div>
      </div>
   </div>
@endsection

@push('styles')
   <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}" />
@endpush