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
                       <h3>Lịch sử thanh toán</h3>
                   </div>
                   <div class="p-4">

				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
						
	          
				  	<table class="table bg-light" id="table_index">
				  		<thead>
				        <tr>
				            <th>Hình thức thanh toán</th>
				            <th>Khóa học</th>
				            <th>Tổng tiền</th>
				            <th>Ngày đăng ký</th>
				            <th>Trạng thái</th>
				        </tr>
				    	</thead>
				    	<tbody>
				    		@foreach($payments as $item)
				    		@php
				    			$product = (new \App\Product)->getDetail($item->package_id);
				    		@endphp
				        <tr>
				            <td>
				            	<span>{{ $item->payment_method }}</span>
				            </td>
				            <td><b>{{ $product->name??'' }}</b></td>
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