@extends($templatePath.'.layout')

@section('seo')
@endsection

@section('content')
    
    <div class="block-archive">
        <div class="container my-lg-4 my-3">
            <div class='page-content'>
                <div class="page-wrapper">                    
                    <div class="row">
                        <div class="col-lg-3">
                            @include($templatePath .'.author.sidebar')
                        </div>
                        <div class="col-lg-9 mx-auto">
                            <div class="bg-white p-3">
                                <form action="" method="POST" class="position-relative border p-3" id="form-baogia">
                                    @csrf()

                                    <h5>Vui lòng nhập thông tin dịch vụ để nhà cung cấp có thể báo giá tốt</h5>
                                    <div class="row g-4">
                                        
                                        <div class="col-lg-12">
                                            <div class="optionItem">
                                                <div class="input-boder ">
                                                    <label>Tiêu đề <span>*</span></label>
                                                    <input type="text" class="form-control input-value" name="title" value="{{ old('title') }}" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="input-textarea">
                                                <label class="mb-1">Mô tả<span class="color-red">*</span></label>
                                                <textarea rows="5" name="content" class="form-control content-limit" data-limit="1500" required></textarea>
                                            </div>
                                            <div class="px-2 check-text check-text-content"><span>0</span>/1500 ký tự</div>
                                        </div>
                                        
                                        <div class="col-12 text-center dangtin-btn-action mt-3">
                                            <button type="submit" class="btn btn-custom baogia-process">Gửi</button>
                                        </div>
                                    </div>
                                    <div class="list-content-loading">
                                        <div class="half-circle-spinner">
                                             <div class="circle circle-1"></div>
                                             <div class="circle circle-2"></div>
                                        </div>
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

@push('styles')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset($templateFile .'/css/dangtin.css?ver='. time()) }}">
@endpush
@push('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="{{ asset($templateFile .'/js/dangtin.js?ver='. time()) }}" type="text/javascript"></script>
    <script>
        jQuery(document).ready(function($) {
            $('.datepicker').datepicker({
                  format: 'dd/mm/yyyy',
                  autoclose: true
            });

            $('#form-baogia').validate({
                onfocusout: false,
                onkeyup: false,
                onclick: false,
                rules: {
                    title: "required",
                    content: "required",
                    form: "required",
                    to: "required",
                },
                messages: {
                    title: "Vui lòng nhập tiêu đề",
                    content: "Vui lòng nhập nội dung",
                    form: "Vui lòng chọn thời gian bắt đầu",
                    to: "Vui lòng chọn thời gian đến",
                },
                errorElement : 'div',
                errorLabelContainer: '.errorTxtModal',
                invalidHandler: function(event, validator) {
                },
                submitHandler: function(form) {
                    $('#form-baogia').parent().find('.list-content-loading').show();
                    $('#form-baogia').find('button[type="submit"]').attr('disabled', true);
                    form.submit();
                }
            });
        });
    </script>
@endpush