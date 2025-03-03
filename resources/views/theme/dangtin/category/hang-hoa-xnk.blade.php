@php
   $price = $product->price??'';
   if($price)
        $price_format = number_format($price);
   $price_max = $product->price_max??'';
   $post_type = $post_type??'';
   if($user->type == 2)
      $post_type = 'buy';

@endphp
<div class="row g-4">
   <div class="col-lg-12 text-center">
      <div class="btn-group btn-group-custom btn-group-categories" role="group" aria-label="Basic radio  toggle button group">
         @if($user->type != 2)
         <input type="radio" class="btn-check" name="post_type" id="btncheck_ban" {{ $post_type == 'sell' || $post_type == '' ? 'checked' : '' }} value="sell">
         <label class="btn btn-outline-primary" for="btncheck_ban">Hàng cần bán</label>
         @endif

         <input type="radio" class="btn-check" name="post_type" id="btncheck_mua" {{ $post_type == 'buy' ? 'checked' : '' }} value="buy">
         <label class="btn btn-outline-primary" for="btncheck_mua">Hàng cần mua</label>
      </div>
   </div>

   <div class="col-lg-12">
      <div class="optionItem">
         <div class="input-boder ">
            <label>Tên hàng hoá <span>*</span></label>
            <input type="text" class="form-control input-value" name="title" value="{{ old('title', $product->name??'') }}">
         </div>
      </div>
   </div>

   <div class="col-lg-12">
      <div class="input-textarea {{ $content?'active':'' }}">
         <label class="mb-1">Mô tả hàng hóa<span class="color-red">*</span></label>
         <textarea rows="5" name="content" class="form-control content-limit" data-limit="1500">{!! isset($product->content) ? str_replace('<br />', "\n", $product->content) : '' !!}</textarea>
      </div>
      <div class="px-2 check-text check-text-content"><span>0</span>/1500 ký tự</div>

   </div>

   <div class="col-lg-12">
      <div class="optionItem">
         <div class="input-boder {{ !empty($address) ? 'active' : '' }}">
            <label>Xuất xứ hàng hóa <span>*</span></label>
            <select class="form-control seaport" name="location_origin" data-msg-required="Chọn Xuất xứ hàng hóa" required>
               @if(!empty($address))
               <option value="{{ $address }}">{{ $address }}</option>
               @endif
            </select>
         </div>
      </div>
   </div>

   <div class="col-lg-12">
      @include($templatePath .'.dangtin.includes.option', ['id' => 42, 'value' => $product_options[42]??''])
   </div>

   <div class="col-lg-12">
        @include($templatePath .'.dangtin.includes.option', ['id' => 43, 'value' => $product_options[43]??''])
    </div>

   <div class="col-lg-6">
      <div class="optionItem">
         <div class="input-boder ">
            @if(!empty($post_type) && $post_type == 'buy')
            <label>Giá mua <span>*</span></label>
            @else
            <label>Giá bán <span>*</span></label>
            @endif
            <input type="text" class="form-control input-value number_format" name="price" value="{{ old('price', $price_format??'') }}" data-msg-required="Nhập giá bán" required autocomplete="off">
         </div>
      </div>
   </div>
   <div class="col-lg-6">
        @include($templatePath .'.dangtin.includes.option', ['id' => 136, 'value' => $product_options[136]??''])
    </div>

   <div class="col-lg-12">
      {{--@include($templatePath .'.dangtin.includes.option', ['id' => 41, 'value' => $product_options[41]??''])--}}
      <div class="optionItem">
         <div class="input-boder active">
            <label>Thời hạn báo giá </label>
            <input type="text" class="form-control input-value datepicker" name="date_available" value="{{ $date_available??'' }}" placeholder="dd/mm/yyyy" data-msg-required="Chọn Thời hạn báo giá" required >
         </div>
      </div>
    </div>

   <div class="col-lg-12 optionItem">
        <div class="input-boder {{ isset($address) && $address!='' ? 'active' : '' }}">
            @if(!empty($post_type) && $post_type == 'buy')
            <label>Địa điểm nhận hàng <span>*</span></label>
            @else
            <label>Địa điểm giao hàng <span>*</span></label>
            @endif
            <select class="form-control seaport" name="address_end">
               @if(!empty($address_end))
                  <option value="{{ $address_end }}">{{ $address_end }}</option>
               @endif
            </select>
        </div>
    </div>
</div>