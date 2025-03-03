@extends($templatePath.'.layout')

@section('content')
<section class="space-ptb bg-light login py-lg-5 py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card border-0 shadow">
                    <div class="card-body py-5">
                        <div class="content_group_offer_view pb-3 text-center">
                            <p><img src="{{ asset('assets/images/circle-icon.png') }}" width="120" alt=""></p>
                            <p>Cảm ơn bạn đã cung cấp thông tin để xác thực tài khoản, chúng tôi sẽ tiến hành xác thực thông tin bạn cung cấp. Điều này sẽ mất một ít thời gian.</p>
	                		<p>Bạn vui lòng chờ thông báo tiếp theo từ chúng tôi!</p>
                            <p>Quay về <a href="{{url('/')}}" style="color: rgb(255 153 51);">Trang chủ</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
@endpush