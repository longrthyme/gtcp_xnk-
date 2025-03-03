@extends($templatePath .'.layouts.index')

@section('seo')
@include($templatePath .'.layouts.seo', $seo??[] )
@endsection

@section('body_class', 'user-page')
@section('content')
<section class="filmoja-pricing-area my-5">
   <div class="container">
      
      <div class="row justify-content-center my-5">
         <div class="col-lg-8">
            <div class="p-3 bg-white">
               <div class="text-center mb-4">
                  <h2>Bạn đã đặt mua</h2>
               </div>
               <div class=" mb-1">
                  Mã đơn: <b>{{ $payment->payment_code }}</b> 
                  <button class="btn btn-primary btn-copy" style="margin-left:5px;padding:1px 2px;vertical-align: middle;font-size: 12px;" data-clipboard-text="{{ $payment->payment_code }}">Copy</button>
               </div>
               <div class=" mb-1">
                  Khóa học: <b>{{ $package->name }}</b>
               </div>
               <div class=" mb-1">
                  Số tiền thanh toán: <b class="text-danger">{!! render_price($payment->amount) !!}</b>
               </div>
               <div class=" mb-1">
                  Thời gian: {{ date('H:i d-m-Y', strtotime($payment->created_at)) }}
               </div>
               <div class="mb-1">
                  Trạng thái: 
                  @if($payment->status == 1)
                  <span class="text-success">Đã thanh toán</span>
                  @else
                  <span class="text-danger">Chưa thanh toán</span>
                  @endif
               </div>
               @if($payment->status == 1)

               @elseif($payment->status == 3)
               <hr class="mt-3">
                  <p>Đơn hàng đã hủy</p>
               @else
               <div>Thời gian kích hoạt: Ngay lập tức khi chuyển khoản</div>

               <hr class="mt-3">
               <form action="{{ route('purchase_checkout.payment') }}" method="post">
                  @csrf()
                  <input type="hidden" name="payment_id" value="{{ $payment->id }}">
                  <div class="row justify-content-center">
                     @if(Session::get('error'))
                     <div class="alert alert-primary" role="alert">{{ __(Session::get('message')) }}</div>
                     @endif
                     <div class="col-md-12 ">
                        
                        <div class="your-payment">
                           <h4 class="order-title my-4">Phương thức thanh toán</h4>
                           @include($templatePath . '.purchase.payment-method')
                        </div>
                     </div>
                     <div class="col-md-12 text-center">
                        <button type="submit" class="fs-sm btn btn-primary">Thanh toán</button>
                        <a href="{{ route('purchase.cancel', $payment->id) }}" class="fs-sm btn btn-danger">Hủy đơn</a>
                     </div>
                  </div>
               </form>

               @endif
               @if($payment->status != 1)
               <hr class="mt-3">
               <h4 class="order-title my-4">Thông tin chuyển khoản và thanh toán</h4>
               {!! setting_option('thong-tin-chuyen-khoan') !!}
               <div>
                  Nội dung chuyển khoản: <b>{{ $payment->payment_code??'' }}</b>
                  <button class="btn btn-primary btn-copy" style="margin-left:5px;padding:1px 2px;vertical-align: middle;font-size: 12px;" data-clipboard-text="{{ $payment->payment_code??'' }}">Copy</button>
               </div>
               @endif
            </div> 
         </div>
      </div>
   </div>
</section>

@endsection

@push('styles')
   <style type="text/css">
      .filmoja-pricing-area{
         font-size: 14px;
         color: #000;
      }
      .filmoja-pricing-area .btn{
         font-size: 13px;
         border-radius: 3px;
      }
   </style>
@endpush
@push('scripts')
   <script src="{{ asset( $templateFile .'/js/clipboard.min.js' ) }}"></script>
<script>
   var clipboard = new ClipboardJS('.btn-copy', {
      target: function () {
         return document.querySelector('button');
      },
   });

   clipboard.on('success', function (e) {
     e.trigger.innerHTML = '<i class="fas fa-check"></i> Copied!';
     setTimeout(function() { 
        e.trigger.innerHTML = 'Copy';
    }, 1000);
   });

   clipboard.on('error', function (e) {
     console.info('Action:', e.action);
     console.info('Text:', e.text);
     console.info('Trigger:', e.trigger);
   });

   jQuery(document).ready(function($) {
      $('input[name="payment_method"]').change(function(){
         $('.banklist').hide();
         $(this).closest('.payment-item').find('.banklist').show();
      });
   });
</script>
@endpush