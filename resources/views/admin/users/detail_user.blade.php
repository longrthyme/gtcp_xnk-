<div class="row g-3 mb-3 account_type account_type-0" style="{{ $account_type == 1 ? 'display: none' : '' }}">
    <div class="col-md-4">
        <label class="mb-2">Họ và tên <span class="text-danger">*</span></label>
        <input type="text" class="form-control input_value" name="fullname" value="{{ $fullname??'' }}" required {{ $user_disabled }}>
    </div>

    <div class="col-lg-4">
        <label class="form-label">Ngày tháng năm sinh <span class="text-danger">(*)</span></label>
        <input type="tel" class="form-control input_value date_js" autocomplete="off" name="birthday" value="{{ $user->birthday??'' }}" {{ $user_disabled }}>
    </div>
    <div class="col-lg-4">
        <label class="form-label">Nghề nghiệp</label>
        <input type="tel" class="form-control input_value" name="job" value="{{ $user->job??'' }}" {{ $user_disabled }}>
    </div>
    
    <div class="col-md-12">
        <label class="mb-2">Địa chỉ thường trú</label>
        <input type="text" class="form-control input_value" name="address" value="{{ $address??'' }}" required {{ $user_disabled }}>
    </div>

    <div class="col-lg-4 ">
        <label>CCCD/Hộ chiếu <span class="text-danger">*</span></label>
        <input type="text" class="form-control input_value" name="cccd" value="{{ $user->cccd??'' }}" required {{ $user_disabled }}>
    </div>
    <div class="col-lg-4">
        <label>Ngày cấp <span class="text-danger">*</span></label>
        <input type="text" class="form-control input_value" name="cccd_date" value="{{ !empty($user->cccd_date) ? date('d/m/Y', strtotime($user->cccd_date)) : '' }}"  required {{ $user_disabled }}>
    </div>
    <div class="col-lg-4">
        <label>Nơi cấp <span class="text-danger">*</span></label>
        <input type="text" class="form-control input_value" name="cccd_place" value="{{ $user->cccd_place??'' }}" required {{ $user_disabled }}>
    </div>

    <div class="col-lg-4">
        <label class="form-label">Mã số thuế cá nhân <span class="text-danger">(*)</span></label>
        <input type="text" class="form-control" name="mst" value="{{ $user->mst??'' }}" placeholder="Mã số thuế cá nhân" required {{ $user_disabled }}>
    </div>
    <div class="col-md-4">
        <label class="mb-2">Email <span class="text-danger">*</span></label>
        <input type="text" class="form-control input_value" name="email" value="{{ $email??'' }}" required {{ $user_disabled }}>
    </div>
    <div class="col-md-4">
        <label class="mb-2">Điện thoại <span class="text-danger">*</span></label>
        <input type="text" class="form-control input_value" name="phone" value="{{ $user->phone??'' }}" required {{ $user_disabled }}>
    </div>
</div>