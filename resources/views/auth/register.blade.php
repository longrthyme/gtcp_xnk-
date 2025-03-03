@extends($templatePath .'.layout')

@section('content')
<section class="space-ptb bg-light login py-lg-5 py-4">
    <div class="container">
        <div class="row justify-content-center">
            @if(request('type') == 'user')
            <div class="col-lg-12">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <div class="h4 text-center mb-3">@lang('ĐĂNG KÝ TÀI KHOẢN CÁ NHÂN')</div>
                        @include('auth.registration-form')
                    </div>
                </div>
            </div>
            @elseif(request('type') == 'company')
            <div class="col-lg-12">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <div class="h4 text-center mb-3">@lang('ĐĂNG KÝ TÀI KHOẢN TỔ CHỨC')</div>
                        @include('auth.registration-company-form')
                    </div>
                </div>
            </div>
            @else
                <div class="col-lg-6">
                    <div class="card border-0 shadow">
                        <div class="card-body">
                            <h2 class="text-center mb-4">@lang('Đăng ký')</h2>
                            <h6>Vui lòng chọn loại tài khoản</h6>

                            <div class="form-check-custom form-check form-option mb-2">
                                <input type="radio" class="form-check-input" id="user" name="user_type" value="user">
                                <label for="user" class="form-option-label" data-url="{{ sc_route('register', ['type' => 'user']) }}"></label>
                                <div class="p-3">
                                    <p class="fs-6"><b>Tài khoản cá nhân</b></p>
                                    <ul>
                                        <li>Đăng tin nhanh chóng</li>
                                        <li>Tiếp cận hàng ngàn khách hàng</li>
                                        <li>* Lưu ý: tài khoản cá nhân không thể đăng tin quảng bá doanh nghiệp, báo giá dịch vụ Logistics và dịch vụ khác.</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="form-check-custom form-check form-option mb-2">
                                <input type="radio" class="form-check-input" id="vendor" name="user_type" value="vendor">
                                <label for="vendor" class="form-option-label" data-url="{{ sc_route('register', ['type' => 'company']) }}"></label>
                                <div class="p-3">
                                    <p class="fs-6"><b>Tài khoản Tổ chức</b></p>
                                    <ul>
                                        <li>Đăng tin nhanh chóng</li>
                                        <li>Tiếp cận hàng ngàn khách hàng</li>
                                    </ul>
                                </div>
                            </div>
                            <a class="btn btn-primary d-block w-100 btn-register disabled" href="javascript:;">Tiếp tục</a>
                            
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('js/intlTelInput/intlTelInput.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datetimepicker/jquery.datetimepicker.min.css')  }}">
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput-jquery.min.js"></script>
    <script src="{{ asset('js/intlTelInput/intlTelInput.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/datetimepicker/jquery.datetimepicker.full.min.js') }}"></script>

    <script>
       jQuery(document).ready(function($) {
            $('.datetime_js').datetimepicker({
                format: 'd-m-Y',
                timepicker:false,
                mask:true
            });

          $('.form-option-label').click(function(){
             $('.btn-register').attr('href', $(this).data('url')).removeClass('disabled');
          });

        var phone_number = document.querySelector("#phone_number");
        window.intlTelInput(phone_number, {
            hiddenInput: "full_phone",
            preferredCountries: ["vn","us","sg","cn","ca"],
            utilsScript: "{{ asset('js/intlTelInput/utils.js') }}"
        });

        var account_type = $('input[name="account_type"]').val();
        $('select[name="type"]').on('change', function(){
            if($(this).val() != 1 && account_type == 'user')
            {
                $('select[name="role"]').attr('disabled', true).prop('selectedIndex',0);
                $('input[name="mst"]').closest('div').hide();
            }
            else
            {
                $('select[name="role"]').attr('disabled', false).prop('selectedIndex',0);
                $('input[name="mst"]').closest('div').show();
            }
        });

        $('form#form_register').submit(function(){
            $(this).find(':button[type=submit]').prop('disabled', true);
        });
    });
</script>
@endpush