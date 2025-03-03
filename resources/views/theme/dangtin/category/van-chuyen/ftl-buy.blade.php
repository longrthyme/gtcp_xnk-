<div class="row g-4 ">

    <div class="col-lg-6 post_type_item post_type_buy">
        @include($templatePath .'.dangtin.includes.option', ['id' => 30, 'value' => $product_options[30]??''])
    </div>

    
    <div class="col-lg-4">
        @include($templatePath .'.dangtin.includes.option', ['id' => 206, 'value' => $product_options[206]??''])
    </div>
    <div class="col-lg-2">
        @include($templatePath .'.dangtin.includes.option', ['id' => 136, 'value' => $product_options[136]??'', 'option_title' => 'Đơn vị'])
    </div>

    <div class="col-lg-12">
        @include($templatePath .'.dangtin.includes.option', ['id' => 168, 'value' => $product_options[168]??''])
    </div>

    <div class="col-lg-4">
        @include($templatePath .'.dangtin.includes.option', ['id' => 207, 'value' => $product_options[207]??'', 'option_title' => 'Dài'])
    </div>

    <div class="col-lg-4">
        @include($templatePath .'.dangtin.includes.option', ['id' => 208, 'value' => $product_options[208]??'', 'option_title' => 'Rộng'])
    </div>

    <div class="col-lg-4">
        @include($templatePath .'.dangtin.includes.option', ['id' => 209, 'value' => $product_options[209]??'', 'option_title' => 'Cao'])
    </div>

    <div class="col-lg-6">
        <div class="input-boder active">
            <label>Nơi nhận hàng <span>*</span></label>

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
            <label>Nơi giao hàng <span>*</span></label>

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
        @include($templatePath .'.dangtin.includes.option', ['id' => 35, 'value' => $product_options[35]??'', 'option_title' => 'Ngày bốc hàng'])
    </div>

    <div class="col-lg-6">
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