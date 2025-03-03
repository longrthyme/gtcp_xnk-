@extends($templatePath .'.layout')

@section('seo')
@include($templatePath .'.layouts.seo', $seo??[] )
@endsection

@section('content')
	<section class="payment-success py-lg-5 py-3">
    	<div class="container">
	    	<div class="row justify-content-center">
		    	<div class="col-lg-5">
		    		<div class="payment-success-bg text-center">
			    		<img src="{{ asset('assets/images/none.png') }}" alt="" width="200">
			    	</div>

			       <div class="p-3">
			       	<div class="text-center mb-4">
			              <p><img src="{{ asset('theme/images/icons/cancel.png') }}" alt=""></p>
			              <h2>Thanh toán không thành công</h2>
			           </div>
			           <div class="row mb-1">
			           	<div class="col-md-6">Hình thức thanh toán</div>
			           	@if($payment->payment_method == 'ATM')
			           		<div class="col-md-6 text-md-end">Thanh toán qua thẻ ATM</div>
			           	@elseif($payment->payment_method == 'VISA')
			           		<div class="col-md-6 text-md-end">Thanh toán qua thẻ VISA</div>
			           	@else
			           		<div class="col-md-6 text-md-end">Thanh toán quét mã QRCODE</div>
			           	@endif
			           </div>
			           @if(!empty($package))
			           <div class="row mb-1">
			              	<div class="col-md-6">Gói tin</div>
			              	<div class="col-md-6 text-md-end">{{ $package->name }}</div>
			           </div>
			           @endif
			           <div class="row mb-1">
			           	<div class="col-md-6">Ngân hàng</div>
			           	<div class="col-md-6 text-md-end">{{ $payment->bank_code }}</div>
			           </div>
			           <div class="row my-2 fw-bold">
			           	<div class="col-md-6">Tổng tiền thanh toán</div>
			           	<div class="col-md-6 text-md-end">{!! render_price($payment->amount) !!}</div>
			           </div>
			           <div class="row mb-4">
			           	<div class="col-md-6">Mã thanh toán</div>
			           	<div class="col-md-6 text-md-end">{{ $payment->payment_code }}</div>
			           </div>
			           <div class="text-center">
			               <a class="btn btn-primary" href="{{url('/')}}">Trang chủ</a>
			           </div>
			       </div>
		    	</div>
	    	</div>
    	</div>
	</section>
@push('after-footer')
	<script>
		jQuery(document).ready(function($) {
			$('#notifyModal').modal('show');
			$('#notifyModal').on('hidden.bs.modal', function (e) {
                window.location.href="/";
            })
		})
	</script>
@endpush
@endsection