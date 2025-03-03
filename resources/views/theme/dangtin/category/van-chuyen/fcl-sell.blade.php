<div class="row g-4 ">
    <div class="col-lg-6">
        @include($templatePath .'.dangtin.includes.option', ['id' => 104, 'value' => $product_options[104]??'', 'option_title' => 'Phương thức vận chuyển'])
    </div>

    <div class="col-lg-6">
        @include($templatePath .'.dangtin.includes.option', ['id' => 13, 'value' => $product_options[13]??''])
    </div>

    <div class="col-lg-6">
        <div class="input-boder active">
            <label>{{ $start_title }} đi <span>*</span></label>
            <input type="text" name="location_origin" value="{{ $address??'' }}" class="form-control" placeholder="Huyện/cảng/ga, tỉnh, quốc gia" required>
            {{--
            <select class="form-control seaport" name="location_origin" data-msg-required="Chọn nơi đi" required>
                @if(!empty($address))
                <option value="{{ $address }}">{{ $address }}</option>
                @endif
            </select>
            --}}
        </div>
    </div>

    <div class="col-lg-6">
        <div class="input-boder active">
            <label>{{ $start_title }} đến <span>*</span></label>
            <input type="text" name="address_end" value="{{ $address_end??'' }}" class="form-control" placeholder="Huyện/cảng/ga, tỉnh, quốc gia" required>
            {{--
            <select class="form-control seaport" name="address_end" data-msg-required="Chọn nơi đến" required>
               @if(!empty($address_end))
                  <option value="{{ $address_end }}">{{ $address_end }}</option>
               @endif
            </select>
            --}}
        </div>
    </div>

    @if( in_array($category->id, [41, 42, 43, 44, 53]) )
    <div class="col-lg-12">
        @include($templatePath .'.dangtin.includes.option', ['id' => 13, 'value' => $product_options[13]??''])
    </div>
    @endif

    <div class="col-lg-6">
        @include($templatePath .'.dangtin.includes.option', ['id' => 35, 'value' => $product_options[35]??''])
    </div>

    <div class="col-lg-6">
        @include($templatePath .'.dangtin.includes.option', ['id' => 36, 'value' => $product_options[36]??''])
    </div>

    <div class="col-lg-3">
        <div class="optionItem">
            <div class="input-boder">
                <label>Cước vận chuyển <span>*</span></label>
                <input type="text" class="form-control input-value number_format" name="price" value="{{ $price_format??'' }}" data-msg-required="Nhập cước vận chuyển" required>
                <span class="unit">đ</span>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="optionItem">
            <div class="input-boder">
                <label>Phụ phí <span>*</span></label>
                <input type="text" class="form-control input-value number_format" name="cost" value="{{ $cost_format??'' }}" data-msg-required="Nhập phụ phí" required>
                <span class="unit">đ</span>
            </div>
        </div>
    </div>
    
    {{--tong cuoc--}}
    <div class="col-lg-3">
        {{--@include($templatePath .'.dangtin.includes.option', ['id' => 39, 'value' => $product_options[39]??''])--}}
        <div class="optionItem">
            <div class="input-boder">
                <label>Tổng cước</label>
                <input type="text" class="form-control input-value number_format tongcuoc" value="{{ $tongcuoc??'' }}" readonly>
                <span class="unit">đ</span>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        @include($templatePath .'.dangtin.includes.option', ['id' => 159, 'value' => $product_options[159]??''])
    </div>

    <div class="col-lg-6">
        @include($templatePath .'.dangtin.includes.option', ['id' => 40, 'value' => $product_options[40]??''])
    </div>

    <div class="col-lg-6">
        {{--@include($templatePath .'.dangtin.includes.option', ['id' => 41, 'value' => $product_options[41]??''])--}}
        <div class="optionItem">
            <div class="input-boder">
                <label>Thời hạn báo giá <span>*</span></label>
                <input type="text" class="form-control  input-value datepicker" placeholder="dd/mm/yyyy" name="date_available" autocomplete="off" value="{{ $date_available??'' }}">
            </div>
        </div>
    </div>
   
    <div class="col-lg-12">
        @include($templatePath .'.dangtin.includes.option', ['id' => 217, 'value' => $product_options[217]??''])
    </div>
</div>