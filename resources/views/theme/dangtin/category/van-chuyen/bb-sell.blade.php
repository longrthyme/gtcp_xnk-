<div class="row g-4 ">
    <div class="col-lg-12">
        @include($templatePath .'.dangtin.includes.option', ['id' => 104, 'value' => $product_options[104]??'', 'option_title' => 'Phương thức vận chuyển'])
    </div>

    <div class="col-lg-6">
        <div class="input-boder active">
            <label>Nơi đi <span>*</span></label>

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
            <label>Nơi đến <span>*</span></label>

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

    <div class="col-lg-6">
        @include($templatePath .'.dangtin.includes.option', ['id' => 35, 'value' => $product_options[35]??'', 'option_title' => 'Lịch khởi hành'])
    </div>
    <div class="col-lg-6">
        @include($templatePath .'.dangtin.includes.option', ['id' => 36, 'value' => $product_options[36]??''])
    </div>

    <div class="col-lg-3">
        <div class="optionItem">
            <div class="input-boder">
                <label>Giá cước <span>*</span></label>
                <input type="text" class="form-control input-value number_format" name="price" value="{{ $price_format??'' }}" data-msg-required="Nhập giá cước" required>
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
        {{--@include($templatePath .'.dangtin.includes.option', ['id' => 38, 'value' => $product_options[38]??'', 'option_title' => 'Phụ phí bao giồm'])--}}
        @include($templatePath .'.dangtin.includes.option', ['id' => 40, 'value' => $product_options[40]??''])
    </div>
    <div class="col-lg-6">
        <div class="optionItem">
            <div class="input-boder">
                <label>Hiệu lực giá <span>*</span></label>
                <input type="text" class="form-control  input-value datepicker" placeholder="dd/mm/yyyy" name="date_available" autocomplete="off" value="{{ $date_available??'' }}" data-msg-required="Chọn hiệu lực giá" required>
            </div>
        </div>
    </div>
    
    <div class="col-lg-12">
        @include($templatePath .'.dangtin.includes.option', ['id' => 217, 'value' => $product_options[217]??''])
    </div>
</div>