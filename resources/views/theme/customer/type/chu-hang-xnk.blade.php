@php
    $categories = $modelCategory->getList([
        'parent'    => 13
    ]);

    //if($user->getOptions())
        //$options = $user->getOptions()->pluck('value', 'option_id')->toArray();
    //dd($options);
@endphp

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
    <div class="input-boder {{ $user->website!='' ? 'active' : '' }}">
        <label>Website</label>
        <input type="text" class="form-control" name="website" value="{{ $user->website??'' }}">
    </div>
</div>
<div class="col-lg-6 optionItem">
    <div class="input-boder {{ $user->mst!='' ? 'active' : '' }}">
        <label>Giấy CN ĐKKD số <span>*</span></label>
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

{{--Sản phẩm chính--}}
<div class="col-lg-6">
    @include($templatePath .'.dangtin.includes.option', ['id' => 88, 'value' => $user->getOption(88)])
</div>
{{--Thị trường chính --}}
<div class="col-lg-6">
    @include($templatePath .'.dangtin.includes.option', ['id' => 89, 'value' => $user->getOption(89)])
</div>

{{--Dịch vụ khác--}}
<div class="col-lg-6">
    @include($templatePath .'.dangtin.includes.option', ['id' => 55, 'value' => $user->getOption(55)])
</div>

{{--Số lượng nhân viên--}}
<div class="col-lg-6">
    @include($templatePath .'.dangtin.includes.option', ['id' => 74, 'value' => $user->getOption(74)])
</div>

{{--Khả năng cung ứng hàng hóa--}}
<div class="col-lg-6">
    @include($templatePath .'.dangtin.includes.option', ['id' => 98, 'value' => $user->getOption(98)])
</div>

{{--Loại hàng hoá--}}
<div class="col-lg-6">
    <div class="optionItem">
        <div class="input-boder active">
            <label>Loại hàng hoá</label>
            <select class="form-control " name="category">
               @foreach($categories as $item)
               <option value="{{ $item->id }}">{{ $item->name }}</option>
               @endforeach
            </select>
        </div>
    </div>
</div>

{{--Tên hàng hoá--}}
<div class="col-lg-6">
    @include($templatePath .'.dangtin.includes.option', ['id' => 4, 'value' => $user->getOption(4)])
</div>
{{--Khối lượng hàng hoá có khả năng cung cấp--}}
<div class="col-lg-6">
    @include($templatePath .'.dangtin.includes.option', ['id' => 99, 'value' => $user->getOption(99)])
</div>
{{--Chứng chỉ / chứng nhân--}}
<div class="col-lg-6">
    @include($templatePath .'.dangtin.includes.option', ['id' => 75, 'value' => $user->getOption(75)])
</div>



{{--Giới thiệu tóm tắt về công ty--}}
<div class="col-lg-12">
    <div class="input-textarea {{ $user->about_me?'active':'' }}">
        <label class="mb-1">Giới thiệu tóm tắt về công ty</label>
        <textarea rows="5" name="about_me" class="form-control content-limit" data-limit="1500">{!! $user->about_me??'' !!}</textarea>
    </div>
</div>