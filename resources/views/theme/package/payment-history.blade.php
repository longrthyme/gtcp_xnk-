@extends($templatePath .'.layouts.index')

@section('seo')
@include($templatePath .'.layouts.seo', $seo??[] )
@endsection

@section('content')
<section class="py-5 my-post position-relative">
  <div class="container">
  	<div class="row">
      <div class="col-lg-3  col-12 mb-4">
             @include($templatePath .'.customer.includes.sidebar-customer')
      </div>

	    <div class="col-lg-9 col-12" >
	    	<div class="customer-form-content h-100">
           <div class="customer-form register-form ">
               <div class="position-relative">
                   <div class="customer-form-top p-4 text-center">
                       <img src="/images/login-logo.png" width="90">
                       <h3>Lịch sử mua gói</h3>
                   </div>
                   <div class="p-4">
				<ul class="nav nav-tabs" id="myTab" role="tablist" style="display: none;">
					<li class="nav-item" role="presentation">
						<button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Xu đã nạp</button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Xu đã tiêu</button>
					</li>
				</ul>

				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
						
	          
				  	<table class="table bg-light" id="table_index">
				  		<thead>
				        <tr>
				            <th>Hình thức thanh toán</th>
				            <th>Gói VIP</th>
				            <th>Tổng tiền</th>
				            <th>Ngày nạp</th>
				            <th>Trạng thái</th>
				        </tr>
				    	</thead>
				    	<tbody>
				    		@foreach($payments as $item)
				        <tr>
				            <td>
				            	@if($item->payment_method == 'momo_wallet') <span>Ví MoMo</span>
				            	@elseif($item->payment_method == 'VNPay Bank')
				            	<span>{{ $item->payment_method .' '. $item->bank_code }}</span>
				            	@else
				            	<span>Đang cập nhật</span>
				            	@endif
				            </td>
				            <td><b>{{ $item->package?$item->package['name']:'' }}</b></td>
				            <td class="text-primary">{{ number_format($item->amount) }} vnđ</td>
				            <td>{{ $item->created_at }}</td>
				            <td>
				            	@if($item->status == 1)
				            		<span class="badge bg-success">Thành công</span>
				            	@else
				            		@php
                          $created_at = str_replace('/', '-', $item->created_at);
                          $created_at = \Carbon\Carbon::parse($created_at);
                          $duration = $created_at->diffInDays(now(), true);
                        @endphp
                        @if($duration >1 && $created_at < now())
				            		<span class="badge bg-warning">Hết hạn</span>
				            		@else
				            		<span class="badge bg-warning">Đang xử lý</span>
				            		@endif
				            	@endif
				            </td>
				        </tr>
				        @endforeach
				      </tbody>
				  	</table>
					</div>
				</div>

			</div>
			</div>
			</div>
			</div>
	  </div>
  </div>
</section>
@endsection

@push('head-style')
<style type="text/css">
	.badge{
		font-weight: normal;
		font-size: 14px;
	}
	.dataTables_paginate .pagination .page-link{
		border-radius: 0 !important;
	}
</style>
@endpush
@push('foot-script')

 
<script type="text/javascript" src="//cdn.datatables.net/v/bs4/dt-1.11.5/datatables.min.js"></script>

	<script type="text/javascript">
		$(document).ready(function() {
	    $('#table_index').DataTable();
	    $('#table_index tbody').on('click', 'tr', function () {
	        var data = table.row( this ).data();
	        alert( 'You clicked on '+data[0]+'\'s row' );
	    } );
	    $('#table_spent').DataTable();
	    $('#table_spent tbody').on('click', 'tr', function () {
	        var data = table.row( this ).data();
	        alert( 'You clicked on '+data[0]+'\'s row' );
	    } );
	} );
	</script>
@endpush