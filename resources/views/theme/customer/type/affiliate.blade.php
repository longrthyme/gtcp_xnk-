<div class="col-lg-6 optionItem">
    <div class="input-boder {{ $user->fullname!='' ? 'active' : '' }}">
        <label>Họ tên <span>*</span></label>
        <input type="text" class="form-control" name="fullname" value="{{ $user->fullname??'' }}" required>
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
        <label>Email <span>*</span></label>
        <input type="text" class="form-control" name="email" value="{{ $user->email??'' }}" {{ $user->email!=''?'readonly':'' }} required>
    </div>
</div>
<div class="col-lg-6 optionItem">
    <div class="input-boder {{ $user->phone!='' ? 'active' : '' }}">
        <label>Số điện thoại <span>*</span></label>
        <input type="text" class="form-control" name="phone" value="{{ $user->phone??'' }}" {{ $user->phone!=''?'readonly':'' }} required>
    </div>
</div>
<div class="col-lg-4 optionItem">
    <div class="input-boder {{ $user->mst!='' ? 'active' : '' }}">
        <label>Mã số thuế cá nhân <span>*</span></label>
        <input type="text" class="form-control" name="mst" value="{{ $user->mst??'' }}">
    </div>
</div>
<div class="col-lg-4 optionItem">
    <div class="input-boder {{ $user->cccd!='' ? 'active' : '' }}">
        <label>CCCD/Hộ chiếu <span>*</span></label>
        <input type="text" class="form-control" name="cccd" value="{{ $user->cccd??'' }}">
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
<div class="col-lg-12">
    <hr>
    <h5 class="mb-0">Thông tin ngân hàng</h5>
</div>
<div class="col-lg-6 optionItem">
    <div class="input-boder {{ $user->bank_account!='' ? 'active' : '' }}">
        <label>Tên tài khoản: <span>*</span></label>
        <input type="text" class="form-control" name="bank_account" value="{{ $user->bank_account??'' }}" required>
    </div>
</div>
<div class="col-lg-6 optionItem">
    <div class="input-boder {{ $user->bank_number!='' ? 'active' : '' }}">
        <label>Số tài khoản: <span>*</span></label>
        <input type="text" class="form-control" name="bank_number" value="{{ $user->bank_number??'' }}" required>
    </div>
</div>
<div class="col-lg-6 optionItem">
    <div class="input-boder {{ $user->bank_name!='' ? 'active' : '' }}">
        <label>Ngân hàng: <span>*</span></label>
        <input type="text" class="form-control" name="bank_name" value="{{ $user->bank_name??'' }}" required>
    </div>
</div>
<div class="col-lg-6 optionItem">
    <div class="input-boder {{ $user->bank_branch!='' ? 'active' : '' }}">
        <label>Chi nhánh: <span>*</span></label>
        <input type="text" class="form-control" name="bank_branch" value="{{ $user->bank_branch??'' }}" required>
    </div>
</div>
<div class="col-lg-12 optionItem">
    <hr>
</div>