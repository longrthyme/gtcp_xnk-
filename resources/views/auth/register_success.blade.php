@extends($templatePath .'.layout')

@section('content')
<section class="space-ptb bg-light login py-lg-5 py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <div class="content_group_offer_view pb-3 text-center">
                            <p><img src="{{ asset('assets/images/circle-icon.png') }}" width="120" alt=""></p>
                            <p>Đăng ký tài khoản của bạn đã thành công</p>
                            <p>Vui lòng kiểm tra hộp thư để xác thực tài khoản của bạn</p>
                            <p>Quay về <a href="{{url('/')}}" style="color: rgb(255 153 51);">Trang chủ</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection