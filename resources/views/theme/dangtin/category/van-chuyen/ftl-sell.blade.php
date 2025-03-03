<div class="row g-4 ">
    <div class="col-lg-6">
        @include($templatePath .'.dangtin.includes.option', ['id' => 202, 'value' => $product_options[202]??''])
    </div>
    <div class="col-lg-6 post_type_item post_type_buy">
        @include($templatePath .'.dangtin.includes.option', ['id' => 30, 'value' => $product_options[30]??''])
    </div>

    
    <div class="col-lg-10">
        @include($templatePath .'.dangtin.includes.option', ['id' => 206, 'value' => $product_options[206]??''])
    </div>
    <div class="col-lg-2">
        @include($templatePath .'.dangtin.includes.option', ['id' => 136, 'value' => $product_options[136]??'', 'option_title' => 'Đơn vị'])
    </div>

    <div class="col-lg-4">
        @include($templatePath .'.dangtin.includes.option', ['id' => 207, 'value' => $product_options[207]??''])
    </div>

    <div class="col-lg-4">
        @include($templatePath .'.dangtin.includes.option', ['id' => 208, 'value' => $product_options[208]??''])
    </div>

    <div class="col-lg-4">
        @include($templatePath .'.dangtin.includes.option', ['id' => 209, 'value' => $product_options[209]??''])
    </div>


    <div class="col-lg-4">
        <div class="input-boder">
            <label>Giá 10km đầu <span>*</span></label>
            <input type="text" class="form-control input-value number_format" name="price" value="{{ $price_format??'' }}" data-msg-required="Giá 10km đầu  " required>
            <span class="unit">đ</span>
        </div>
    </div>

    <div class="col-lg-4">
        @include($templatePath .'.dangtin.includes.option', ['id' => 211, 'value' => $product_options[211]??''])
    </div>

    <div class="col-lg-4">
        @include($templatePath .'.dangtin.includes.option', ['id' => 212, 'value' => $product_options[212]??''])
    </div>
    

    <div class="col-lg-6">
        @include($templatePath .'.dangtin.includes.option', ['id' => 213, 'value' => $product_options[213]??''])
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