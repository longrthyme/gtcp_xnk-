@extends($templatePath .'.layouts.index')

@section('seo')
@include($templatePath .'.layouts.seo', $seo??[] )
@endsection

@section('content')
<section class="py-5 my-post bg-light  position-relative">
    <div class="container">
        <div class="row justify-content-end">
            <div class="col-lg-3  col-12 mb-4">
                @include($templatePath .'.customer.includes.sidebar-customer')
            </div>
            <div class="col-lg-9 col-12">
                <div class="section-title mb-3 text-center">
                  <h4>Đơn hàng của bạn</h4>
                </div>
                <div class="table-responsive">          
                	<table class="table tbl-my-reviews">
                		<thead>
                		  <tr>
                		    <th>Mã đơn hàng</th>
                            <th>Tên</th>
                            <th>Thời gian đặt</th>
                            <th>Thành tiền</th>
                            <th>Thanh toán</th>
                            <th>Trạng thái đơn hàng</th>
                            <th></th>
                		  </tr>
                		</thead>
                		<tbody>
                            @foreach($data_order as $data)
                                @php
                                    $payment = \App\Model\PaymentRequest::where('cart_id', $data->cart_id)->first();
                                @endphp
                    			<tr class="alternate">
                                    <td scope="row" id="column-{{$data->cart_id}}">
                                        <a href="{{route('customer.myordersdetail', array($data->cart_id))}}" ><b>{{ $data->cart_code }}</b></a>
                                    </td>
                                    <td class="name column-name">
                                        <a href="{{route('customer.myordersdetail', array($data->cart_id))}}" >{{$data->firstname}} {{$data->lastname}}</a>
                                    </td>
                                    <td>
                                        {{$data->created_at}}
                                    </td>
                                    <td>
                                        <span style="color:#F00;">{!! render_price($data->cart_total + $data->shipping_cost) !!}</span>
                                    </td>
                                    <td>
                                        @if($data->cart_payment == 0)
                                        <span class="badge bg-primary">{{ $orderPayment[$data->cart_payment] }}</span>
                                        @else
                                        <span class="badge bg-info">{{ $orderPayment[$data->cart_payment] }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge cart-status-{{ $data->cart_status }}">{{ $statusOrder[$data->cart_status]??'Chờ xác nhận' }}</span>
                                		<?php 
                                			/*if($data->cart_status==1)
                                                echo 'New';
                                            elseif($data->cart_status==3)
                                				echo 'Cancelled';
                                            elseif($data->cart_status==4)
                                                echo 'Processing';
                                            elseif($data->cart_status==6)
                                                echo 'Paid-Completed';
                                            elseif($data->cart_status==7)
                                                echo 'Delivery in progress';
                                			else
                    	            			echo 'Unpaid';*/
                    	                ?>
                                    </td>
                                    <td>
                                        @if($payment && $payment->status == 0)
                                        <a href="{{ $payment->payment_url }}" target="_blank">Thanh toán</a>
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
</section>
@endsection
<style type="text/css">
    .cart-status-1{
        color: #fff !important;
        background-color: #007bff!important;
    }
    .cart-status-2{
        color: #fff !important;
        background-color: #17a2b8!important;
    }
    .cart-status-3{
        color: #fff !important;
        background-color: #dc3545!important;
    }
    .cart-status-4{
        background-color: #ffc107!important;
    }
    .cart-status-5{
        background-color: #28a745!important;
    }

</style>