@php
    extract($data)
@endphp

@extends($templatePath .'.layouts.index')

@section('seo')
@endsection

@section('content')

    <section class="py-5 my-post position-relative">
        <div class="container">
            <div class="row justify-content-end">
                <div class="col-lg-3  col-12">
                    @include($templatePath .'.customer.includes.sidebar-customer')
                </div>
                <div class="col-lg-9 col-12">
                    <div class="section-title mb-3 text-center">
                      <h4>Thay đổi thông tin</h4>
                    </div>
                    <form action="{{ route('customer.post.ChangePassword') }}" method="post" accept-charset="utf-8"  enctype="multipart/form-data">
                        @csrf
                        <div class="row justify-content-center">
                            <div class="col-lg-6">
                                @if (count($errors) >0)
                                    @foreach($errors->all() as $error)
                                      <div class="text-danger mb-3"> {{ $error }}</div>
                                    @endforeach
                                 @endif
                                 @if (session('status'))
                                    <div class="text-danger mb-3"> {{ session('status') }}</div>
                                 @endif
                                <div class="form-groupmb-3">
                                      <label class="mb-2">Mật khẩu hiện tại</label>
                                      <input type="password" class="form-control" name="current_password" >
                                </div>
                                <hr>
                                <div class="form-group mb-3">
                                  <label class="mb-2">Mật khẩu mới</label>
                                  <input type="password" class="form-control" name="new_password" value="">
                                </div>
                                <div class="form-group  mb-3">
                                  <label class="mb-2">Nhập lại mật khẩu mới</label>
                                  <input type="password" class="form-control" name="confirm_password" value="">
                                </div>
                            </div>
                            <div class="form-group col-md-12 mb-3 text-center">
                              <button type="submit" class="btn btn-primary">Cập nhật</button>
                            </div>
                          </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    
    @push('after-footer')
    <script src="{{ asset('theme/js/customer.js') }}"></script>
    @endpush
@endsection
