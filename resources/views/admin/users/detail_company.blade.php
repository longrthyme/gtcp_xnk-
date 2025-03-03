<div class="row g-3 mb-3 account_type account_type-1" style="{{ $account_type == 0 ? 'display: none' : '' }}">
    <div class="col-lg-12">
        <label class="form-label">Tên Công ty <span class="text-danger">(*)</span></label>
        <input type="text" class="form-control input_value" name="company" value="{{ $user->company??'' }}" placeholder="Tên Công ty (*)" {{ $company_disabled }}>
    </div>

    <div class="col-lg-12">
        <label class="form-label">Địa chỉ Công ty <span class="text-danger">(*)</span></label>
        <input type="text" class="form-control input_value" name="address" value="{{ $user->address??'' }}" placeholder="Địa chỉ Công ty (*)" {{ $company_disabled }}>
    </div>

    <div class="col-lg-6">
        <label class="form-label">Số điện thoại công ty <span class="text-danger">(*)</span></label>
        <input type="tel" class="form-control input_value" id="phone_number" name="phone" value="{{ $user->phone??'' }}" placeholder="Số điện thoại công ty (*)" {{ $company_disabled }}>
    </div>

    <div class="col-md-6">
        <label class="mb-2">Email <span class="text-danger">*</span></label>
        <input type="text" class="form-control input_value" name="email" value="{{ $email??'' }}" required {{ $company_disabled }}>
    </div>
    <div class="col-12">
        <hr>
    </div>
    <div class="col-lg-6 ">
        <label>Giấy CN ĐKKD số <span class="text-danger">*</span></label>
        <input type="text" class="form-control input_value" name="mst" value="{{ $user->mst??'' }}" required {{ $company_disabled }}>
    </div>
    <div class="col-lg-6">
        <label>Ngày cấp <span class="text-danger">*</span></label>
        <input type="text" class="form-control input_value" name="cccd_date" value="{{ !empty($user->cccd_date) ? date('d/m/Y', strtotime($user->cccd_date)) : '' }}"  required {{ $company_disabled }}>
    </div>

    <div class="col-lg-12">
        <label>Nơi cấp <span class="text-danger">*</span></label>
        <input type="text" class="form-control input_value" name="cccd_place" value="{{ $user->cccd_place??'' }}" required {{ $company_disabled }}>
    </div>
    <div class="col-12">
        <hr>
    </div>
    <div class="col-lg-12">
        <label> Người đại diện theo pháp luật <span class="text-danger">*</span></label>
        <input type="text" class="form-control input_value" name="other_name" value="{{ $user->other_name??'' }}" {{ $company_disabled }}>
    </div>
    <div class="col-lg-12">
        <label> Người liên hệ <span class="text-danger">*</span></label>
        <input type="text" class="form-control input_value" name="fullname" value="{{ $user->fullname??'' }}" {{ $company_disabled }}>
    </div>
    <div class="col-lg-12">
        <label> Chức vụ <span class="text-danger">*</span></label>
        <input type="text" class="form-control input_value" name="job" value="{{ $user->job??'' }}" {{ $company_disabled }}>
    </div>

    
</div>