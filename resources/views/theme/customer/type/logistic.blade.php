<div class="col-lg-6 optionItem">
    <div class="input-boder {{ $user->company!='' ? 'active' : '' }}">
        <label>Tên Công ty <span>*</span></label>
        <input type="text" class="form-control" name="company" value="{{ $user->company??'' }}" required>
    </div>
</div>
<div class="col-lg-6 optionItem">
    <div class="input-boder {{ $user->address!='' ? 'active' : '' }}">
        <label>Địa chỉ <span>*</span></label>
        <input type="text" class="form-control addressPopup" name="address" value="{{ $user->address }}" autocomplete="off">
    </div>
</div>
<div class="col-lg-6 optionItem">
    <div class="input-boder {{ $user->email!='' ? 'active' : '' }}">
        <label>Email <span>*</span></label>
        <input type="text" class="form-control" name="email" value="{{ $user->email??'' }}" required>
    </div>
</div>
<div class="col-lg-6 optionItem">
    <div class="input-boder {{ $user->phone!='' ? 'active' : '' }}">
        <label>Số điện thoại <span>*</span></label>
        <input type="text" class="form-control" name="phone" value="{{ $user->phone??'' }}" required>
    </div>
</div>

<div class="col-lg-6 optionItem">
    <div class="input-boder {{ $user->website!='' ? 'active' : '' }}">
        <label>Website</label>
        <input type="text" class="form-control" name="website" value="{{ $user->website??'' }}">
    </div>
</div>

<div class="col-lg-6 optionItem">
    <div class="input-boder {{ $user->mst!='' ? 'active' : '' }}">
        <label>Giấy CN ĐKKD số</label>
        <input type="text" class="form-control" name="mst" value="{{ $user->mst??'' }}">
    </div>
</div>
<div class="col-lg-6 optionItem">
    <div class="input-boder {{ $user->cccd_date!='' ? 'active' : '' }}">
        <label>Ngày cấp <span>*</span></label>
        <input type="text" class="form-control" name="cccd_date" value="{{ !empty($user->cccd_date) ? date('d/m/Y', strtotime($user->cccd_date)) : '' }}">
    </div>
</div>
<div class="col-lg-6 optionItem">
    <div class="input-boder {{ $user->cccd_place!='' ? 'active' : '' }}">
        <label>Nơi cấp <span>*</span></label>
        <input type="text" class="form-control" name="cccd_place" value="{{ $user->cccd_place??'' }}">
    </div>
</div>

<div class="col-lg-6 optionItem">
    <div class="input-boder {{ $user->other_name!='' ? 'active' : '' }}">
        <label>Người đại diện pháp luật</label>
        <input type="text" class="form-control" name="other_name" value="{{ $user->other_name??'' }}">
    </div>
</div>

<div class="col-lg-6 optionItem">
    <div class="input-boder {{ $user->company_date!='' ? 'active' : '' }}">
        <label>Năm thành lập <span>*</span></label>
        <input type="text" class="form-control" name="company_date" value="{{ $user->company_date??'' }}" required>
    </div>
</div>
<div class="col-lg-6">
    @include($templatePath .'.dangtin.includes.option', ['id' => 66, 'value' => $user->getOption(66)])
</div>

<div class="col-lg-6 optionItem">
    <div class="input-boder {{ $user->job!='' ? 'active' : '' }}">
        <label>Ngành nghề kinh doanh chính <span>*</span></label>
        <input type="text" class="form-control" name="job" value="{{ $user->job??'' }}" required>
    </div>
</div>

{{--Loại hình vận chuyển chính--}}
<div class="col-lg-6">
    @include($templatePath .'.dangtin.includes.option', ['id' => 104, 'value' => $user->getOption(104)])
</div>

{{--Dịch vụ khác--}}
<div class="col-lg-6">
    @include($templatePath .'.dangtin.includes.option', ['id' => 55, 'value' => $user->getOption(55)])
</div>

{{--Số lượng nhân viên--}}
<div class="col-lg-6">
    @include($templatePath .'.dangtin.includes.option', ['id' => 74, 'value' => $user->getOption(74)])
</div>

{{--Khả năng cung ứng kho bãi--}}
<div class="col-lg-6">
    @include($templatePath .'.dangtin.includes.option', ['id' => 73, 'value' => $user->getOption(73)])
</div>

{{--Loại kho--}}
<div class="col-lg-6">
    @include($templatePath .'.dangtin.includes.option', ['id' => 72, 'value' => $user->getOption(72)])
</div>

{{--Diện tích khuôn viên--}}
<div class="col-lg-6">
    @include($templatePath .'.dangtin.includes.option', ['id' => 71, 'value' => $user->getOption(71)])
</div>
{{--Diện tích nhà xưởng--}}
<div class="col-lg-6">
    @include($templatePath .'.dangtin.includes.option', ['id' => 48, 'value' => $user->getOption(48)])
</div>
{{--Diện tích văn phòng--}}
<div class="col-lg-6">
    @include($templatePath .'.dangtin.includes.option', ['id' => 49, 'value' => $user->getOption(49)])
</div>
{{--Điện--}}
<div class="col-lg-6">
    @include($templatePath .'.dangtin.includes.option', ['id' => 53, 'value' => $user->getOption(53)])
</div>
{{--Chứng chỉ / chứng nhân--}}
<div class="col-lg-6">
    @include($templatePath .'.dangtin.includes.option', ['id' => 75, 'value' => $user->getOption(75)])
</div>
