<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	    <meta http-equiv="x-ua-compatible" content="ie=edge">
	    <!-- <title>{{ setting_option('company_name') }}</title> -->
	    <meta name="description" content="description">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <!-- Favicon -->
	    <link rel="shortcut icon" href="{{ asset(setting_option('favicon')) }}" />

	    @include($templatePath .'.layouts.seo', $seo??[] )

	    <!-- Customized Bootstrap Stylesheet -->
    	<link href="{{ asset($templateFile .'/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
	    <style>
	    	body {
	    		font-size: 15px;
	    		line-height: 22px;
	    		font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, sans-serif;
	    	}
	    	p{
	    		margin: 0 ;
	    	}
	    	p:last-child {
	    		margin-bottom: 0;
	    	}
	    	h2 {
	    		margin: 10px 0;
	    	}

	    </style>
	</head>
	<body>
		<div class="container">
		    <div class="row justify-content-center">
				@if(!session('baocao_auth'))
			    	<div class="col-lg-5 py-5">
			    		<form action="{{ route('api.bct_baocao_login') }}" method="post" accept-charset="utf-8">
			    			@csrf()
					        <div class="flex flex-col mb-3">
					        	<label class="mb-1">Tên đăng nhập</label>
					        	<input class="form-control" type="text" name="username" required>
					        </div>
					        <div class="mb-3">
					        	<label class="mb-1">Mật khẩu</label>
					        	<input class="form-control" type="password" name="password" required>
					        </div>
					        <button type="submit" class="btn btn-danger">Đăng nhập</button>
			    		</form>
			    	</div>
			    @else
				    <div class="col-lg-5 py-5">
				        <div class="mb-3">
				        	<p>Số lượng truy cập: {{ $data->soLuongTruyCap }}</p>
					        <h2>Số lượng người bán</h2>
					        <p>Tổng số người bán: {{ $data->soNguoiBan }}</p>
					        <p>Số lượng người bán mới: {{ $data->soNguoiBanMoi }}</p>
					        <h2>Số lượng sản phẩm</h2>
					        <p>Tổng số sản phẩm: {{ $data->tongSoSanPham }}</p>
					        <p>Số sản phẩm đăng bán mới: {{ $data->soSanPhamMoi }}</p>
					        <h2>Số lượng giao dịch</h2>
					        <p>Tổng số đơn hàng: {{ $data->soLuongGiaoDich }}</p>
					        <p>Tổng số đơn hàng thành công: {{ $data->tongSoDonHangThanhCong }}</p>
					        <p>Tổng số đơn hàng không thành công: {{ $data->tongSoDonHangKhongThanhCong }}</p>
					        <p>Tổng giá trị giao dịch: {{ $data->tongGiaTriGiaoDich }}</p>
					        </div>	
				        <a href="{{ route('api.bct_baocao_logout') }}" class="btn btn-danger">Đăng xuất</a>
				    </div>
			    @endif
			</div>
		</div>
	</body>
</html>