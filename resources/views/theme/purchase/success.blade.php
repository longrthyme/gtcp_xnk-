@extends($templatePath .'.layouts.index')

@section('seo')
<title>Thanh toán thành công</title>
@endsection

@section('content')
	<section class="payment-success">
    	<div class="payment-success-bg">
    		<!-- <img src="{{ asset('/images/bg-payment-success.jpg') }}" class="img-fluid" alt=""> -->
    	</div>
    	<div class="container">
    		<div class="row justify-content-center py-5">
	    		<div class="col-lg-6">
	    			<div class="p-3 bg-light">
			        	<div class="text-center mb-4">
			                <p><img src="{{ asset('assets/images/circle-icon.png') }}" width="100" alt=""></p>
			                <h2>Thanh toán khóa học thành công</h2>
			            </div>
			            <div class="row mb-1">
			            	<div class="col-md-5">Hình thức thanh toán</div>
			            	<div class="col-md-7 text-md-end">
				            	@if($response['vnp_CardType'] == 'ATM')
				            		Thanh toán qua thẻ ATM
				            	@elseif($response['vnp_CardType'] == 'VISA')
				            		Thanh toán qua thẻ VISA
				            	@else
				            		Thanh toán quét mã QRCODE
				            	@endif
				            </div>
			            </div>
			            <div class="row mb-1">
	                    	<div class="col-md-5">Khóa học</div>
	                    	<div class="col-md-7 text-md-end">{{ $product->name }}</div>
	                    </div>
			            <div class="row mb-1">
			            	<div class="col-md-5">Ngân hàng</div>
			            	<div class="col-md-7 text-md-end">{{ $response['vnp_BankCode'] }}</div>
			            </div>
			            <div class="row mb-1">
			            	<div class="col-md-5">Họ tên</div>
			            	<div class="col-md-7 text-md-end">{{ $user->fullname }}</div>
			            </div>
			            <div class="row mb-1">
			            	<div class="col-md-5">Số điện thoại</div>
			            	<div class="col-md-7 text-md-end">{{ $user->phone }}</div>
			            </div>
			            <div class="row">
			            	<div class="col-md-5">Email</div>
			            	<div class="col-md-7 text-md-end">{{ $user->email }}</div>
			            </div>
			            <div class="row my-2 fw-bold">
			            	<div class="col-md-5">Tổng tiền thanh toán</div>
			            	<div class="col-md-7 text-md-end">{{ number_format($response['vnp_Amount'] / 100) }} vnđ</div>
			            </div>
			            <div class="row mb-4">
			            	<div class="col-md-5">Mã thanh toán</div>
			            	<div class="col-md-7 text-md-end">{{ $response['vnp_TransactionNo'] }}</div>
			            </div>
			            <div class="text-center">
			                <a href="{{url('/')}}" class="btn btn-outline-secondary btn-icon"><i class="fas fa-home"></i> Trang chủ</a>
			                <a href="{{ route('product', $product->slug) }}" class="btn btn-outline-danger  btn-icon"><i class="fas fa-external-link-alt"></i> Đến khóa học</a>
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