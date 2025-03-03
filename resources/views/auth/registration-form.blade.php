<div class="register-form position-relative">
    <form action="" id="customer-register" method="POST">
        @csrf
        <input type="hidden" name="account_type" value="{{ request('type') }}">
        <div class="row g-3">

            @if(!empty($user_types))
            <div class="col-lg-12">
                <label class="form-label">Vai trò </label>
                <select class="form-select" name="type">
                    @foreach($user_types as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            @endif

            @if(!empty($user_roles))
            <div class="col-lg-12">
                <label class="form-label">Loại Tài khoản </label>
                <select class="form-select" name="role">
                    <option value="">Chọn loại tài khoản</option>
                    @foreach($user_roles as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            @endif
            
            
            
            {{--
            <!-- <div class="mb-3">
                <label>Loại hình </label>
                <select class="form-select" name="role">
                    <option>Tổ chức</option>
                    <option>Cá nhân</option>
                </select>
            </div> -->
            --}}
        
            <div class="col-lg-4">
                <label class="form-label">@lang('Your name') <span class="text-danger">(*)</span></label>
                <input type="text" class="form-control" name="fullname" value="{{ old('fullname') }}" placeholder="@lang('Your name')">
                @if ($errors->has('fullname'))
                    <div class="help-block error">{{ $errors->first('fullname') }}</div>
                @endif
            </div>
            <div class="col-lg-4">
                <label class="form-label">Ngày tháng năm sinh <span class="text-danger">(*)</span></label>
                <input type="text" class="form-control datetime_js" name="birthday" value="{{ old('birthday') }}" placeholder="Ngày tháng năm sinh (*)" autocomplete="off">
                @if ($errors->has('birthday'))
                    <div class="help-block error">{{ $errors->first('birthday') }}</div>
                @endif
            </div>
            <div class="col-lg-4">
                <label class="form-label">Nghề nghiệp</label>
                <input type="text" class="form-control" name="job" value="{{ old('job') }}" placeholder="Nghề nghiệp">
            </div>

            <div class="col-lg-4">
                <label class="form-label">Số CCCD/Hộ chiếu <span class="text-danger">(*)</span></label>
                <input type="text" class="form-control" name="cccd" value="{{ old('cccd') }}" placeholder="Số CCCD/Hộ chiếu (*)">
                @if ($errors->has('cccd'))
                    <div class="help-block error">{{ $errors->first('cccd') }}</div>
                @endif
            </div>

            <div class="col-lg-4">
                <label class="form-label">Ngày cấp <span class="text-danger">(*)</span></label>
                <input type="text" class="form-control datetime_js" name="cccd_date" value="{{ old('cccd_date') }}" placeholder="Ngày cấp (*)" autocomplete="off">
                @if ($errors->has('cccd_date'))
                    <div class="help-block error">{{ $errors->first('cccd_date') }}</div>
                @endif
            </div>
            <div class="col-lg-4">
                <label class="form-label">Nơi cấp <span class="text-danger">(*)</span></label>
                <input type="text" class="form-control" name="cccd_place" value="{{ old('cccd_place') }}" placeholder="Nơi cấp (*)">
                @if ($errors->has('cccd_place'))
                    <div class="help-block error">{{ $errors->first('cccd_place') }}</div>
                @endif
            </div>
            <div class="col-lg-4">
                <label class="form-label">Mã số thuế cá nhân <span class="text-danger">(*)</span></label>
                <input type="text" class="form-control" name="mst" value="{{ old('mst') }}" placeholder="Mã số thuế cá nhân">
                @if ($errors->has('mst'))
                    <div class="help-block error">{{ $errors->first('mst') }}</div>
                @endif
            </div>
            <div class="col-lg-4">
                <label class="form-label">@lang('Email') <span class="text-danger">(*)</span></label>
                <input type="text" class="form-control" name="email" value="{{ old('email') }}" placeholder="@lang('Email')">
                @if ($errors->has('email'))
                    <div class="help-block error">{{ $errors->first('email') }}</div>
                @endif
            </div>
            <div class="col-lg-4">
                <label class="form-label">@lang('Phone') <span class="text-danger">(*)</span></label>
                <!-- <input type="text" class="form-control" name="phone"  placeholder="@lang('Phone')"> -->
                <div>
                    <input type="tel" class="form-control" id="phone_number" name="phone" value="{{ old('phone') }}" placeholder="Nhập điện thoại của bạn">
                </div>
                @if ($errors->has('phone'))
                    <div class="help-block error">{{ $errors->first('phone') }}</div>
                @endif
            </div>
            <div class="col-lg-12">
                <label class="form-label">@lang('Address') <span class="text-danger">(*)</span></label>
                <div>
                    <input type="text" class="form-control" id="phone_number" name="address" value="{{ old('address') }}" placeholder="Địa chỉ thường trú">
                </div>
                @if ($errors->has('phone'))
                    <div class="help-block error">{{ $errors->first('phone') }}</div>
                @endif
            </div>

            <div class="col-lg-12">
                <hr/>
            </div>
            <div class="col-lg-12">
                <div class="h4 text-center">THÔNG TIN ĐĂNG NHẬP</div>
            </div>
            <div class="col-lg-4">
                <label class="form-label">Tên đăng nhập <span class="text-danger">(*)</span></label>
                <input type="text" class="form-control" name="username" value="{{ old('username') }}" placeholder="Tên đăng nhập (*)">
                @if ($errors->has('username'))
                    <div class="help-block error">{{ $errors->first('username') }}</div>
                @endif
            </div>

            <div class="col-lg-4">
                <label class="form-label" for="si-password">Mật khẩu</label>
                <div class="password-toggle">
                    <input class="form-control" type="password" id="si-password" name="password" required="">
                    <label class="password-toggle-btn" aria-label="Show/hide password">
                        <input class="password-toggle-check" type="checkbox"><i class="fa-regular fa-eye"></i>
                    </label>
                </div>
                @if ($errors->has('password'))
                    <div class="help-block error">{{ $errors->first('password') }}</div>
                @endif
            </div>
            <div class="col-lg-4">
                <label class="form-label" for="password_confirmation">Nhập lại Mật khẩu</label>
                <div class="password-toggle">
                    <input class="form-control" type="password" id="password_confirmation" name="password_confirmation" required="">
                    <label class="password-toggle-btn" aria-label="Show/hide password">
                        <input class="password-toggle-check" type="checkbox"><i class="fa-regular fa-eye"></i>
                    </label>
                </div>
                @if ($errors->has('password_confirmation'))
                    <div class="help-block error">{{ $errors->first('password_confirmation') }}</div>
                @endif
            </div>

        </div>
        
        <div class="mb-3 col-sm-12">
            <div class="error-message text-danger"></div>
        </div>
        <div class="mb-3 col-sm-12">
            <div class="form-check">
                <label class="custom-control-label" for="check_agree"> Tôi xác nhận đã đọc, hiểu và đồng ý với <a href="{{ url('quy-che-hoat-dong.html') }}" title="">Quy Chế Hoạt Động</a>, <a href="{{ url('chinh-sach-bao-mat.html') }}" title="">Chính Sách Bảo Mật</a> và các quy định khác tại Trang GTCplatform.com</label>
                <input type="checkbox" class="form-check-input" name="check_agree" id="check_agree">
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-sm-6">
                <button type="submit" class="btn btn-primary w-100"> @lang('Register')</button>
            </div>
            <div class="col-sm-6">
                <ul class="list-unstyled d-flex mb-1 mt-sm-0 mt-3">
                    <li class="me-1">
                        <a href="{{ route('login') }}">
                            <b>Bạn đã có tài khoản? Nhấp vào đây để đăng nhập</b>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </form>
</div>