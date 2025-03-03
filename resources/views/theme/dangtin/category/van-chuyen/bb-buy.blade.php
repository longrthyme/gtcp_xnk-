<div class="row g-4 ">
    <div class="col-lg-6">
        @include($templatePath .'.dangtin.includes.option', ['id' => 30, 'value' => $product_options[30]??''])
    </div>

    <div class="col-lg-4">
        @include($templatePath .'.dangtin.includes.option', ['id' => 44, 'value' => $product_options[44]??''])
    </div>
    <div class="col-lg-2">
        @include($templatePath .'.dangtin.includes.option', ['id' => 159, 'value' => $product_options[159]??'', 'option_title' => 'Đơn vị'])
    </div>

    <div class="col-lg-6">
        @include($templatePath .'.dangtin.includes.option', ['id' => 45, 'value' => $product_options[45]??''])
    </div>

    <div class="col-lg-6">
        @include($templatePath .'.dangtin.includes.option', ['id' => 168, 'value' => $product_options[168]??''])
    </div>
    
    <div class="col-lg-12">
        @include($templatePath .'.dangtin.includes.option', ['id' => 104, 'value' => $product_options[104]??'', 'option_title' => 'Phương thức vận chuyển'])
    </div>
    
    
    <div class="col-lg-4">
        @include($templatePath .'.dangtin.includes.option', ['id' => 156, 'value' => $product_options[156]??''])
    </div>
    <div class="col-lg-4">
        @include($templatePath .'.dangtin.includes.option', ['id' => 157, 'value' => $product_options[157]??''])
    </div>
    <div class="col-lg-4">
        @include($templatePath .'.dangtin.includes.option', ['id' => 158, 'value' => $product_options[158]??''])
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
        @include($templatePath .'.dangtin.includes.option', ['id' => 35, 'value' => $product_options[35]??'', 'option_title' => 'Ngày bốc hàng dự kiến'])
    </div>

    <div class="col-lg-6">
        {{--@include($templatePath .'.dangtin.includes.option', ['id' => 41, 'value' => $product_options[41]??''])--}}
        <div class="optionItem">
            <div class="input-boder">
                <label>Thời hạn báo giá <span>*</span></label>
                <input type="text" class="form-control  input-value datepicker" placeholder="dd/mm/yyyy" name="date_available" autocomplete="off" value="{{ $date_available??'' }}" data-msg-required="Chọn thời hạn báo giá" required>
            </div>
        </div>
    </div>
    
    <div class="col-lg-12">
        @include($templatePath .'.dangtin.includes.option', ['id' => 217, 'value' => $product_options[217]??''])
    </div>
</div>