@php
	extract($data);
@endphp

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
                <div class="row">
                    <div class="col-lg-8">
                        <div class="page-title">
                            <h3>Chi tiết đơn hàng {{$order->cart_code}}</h3>
                        </div>
                        <div class="infor-shipping">
                            <div class="information-ship">
                                <table class="table table-striped">
                                    <tr>
                                        <td style="width: 200px;">Mã đơn hàng:</td>
                                        <td><b>{{$order->cart_code}}</b></td>
                                    </tr>
                                    
                                    <tr>
                                        <td>Trạng thái đơn hàng:</td>
                                        <td><span class="badge cart-status-{{ $order->cart_status }}">{{ $statusOrder[$order->cart_status]??'Chờ xác nhận' }}</span></td>
                                    </tr>
                                    <tr>
                                        <td>Họ tên:</td>
                                        <td>{{ $order->name }}</td>
                                    </tr>
                                    
                                    <tr>
                                        <td>Điện thoại:</td>
                                        <td>{{$order->cart_phone}}</td>
                                    </tr>
                                    <tr>
                                        <td>Email:</td>
                                        <td>{{$order->cart_email}}</td>
                                    </tr>
                                    <tr>
                                        <td>Phương thức thanh toán:</td>
                                        <td>
                                            @if($order->payment_method == 'cash')
                                                <div>- Thanh toán bằng tiền mặt khi nhận hàng</div>
                                            @elseif($order->payment_method == 'cod')
                                                <div class="mb-3">- @lang('bank_transfer')</div>
                                                <div class="ps-3">{!! htmlspecialchars_decode(setting_option('banks')) !!}</div>
                                            @else
                                                <div>{{ trans('checkout.banks') }}</div>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Phương thức nhận hàng:</td>
                                        <td>
                                            @if($order->shipping_type == 'shipping')
                                                <div>Giao hàng nhanh</div>
                                            @else
                                                <div>Nhận hàng tại cửa hàng:</div>
                                                <div class="mt-3">{!! htmlspecialchars_decode(setting_option('pickup_address')) !!}</div>
                                            @endif
                                        </td>
                                    </tr>
                                    @if($order->shipping_type == 'shipping')
                                        @php
                                            $address_full = implode(', ', array_filter([$order->cart_address , $order->ward, $order->district, $order->province]));
                                        @endphp
                                    <tr>
                                        <td>Địa chỉ nhận hàng</td>
                                        <td>{{ $address_full }}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td>Trạng thái thanh toán:</td>
                                        <td>
                                            @if($order->cart_payment == 1)
                                                <span class="badge bg-info">{{ $orderPayment[$order->cart_payment] }}</span>
                                            
                                            @else
                                                <span class="badge bg-primary">{{ $orderPayment[$order->cart_payment]??'Chưa thanh toán' }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Phí vận chuyển:</td>
                                        <td>
                                            {!! render_price($order->shipping_cost) !!}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Ghi chú:</td>
                                        <td>{{$order->cart_note}}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="page-title mb-3">
                            <h3>Thông tin vận chuyển</h3>
                        </div>
                        @if($shipping_code !='')
                            <ul class="shipping_log">
                            @if(!empty($shipping_log))
                               <li class="d-flex mb-3">
                                  <div class="me-3">
                                     <i class="fas fa-hand-point-right"></i> 
                                  </div>
                                  <div>
                                     Người gửi đang chuẩn bị hàng
                                     <span class="d-block text-primary" style="font-size: 14px;">{{ date('d-m-Y H:i', strtotime($shipping_log['order_date'])) }}</span>
                                  </div>
                               </li>
                               @php $active = ''; @endphp
                               @foreach($shipping_log['log'] as $index => $log)
                                  @php
                                     if($index == count($shipping_log))
                                        $active = 'active';
                                  @endphp
                                  <li class="d-flex mb-3 {{ $active }}">
                                     <div class="me-3">
                                        <i class="fas fa-hand-point-right"></i> 
                                     </div>
                                     <div>
                                        @if($log['status'] == 'cancel')
                                           <span>Đơn hàng đã bị hủy</span>
                                        @elseif($log['status'] == 'picking')
                                           <span>Đang lấy hàng</span>
                                        @endif
                                        <span class="d-block text-primary" style="font-size: 14px;">{{ date('d-m-Y H:i', strtotime($shipping_log['updated_date'])) }}</span>
                                     </div>
                                     
                                  </li>
                               @endforeach
                            @else
                               <li class="active"><i class="fas fa-hand-point-right"></i> Người gửi đang chuẩn bị hàng</li>
                            @endif
                            </ul>
                         @else
                            <div>
                               Chưa có thông tin
                            </div>
                         @endif
                    </div>
                </div>

                <h3 class="order-product-detail mb-2">List products</h3>
                <div class="myorder-detail">          
                	<div class="table-responsive">          
                    <?php
                        // $total_price = isset($order_detail->cart_total) ? $order_detail->cart_total : '';
                        
                        $total_price = isset($order_detail->total) ? $order_detail->total : '';
                        
                            $url_img_sp='/images/product/';
                            $j=0;
                            $count=0;
                            $cart_id=0;
                            $Products=array();
                            $List_cart="";
                            $bg_child_tb="";
                    ?>
                    <table class="table table-striped" id="tbl-order-detail">
                          <thead>
                            <tr>
                              <th class="text-center" width="30">No</th>
                              <th class="text-center" width="100">Hình ảnh</th>
                              <th class="text-center">Tên SP</th>
                              <th class="text-center">Giá</th>
                              <th class="text-center">SL</th>
                              <th class="text-center">Thành tiền</th>
                            </tr>
                          </thead>
                            <tfoot>
                                <tr>
                                    <td colspan="3">&nbsp;</td>
                                    <td colspan="2" style="text-align: right;"><strong>Vận chuyển</strong></td>
                                    <td colspan="2" style="text-align: right;">
                                        <span class="sum_price"> 
                                            <b>{!! render_price($order->shipping_cost) !!}</b>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">&nbsp;</td>
                                    <td colspan="2" style="text-align: right;"><strong>Tổng tiền </strong></td>
                                    <td colspan="2" style="text-align: right;">
                                        <span class="sum_price"> 
                                            <b>{!! render_price( $order->cart_total + $order->shipping_cost) !!}</b>
                                        </span>
                                    </td>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach($order_detail as $index => $item)
                                @php
                                    $product = \App\Product::find($item->product_id);
                                @endphp
                                <tr>
                                    <td>{{ $index+1 }}</td>
                                    <td><img src="{{ asset($product->image) }}" onerror="if (this.src != '/assets/images/no-image.jpg') this.src = '/assets/images/no-image.jpg';" style="width: 70px;"/></td>
                                    <td style="border-left-color: rgb(203, 203, 203);">
                                        <a href="{{ route('shop.detail', $product->slug) }}" target="_blank">{{ $product->name }}</a>
                                    </td>
                                    <td align="center"><span style="color:#F00;">{!! render_price($item->subtotal / $item->quanlity) !!}</span></td>
                                    <td align="center">
                                        <b>{{ $item->quanlity }}</b>
                                    </td>
                                    <td align="center"><span class="red">{!! render_price($item->subtotal) !!}</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
@endsection