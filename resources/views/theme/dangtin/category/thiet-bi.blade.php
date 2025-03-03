@php
   $price = $product->price??'';
   $price_max = $product->price_max??'';
   $post_type = $post_type??'';

   if($price)
        $price_format = number_format($price);

    if($user->type == 2)
      $post_type = 'buy';
@endphp
<div class="row g-4">
   <!-- <input type="hidden" name="post_type" value="sell"> -->
   {{--
   <div class="col-lg-12 text-center">
      <div class="btn-group btn-group-custom btn-group-categories" role="group" aria-label="Basic radio  toggle button group">
         <input type="radio" class="btn-check" name="post_type" id="btncheck_ban" {{ $post_type == 'sell' || $post_type == '' ? 'checked' : '' }} value="sell">
         <label class="btn btn-outline-primary" for="btncheck_ban">Cho thuê</label>

         <input type="radio" class="btn-check" name="post_type" id="btncheck_mua" {{ $post_type == 'buy' ? 'checked' : '' }} value="buy">
         <label class="btn btn-outline-primary" for="btncheck_mua">Cần thuê</label>
      </div>
   </div>
   --}}
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
      <div class="optionItem">
         <div class="input-boder ">
            <label>Tên thiết bị <span>*</span></label>
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

   

    <div class="col-lg-4">
        @include($templatePath .'.dangtin.includes.option', ['id' => 189, 'value' => $product_options[189]??''])
    </div>
    <div class="col-lg-4">
      <div class="optionItem">
         <div class="input-boder {{ !empty($product->country_manufacture)?'active':'' }}">
            <label>Nước sản xuất <span>*</span></label>
            <select class="form-control seaport" name="country_manufacture" data-msg-required="Chọn nước sản xuất" required>
               @if(!empty($product->country_manufacture))
                <option value="{{ $product->country_manufacture }}">{{ $product->country_manufacture }}</option>
                @endif
            </select>
         </div>
      </div>
    </div>

    <div class="col-lg-4">
        @include($templatePath .'.dangtin.includes.option', ['id' => 59, 'value' => $product_options[59]??''])
    </div>

    <div class="col-lg-6">
        @include($templatePath .'.dangtin.includes.option', ['id' => 60, 'value' => $product_options[60]??''])
    </div>
    <div class="col-lg-6">
        @include($templatePath .'.dangtin.includes.option', ['id' => 61, 'value' => $product_options[61]??''])
    </div>

   <div class="col-lg-6 optionItem">
        <div class="input-boder {{ isset($address) && $address!='' ? 'active' : '' }}">
            <label>Địa điểm nhận hàng</label>
            <select class="form-control seaport" name="location_origin" data-msg-required="Chọn nơi đi" >
                @if(!empty($address))
                <option value="{{ $address }}">{{ $address }}</option>
                @endif
            </select>
        </div>
    </div>

    <div class="col-lg-6 optionItem">
        <div class="input-boder {{ isset($product->address_end) && $product->address_end!='' ? 'active' : '' }}">
            <label>Địa điểm giao hàng</label>
            <select class="form-control seaport" name="address_end" data-msg-required="Chọn nơi đến">
               @if(!empty($product->address_end))
                  <option value="{{ $product->address_end }}">{{ $product->address_end }}</option>
               @endif
            </select>
        </div>
    </div>

   {{--
   <div class="col-lg-6">
      <div class="optionItem">
         <div class="input-boder ">
            <label>Số lượng <span>*</span></label>
            <input type="text" class="form-control input-value" name="stock" value="{{ old('stock', $product->stock??'') }}" autocomplete="off" data-msg-required="Nhập số lượng" required>
         </div>
      </div>
    </div>
   --}}
    <div class="col-lg-6">
        @include($templatePath .'.dangtin.includes.option', ['id' => 168, 'value' => $product_options[168]??''])
    </div>

    <div class="col-lg-6">
        @include($templatePath .'.dangtin.includes.option', ['id' => 57, 'value' => $product_options[57]??''])
    </div>
    <div class="col-lg-6">
        <div class="optionItem">
            <div class="input-boder ">
                <label>Giá thuê <span>*</span></label>
                <input type="text" class="form-control input-value number_format" name="price" value="{{ old('price', $price_format??'') }}" autocomplete="off" data-msg-required="Nhập giá thuê">
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        @include($templatePath .'.dangtin.includes.option', ['id' => 143, 'value' => $product_options[143]??''])
    </div>

    

    <div class="col-lg-6">
        <div class="input-boder {{ isset($product->address_full) && $product->address_full!='' ? 'active' : '' }}">
            <label>Địa điểm giao nhận thiết bị <span>*</span></label>
            <select class="form-control seaport" name="address_full" data-msg-required="Nhập Địa điểm giao nhận thiết bị" required>
                @if(!empty($product->address_full))
                <option value="{{ $product->address_full }}">{{ $product->address_full }}</option>
                @endif
            </select>
        </div>
    </div>

    <div class="col-lg-6">
        @include($templatePath .'.dangtin.includes.option', ['id' => 38, 'value' => $product_options[38]??'', 'option_title' => 'Giá chưa bao giồm'])
    </div>
    <div class="col-lg-12">
        <div class="optionItem">
            <div class="input-boder">
                <label>Hiệu lực giá <span>*</span></label>
                <input type="text" class="form-control  input-value datepicker" placeholder="dd/mm/yyyy" name="date_available" autocomplete="off" value="{{ $date_available??'' }}" data-msg-required="Chọn hiệu lực giá" required>
            </div>
        </div>
    </div>

    <div class="col-lg-12 optionItem">
        <label for="catalogue_file">Đính kèm catalogue thiết bị <span>*</span></label>
        <input type="file" id="catalogue_file" name="catalogue_file[]" class="form-control multi max-2" data-msg-required="Chọn Đính kèm catalogue thiết bị" multiple  {{ !empty($catalogues) && $catalogues->count() ? '' : 'required'}}>

        @if(!empty($catalogues) && $catalogues->count())
        <div class="file-list">
            @foreach($catalogues as $index => $item)
                <div class="file-item">
                    <a class="file-remove" href="#" data="{{ $index }}">x</a> 
                    <span>
                        <span class="file-label" title="File selected: {{ basename($item->value) }}">
                            <a href="{{ asset($item->value) }}" class="file-title">{{ basename($item->value) }}</a>
                        </span>
                    </span>
                </div>
            @endforeach
        </div>
        @endif

        <span class="text-muted fs-sm">Tối đa 2 file</span>
    </div>

    <div class="col-lg-12 optionItem">
        <label for="certificate_file">Đính kèm các chứng chỉ liên quan <span>*</span></label>
        <input type="file" id="certificate_file" name="certificate_file[]" class="form-control multi max-2" data-msg-required="Chọn Đính kèm các chứng chỉ liên quan" multiple {{ !empty($certificates) && $certificates->count() ? '' : 'required'}}>

        @if(!empty($certificates) && $certificates->count())
        <div class="file-list">
            @foreach($certificates as $index => $item)
                <div class="file-item">
                    <a class="file-remove" href="#" data="{{ $index }}">x</a> 
                    <span>
                        <span class="file-label" title="File selected: {{ basename($item->value) }}">
                            <a href="{{ asset($item->value) }}" class="file-title">{{ basename($item->value) }}</a>
                        </span>
                    </span>
                </div>
            @endforeach
        </div>
        @endif

        <span class="text-muted fs-sm">Tối đa 2 file</span>
    </div>
</div>