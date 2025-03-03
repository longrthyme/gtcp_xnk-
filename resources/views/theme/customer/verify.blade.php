@extends($templatePath.'.layout')

@section('content')
<section class="space-ptb bg-light login py-lg-5 py-4">
    <div class="container">
	    <div class="row justify-content-center">
	        <div class="col-lg-9">
	            <div class="card border-0 shadow">
	                <h5 class="card-header">{{ sc_language_render('customer.verify_email.title_header') }}</h5>

	                <div class="card-body">
	                    @if (session('resent'))
	                        <div class="alert alert-success" role="alert">
	                            {{ sc_language_render('customer.verify_email.msg_sent') }}
	                        </div>
	                    @endif

	                    @if(request('action') == 'sent-verify')
	                    	@php
		                    	$packages = $modelPackage->getListActive();
		                    @endphp

		                    {!! htmlspecialchars_decode($page->content) !!}
		                    {{--
		                    @if($user->type != 3)
		                    	@include($templatePath .'.package.package-list')
	                        @endif
		                    --}}
                        @else
	                    	{{ sc_language_render('customer.verify_email.msg_page_1') }}
	                    	<form class="d-inline" method="POST" action="{{ route('customer.verify_resend') }}" id="form-verify">
	                        	@csrf
	                        	<button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ sc_language_render('customer.verify_email.msg_page_2') }}</button>
	                    	</form>
	                    
	                    @endif
	                    <div class="list-content-loading">
                            <div class="half-circle-spinner">
                                 <div class="circle circle-1"></div>
                                 <div class="circle circle-2"></div>
                            </div>
                        </div>
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