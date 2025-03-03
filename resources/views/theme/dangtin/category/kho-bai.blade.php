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
    <div class="col-lg-12 text-center author_type">
        <div class="radio-group">
            @if($user->type != 2)
            <div>
                <input type="radio" name="post_type" class="bds_type" id="btncheck_ban" value="sell" {{ $post_type == 'sell' || $post_type == '' ? 'checked' : '' }}>
                <label for="btncheck_ban">Cho thuê</label>
            </div>
            @endif
            <div>
                <input type="radio" name="post_type" class="bds_type" id="btncheck_mua" value="buy" {{ $post_type == 'buy' ? 'checked' : '' }}>
                <label for="btncheck_mua">Cần thuê</label>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        @include($templatePath .'.dangtin.includes.option', ['id' => 105, 'value' => $product_options[105]??''])
    </div>

   <div class="col-lg-12">
      <div class="optionItem">
         <div class="input-boder ">
            <label>Tiêu đề <span>*</span></label>
            <input type="text" class="form-control input-value" name="title" value="{{ old('title', $product->name??'') }}">
         </div>
      </div>
   </div>

   <div class="col-lg-12">
      <div class="input-textarea {{ $content?'active':'' }}">
         <label class="mb-1">Mô tả kho bãi<span class="color-red">*</span></label>
         <textarea rows="5" name="content" class="form-control content-limit" data-limit="1500">{!! isset($product->content) ? str_replace('<br />', "\n", $product->content) : '' !!}</textarea>
      </div>
      <div class="px-2 check-text check-text-content"><span>0</span>/1500 ký tự</div>

   </div>

   <div class="col-lg-12">
      <div class="optionItem">
         <div class="input-boder ">
            <label>Diện tích khuôn viên <span>*</span></label>
            <input type="text" class="form-control input-value" name="acreage" value="{{ old('acreage', $product->acreage??'') }}" data-msg-required="Nhập diện tích" required>
         </div>
      </div>
   </div>

    <div class="col-lg-4">
        @include($templatePath .'.dangtin.includes.option', ['id' => 48, 'value' => $product_options[48]??'', 'option_title' => 'Diện tích '. $category->name??''])
    </div>
    <div class="col-lg-4">
        @include($templatePath .'.dangtin.includes.option', ['id' => 49, 'value' => $product_options[49]??''])
    </div>
    <div class="col-lg-4">
        @include($templatePath .'.dangtin.includes.option', ['id' => 50, 'value' => $product_options[50]??''])
    </div>
    <div class="col-lg-4">
        @include($templatePath .'.dangtin.includes.option', ['id' => 51, 'value' => $product_options[51]??''])
    </div>
    <div class="col-lg-4">
        @include($templatePath .'.dangtin.includes.option', ['id' => 52, 'value' => $product_options[52]??''])
    </div>
    <div class="col-lg-4">
        @include($templatePath .'.dangtin.includes.option', ['id' => 53, 'value' => $product_options[53]??''])
    </div>
    <div class="col-lg-6">
        @include($templatePath .'.dangtin.includes.option', ['id' => 54, 'value' => $product_options[54]??''])
    </div>
    <div class="col-lg-6">
        @include($templatePath .'.dangtin.includes.option', ['id' => 199, 'value' => $product_options[199]??''])
    </div>

   <div class="col-lg-6">
      <div class="optionItem">
         <div class="input-boder ">
            <label>Giá cho thuê <span>*</span></label>
            <input type="text" class="form-control input-value number_format" name="price" value="{{ old('price', $price_format??'') }}" data-msg-required="Nhập giá cho thuê" required autocomplete="off">
         </div>
      </div>
   </div>
   <div class="col-lg-6">
        @include($templatePath .'.dangtin.includes.option', ['id' => 143, 'value' => $product_options[143]??''])
    </div>

    <div class="col-lg-4">
        @include($templatePath .'.dangtin.includes.option', ['id' => 55, 'value' => $product_options[55]??''])
    </div>
    <div class="col-lg-4">
        @include($templatePath .'.dangtin.includes.option', ['id' => 57, 'value' => $product_options[57]??''])
    </div>

    <div class="col-lg-4">
        <div class="optionItem">
            <div class="input-boder active">
                <label>Thời hạn báo giá </label>
                <input type="text" class="form-control input-value datepicker" name="date_available" value="{{ $date_available??'' }}" placeholder="dd/mm/yyyy" data-msg-required="Chọn thời hạn báo giá" required >
            </div>
        </div>
    </div>

   <div class="col-lg-12 optionItem">
        <div class="input-boder {{ isset($address) && $address!='' ? 'active' : '' }}">
            <label>Địa điểm kho bãi <span>*</span></label>
            <select class="form-control seaport" name="location_origin" data-msg-required="Chọn địa điểm kho bãi" required>
                @if(!empty($address))
                <option value="{{ $address }}">{{ $address }}</option>
                @endif
            </select>
        </div>
    </div>
    
</div>