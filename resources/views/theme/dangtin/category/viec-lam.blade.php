@php
   $price = $product->price??'';
   if($price)
        $price_format = number_format($price);
   $price_max = $product->price_max??'';

    
@endphp
<input type="hidden" name="post_type" value="sell">
<div class="row g-4">
   <div class="col-lg-12">
      <div class="optionItem">
         <div class="input-boder ">
            <label>Vị trí tuyển dụng <span>*</span></label>
            <input type="text" class="form-control input-value" name="title" value="{{ old('title', $product->name??'') }}">
         </div>
      </div>
   </div>

    <div class="col-lg-12">
      <div class="input-textarea {{ $content?'active':'' }}">
         <label class="mb-1">Yêu cầu tuyển dụng<span class="color-red">*</span></label>
         <textarea rows="5" name="content" class="form-control content-limit" data-limit="1500">{!! isset($product->content) ? str_replace('<br />', "\n", $product->content) : '' !!}</textarea>
      </div>
      <div class="px-2 check-text check-text-content"><span>0</span>/1500 ký tự</div>

    </div>

    <div class="col-lg-12 optionItem">
        <div class="input-boder {{ !empty($address) ? 'active' : '' }}">
            <label>Nơi làm việc <span>*</span></label>
            <select class="form-control seaport" name="location_origin" data-msg-required="Chọn nơi làm việc" required>
                @if(!empty($address))
                <option value="{{ $address }}">{{ $address }}</option>
                @endif
            </select>
        </div>
    </div>
   
   <div class="col-lg-6">
      <div class="optionItem">
         <div class="input-boder ">
            <label>Số lượng tuyển dụng <span>*</span></label>
            <input type="text" class="form-control input-value" name="stock" value="{{ old('stock', $product->stock??'') }}" autocomplete="off" data-msg-required="Chọn số lượng tuyển dụng" required>
         </div>
      </div>
    </div>

    <div class="col-lg-6">
        <div class="optionItem">
            <div class="input-boder ">
                <label>Mức lương dự kiến <span>*</span></label>
                <input type="text" class="form-control input-value number_format" name="price" value="{{ old('price', $price_format??'') }}" autocomplete="off" data-msg-required="Nhập mức lương dự kiến" required>
                <span class="unit">đ</span>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        @include($templatePath .'.dangtin.includes.option', ['id' => 65, 'value' => $product_options[65]??''])
    </div>

    <div class="col-lg-6">
        <div class="optionItem">
            <div class="input-boder">
                <label>Hạn nộp hồ sơ <span>*</span></label>
                <input type="text" class="form-control  input-value datepicker" placeholder="dd/mm/yyyy" name="date_available" autocomplete="off" value="{{ $date_available??'' }}" data-msg-required="Chọn thời hạn nộp hồ sơ" required>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        @include($templatePath .'.dangtin.includes.option', ['id' => 63, 'value' => $product_options[63]??''])
    </div>
    <div class="col-lg-6">
        @include($templatePath .'.dangtin.includes.option', ['id' => 64, 'value' => $product_options[64]??''])
    </div>


    
</div>