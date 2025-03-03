<div class="col-lg-6 optionItem">
    <div class="input-boder {{ $user->company!='' ? 'active' : '' }}">
        <label>Tên Công ty</label>
        <input type="text" class="form-control" name="company" value="{{ $user->company??'' }}">
    </div>
</div>
<div class="col-lg-6 optionItem">
    <div class="input-boder {{ $user->address!='' ? 'active' : '' }}">
        <label>Địa chỉ</label>
        <input type="text" class="form-control addressPopup" name="address" value="{{ $user->address }}" autocomplete="off">
    </div>
</div>
<div class="col-lg-6 optionItem">
    <div class="input-boder {{ $user->email!='' ? 'active' : '' }}">
        <label>Email</label>
        <input type="text" class="form-control" name="email" value="{{ $user->email??'' }}">
    </div>
</div>
<div class="col-lg-6 optionItem">
    <div class="input-boder {{ $user->phone!='' ? 'active' : '' }}">
        <label>Số điện thoại</label>
        <input type="text" class="form-control" name="phone" value="{{ $user->phone??'' }}">
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
        <label>Năm thành lập</label>
        <input type="text" class="form-control" name="company_date" value="{{ $user->company_date??'' }}">
    </div>
</div>
<div class="col-lg-6">
    @include($templatePath .'.dangtin.includes.option', ['id' => 66])
</div>
<div class="col-lg-6 optionItem">
    <div class="input-boder {{ $user->job!='' ? 'active' : '' }}">
        <label>Ngành nghề kinh doanh chính</label>
        <input type="text" class="form-control" name="job" value="{{ $user->job??'' }}">
    </div>
</div>

{{--Số lượng nhân viên--}}
<div class="col-lg-6">
    @include($templatePath .'.dangtin.includes.option', ['id' => 74, 'value' => $user->getOption(74)])
</div>

{{--Chứng chỉ / chứng nhân--}}
<div class="col-lg-6">
    @include($templatePath .'.dangtin.includes.option', ['id' => 75, 'value' => $user->getOption(75)])
</div>