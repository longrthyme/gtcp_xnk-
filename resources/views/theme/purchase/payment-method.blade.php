@php
   $method = session('payment_code');
   $payment_methods = (new \App\Models\ShopPaymentMethodItem)->getList();
   if($method == '')
      $method = $payment_methods->first()->code;
@endphp
<div class="your-payment">
@foreach($payment_methods as $index => $item)
   @php
      $active = '';
      if($index == 0 && $method == '' || $method == $item->code)
         $active = 'active';
   @endphp
   <div class="payment-item mb-3">
      <div class="custom-control custom-radio mr-2">
         <input type="radio" id="{{ $item->code }}" name="payment_method" value="{{ $item->code .'__'.$item->id }}" class="custom-control-input" {{ $active ? 'checked' : '' }}>
         <label class="custom-control-label" for="{{ $item->code }}">
             <img src="{{ asset($item->image) }}" alt="" width="50">
             {{ $item->name }}
         </label>
      </div>
      @if($item->code == 'vnpay__banks')
         @include($templatePath .'.purchase.includes.banks')
      @endif
   </div>
@endforeach
</div>