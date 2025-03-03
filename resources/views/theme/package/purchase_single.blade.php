@extends($templatePath .'.layouts.index')

@section('seo')
@include($templatePath .'.layouts.seo', $seo??[] )
@endsection

@section('body_class', 'user-page')
@section('content')
<section class="filmoja-pricing-area my-5 bg-light">
   <div class="container">
      
      <div class="row justify-content-center">
         <div class="col-lg-8">
            <div class="my-3 p-3 bg-white">
               <div class="text-center mb-4">
                  <h3>NÂNG CẤP TÀI KHOẢN</h3>
               </div>
               <div class=" mb-1">
                  Mã đơn: <b>{{ $payment->payment_code }}</b> 
                  <button class="btn btn-primary btn-copy" style="margin-left:5px;padding:1px 2px;vertical-align: middle;font-size: 12px;" data-clipboard-text="{{ $payment->payment_code }}">Copy</button>
               </div>
               <div class=" mb-1">
                  Đơn hàng: <b>{{ $package->name }}</b>
               </div>
               <div class=" mb-1">
                  Số tiền thanh toán: <b class="text-danger">{{ number_format($payment->amount) }}đ</b>
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

               @else
               <div>Thời gian kích hoạt: Nếu chuyển khoản, tài khoản của bạn sẽ được <b>nâng cấp</b> ngay sau khi website xác nhận đã nhận được tiền vào tài khoản</div>

               <hr class="mt-3">
               {{--
               <form action="{{ route('purchase.payment') }}" method="post">
                  @csrf()
                  <input type="hidden" name="payment_id" value="{{ $payment->id }}">
                  <div class="row my-2 justify-content-center">
                     @if(Session::get('error'))
                     <div class="alert alert-primary" role="alert">{{ __(Session::get('message')) }}</div>
                     @endif
                     <div class="col-md-4 ">
                        
                        <div class="your-payment">
                           <h4 class="order-title my-4">Thanh toán online - Thuận tiện, An toàn và Bảo mật</h4>
                           <div class="d-flex align-items-center mb-3">
                              <div class="custom-control custom-radio mr-2 w-100">
                                 <input type="radio" id="bank_atm" name="payment_method" value="ATM_ON" class="custom-control-input" checked>
                                 <label class="custom-control-label" for="bank_atm">Thanh toán online bằng thẻ ATM</label>
                              </div>
                           </div>
                           <div class="d-flex align-items-center mb-3">
                              <div class="custom-control custom-radio mr-2 w-100">
                                 <input type="radio" id="bank_online" name="payment_method" value="bank_online" class="custom-control-input">
                                 <label class="custom-control-label" for="bank_online">Thanh toán online bằng thẻ quốc tế Visa/Master/JCB</label>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-12 text-center">
                        <button type="submit" class="fs-sm btn btn-primary">Thanh toán</button>
                        <a href="{{ route('purchase.cancel', $payment->id) }}" class="fs-sm btn btn-danger">Hủy đơn</a>
                     </div>
                  </div>
               </form>
               --}}

               @endif
            </div> 
         </div>

         @if($payment->status != 1)
            <div class="col-lg-8">
               <div class="my-3 p-3 bg-white">
                  <div class="text-center mb-4">
                     <h3>Thanh toán chuyển khoản</h3>
                  </div>
                  {!! setting_option('thong-tin-chuyen-khoan') !!}
                  <div>
                     Nội dung chuyển khoản: <b>{{ $payment->payment_code??'' }}</b>
                 
                     <button class="btn btn-primary btn-copy" style="margin-left:5px;padding:1px 2px;vertical-align: middle;font-size: 12px;" data-clipboard-text="{{ $payment->payment_code??'' }}">Copy</button>
                  </div>

               </div> 
            </div>
         @endif
      </div>
      
   </div>
</section>

{{--
<section class="filmoja-pricing-area my-5">
   <div class="container">
      <div class="text-left m-t-10 bg-white my-3 p-3">
         <div class="text-danger mb-2 text-center fw-bold" style="font-size: 15px;">THAM KHẢO THÊM CÁC GÓI DOWNLOAD ĐANG CÓ GIẢM GIÁ CHO BẠN</div>
         <table class="text-center table table-bordered font-weight-bold" style="font-size: 12px;">
            <tbody>
               <tr class="table-danger">
                  <th>Gói VIP</th>
                  <th>Thông tin</th>
                  <th>Giá</th>
                  <th></th>
               </tr>
               @foreach($packages as $package)
               <tr>
                  <td>{{ $package->name }}</td>
                  <td>
                     <div>Thời gian: <b>{{ $package->max_day }}</b> ngày</div>
                     <div>Download: <b>{{ $package->download }}</b> lượt</div>
                  </td>
                  <td class="text-left">
                     Giá gốc: 
                     @if($package->promotion != 0)
                        @php
                           $price_sale = 100 - ($package->promotion * 100 / $package->price);
                        @endphp
                        <span style="text-decoration-line: line-through; font-size:14px; color: #999;">{{ number_format($package->price) }}đ</span> -{{ number_format($price_sale) }}%<br>
                        Chỉ còn: <span style="color:red;font-size:16px;">{{ number_format($package->promotion) }}đ</span>
                     @else
                        Giá: <span style="color:red;font-size:16px;">{{ number_format($package->price) }}đ</span>
                     @endif
                     @if($package->code == "VIPDB")
                        <div>Liên hệ hotline: <a href="tel:{{ setting_option('hotline') }}">{{ setting_option('hotline') }}</a> để đặt lịch.</div>
                     @endif
                  </td>
                  <td>
                     <a href="{{ $package->getUrl() }}" class="btn btn-danger">Mua ngay</a>
                  </td>
               </tr>
               @endforeach
            </tbody>
         </table>
      </div>
   </div>
</section>
--}}

@endsection

@push('styles')
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
      $('.select-package').click(function(){
         var id = $(this).attr('data');
         $('.single-pricing-box').removeClass('active');
         $(this).closest('.single-pricing-box').addClass('active');
         $('.payment-content').show();

         $('input[name="package_id"]').val(id);
      });

      var paymentCheckout = $('#paymentCheckout');
      if(paymentCheckout.length>0){
         paymentCheckout.validate({
          onfocusout: false,
          onkeyup: false,
          onclick: false,
          rules: {
              bank_code: "required",
              amount: "required",
          },
          messages: {
              bank_code: "Vui lòng chọn hình thức thanh toán",
              amount: "Vui lòng nhập số tiền bạn muốn nạp",
          },
          errorElement : 'div',
          errorLabelContainer: '.errorTxt',
          invalidHandler: function(event, validator) {
              $('html, body').animate({
                  scrollTop: 0
              }, 500);
          }
      });

      $('input[name="amount"]').on('input', function(){
        $(this).val(POTENZA.number_format($(this).val()))
      })
      
      $('.btn-payment-checkout').click(function(){
        if(paymentCheckout.valid()){
          var bank_code = '';
          var bank_code_list = $('.select-include').find('input[type="radio"]');
          if(bank_code_list.length > 0)
           bank_code = $("input[type='radio'][name='bank_code']:checked").val();
            else
              bank_code = $('input[name="bank_code"]').val('');

            if(bank_code)
              paymentCheckout.submit();
            else{
              $('html,body').animate({
                  scrollTop: $(".select-include").offset().top
              }, 'slow');
            }
         
          
        }
      })
    }
   });
</script>
@endpush