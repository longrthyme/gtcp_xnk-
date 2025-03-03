@extends($templatePath.'.layout')

@section('content')
<section class="space-ptb bg-light login py-lg-5 py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card border-0 shadow">
                    <div class="card-header fs-5">Xác thực tài khoản</div>

                    <div class="card-body">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ sc_language_render('customer.verify_email.msg_sent') }}
                            </div>
                        @endif

                        <div class="list-content-loading">
                            <div class="half-circle-spinner">
                                 <div class="circle circle-1"></div>
                                 <div class="circle circle-2"></div>
                            </div>
                        </div>

                        <form method="POST" action="" enctype="multipart/form-data" id="form-verify">
                            @csrf

                            @if($user->account_type)
                                <div class="mb-3">
                                    <label class="form-label">Logo Công ty <span class="text-danger">(*)</span></label>
                                    <input type="file" class="form-control" name="company_logo" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Giấy chứng nhận đăng ký doanh nghiệp <span class="text-danger">(*)</span></label>
                                    <input type="file" class="form-control" name="registration_paper" required>
                                </div>
                            @else
                                <div class="mb-3">
                                    <label class="form-label">CCCD (mặt trước) <span class="text-danger">(*)</span></label>
                                    <input type="file" class="form-control" name="cccd_front" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">CCCD (mặt sau) <span class="text-danger">(*)</span></label>
                                    <input type="file" class="form-control" name="cccd_back" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Hình ảnh selfie với CCCD trước ngực <span class="text-danger">(*)</span></label>
                                    <input type="file" class="form-control" name="selfie" required>
                                </div>
                            @endif

                            <button type="submit" class="btn btn-primary">Xác thực</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('#form-verify').validate({
                onfocusout: false,
                onkeyup: false,
                onclick: false,
                rules: {
                    company_logo: "required",
                    registration_paper: "required",
                    cccd_front: "required",
                    cccd_front: "required",
                    cccd_back: "required",
                },
                messages: {
                    company_logo: "Vui lòng chọn Logo Công ty",
                    registration_paper: "Vui lòng chọn Giấy chứng nhận đăng ký doanh nghiệp",
                    cccd_front: "Vui lòng chọn CCCD (mặt trước)",
                    cccd_front: "Vui lòng chọn CCCD (mặt sau)",
                    cccd_back: "Vui lòng chọn Hình ảnh selfie với CCCD trước ngực",
                },
                errorElement : 'div',
                errorLabelContainer: '.errorTxtModal',
                invalidHandler: function(event, validator) {
                },
                submitHandler: function(form) {
                    $('#form-verify').parent().find('.list-content-loading').show();
                    $('#form-verify').find('button[type="submit"]').attr('disabled', true);
                    form.submit();
                }
            });
        });
    </script>
@endpush