@php
extract($data);
@endphp

@extends($templatePath .'.layouts.index')


@section('content')
	<section class="payment-success">
    	<div class="payment-success-bg">
    		<img src="{{ asset('theme/images/bg-payment-success.jpg') }}" class="img-fluid" alt="">
    	</div>
    	<div class="container">
    		<div class="row justify-content-center py-5">
    			<div class="col-lg-6">
	    			<div class="p-3 bg-light">
		                <div class="p-3">
		                	<div class="text-center mb-4">
			                    <p><img src="{{ asset('theme/images/icons/cancel.png') }}" alt=""></p>
			                    <h2>Thanh toán không thành công</h2>
		                    </div>
		                    <div class="row mb-1">
		                    	<div class="col-md-6">Hình thức thanh toán</div>
				            	@if($payment['vnp_CardType'] == 'ATM')
				            		<div class="col-md-6 text-md-end">Thanh toán qua thẻ ATM</div>
				            	@elseif($payment['vnp_CardType'] == 'VISA')
				            		<div class="col-md-6 text-md-end">Thanh toán qua thẻ VISA</div>
				            	@else
				            		<div class="col-md-6 text-md-end">Thanh toán quét mã QRCODE</div>
				            	@endif
		                    </div>
		                    <div class="row mb-1">
		                    	<div class="col-md-6">Gói tin</div>
		                    	<div class="col-md-6 text-md-end">{{ $package->name }}</div>
		                    </div>
		                    <div class="row mb-1">
		                    	<div class="col-md-6">Ngân hàng</div>
		                    	<div class="col-md-6 text-md-end">{{ $payment['vnp_BankCode'] }}</div>
		                    </div>
		                    <div class="row mb-1">
		                    	<div class="col-md-6">Họ tên</div>
		                    	<div class="col-md-6 text-md-end">{{ auth()->user()->fullname }}</div>
		                    </div>
		                    <div class="row mb-1">
		                    	<div class="col-md-6">Số điện thoại</div>
		                    	<div class="col-md-6 text-md-end">{{ auth()->user()->phone }}</div>
		                    </div>
		                    <div class="row">
		                    	<div class="col-md-6">Email</div>
		                    	<div class="col-md-6 text-md-end">{{ auth()->user()->email }}</div>
		                    </div>
		                    <div class="row my-2 fw-bold">
		                    	<div class="col-md-6">Tổng tiền thanh toán</div>
		                    	<div class="col-md-6 text-md-end">{{ number_format($payment['vnp_Amount'] / 100) }} vnđ</div>
		                    </div>
		                    <div class="row mb-4">
		                    	<div class="col-md-6">Mã thanh toán</div>
		                    	<div class="col-md-6 text-md-end">{{ $payment['vnp_TxnRef'] }}</div>
		                    </div>
		                    <div class="text-center">
		                        <a class="btn btn-primary" href="{{url('/')}}">Trang chủ</a>
		                    </div>
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