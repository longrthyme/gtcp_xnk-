@php
   $price = $product->price??'';
   if($price)
        $price_format = number_format($price);
   $price_max = $product->price_max??'';
@endphp
<div class="row g-4">
   <input type="hidden" name="post_type" value="sell">
   <div class="col-lg-12">
      <div class="mb-2">
         Yêu Cầu Chào giá
      </div>
      <div class="optionItem">
         <div class="input-boder ">
            <label>Tên dịch vụ <span>*</span></label>
            <input type="text" class="form-control input-value" name="title" value="{{ old('title', $product->name??'') }}">
         </div>
      </div>
   </div>

   <div class="col-lg-12">
      <div class="input-textarea {{ $content?'active':'' }}">
         <label class="mb-1">Mô tả dịch vụ<span class="color-red">*</span></label>
         <textarea rows="5" name="content" class="form-control content-limit" data-limit="1500">{!! isset($product->content) ? str_replace('<br />', "\n", $product->content) : '' !!}</textarea>
      </div>
      <div class="px-2 check-text check-text-content"><span>0</span>/1500 ký tự</div>
   </div>

   <div class="col-lg-12">
      <div class="optionItem">
         <div class="input-boder">
            <label>Nơi làm việc <span>*</span></label>
            <select class="form-control seaport" name="location_origin" data-msg-required="Chọn nơi làm việc" required>
               @if(!empty($address))
                <option value="{{ $address }}">{{ $address }}</option>
                @endif
            </select>
         </div>
      </div>
   </div>

   <div class="col-lg-12">
      <div class="optionItem">
         <div class="input-boder ">
            <label>Giá dịch vụ <span>*</span></label>
            <input type="text" class="form-control input-value number_format" name="price" value="{{ old('price', $price_format??'') }}" data-msg-required="Nhập giá dịch vụ" required autocomplete="off">
            <span class="unit">đ</span>
         </div>
      </div>
   </div>

   <div class="col-lg-12">
      {{--@include($templatePath .'.dangtin.includes.option', ['id' => 41])--}}
      <div class="optionItem">
         <div class="input-boder active">
            <label>Thời hạn báo giá </label>
            <input type="text" class="form-control input-value datepicker" name="date_available" value="{{ $date_available??'' }}" placeholder="dd/mm/yyyy" data-msg-required="Chọn thời hạn báo giá" required >
         </div>
      </div>
    </div>

</div>