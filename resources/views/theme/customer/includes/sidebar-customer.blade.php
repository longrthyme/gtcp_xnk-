@php
    $user = auth()->user();
@endphp
<div class="border bg-white px-2">
    <div class="agent-contact mb-3 border-bottom">
        <div class="text-center pt-3">
            <div class="avatar">
              <!-- <img class="img-fluid rounded-circle avatar avatar-xl" src="images/avatar/01.jpg" alt=""> -->
                <div class="avatar-img">
                    @if($user->avatar)
                        <img src="{{  $user->avatar }}" alt="" id="uploaded_image" class="img-responsive rounded-circle">
                    @else
                        <img src="/images/user-none.jpg" alt="" id="uploaded_image" class="img-responsive rounded-circle">
                    @endif
                </div>
                <label for="upload_image" class="upload_image">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 25" fill="currentColor" aria-hidden="true" class="w-4 h-4"><path d="M12 16.676a3 3 0 100-6 3 3 0 000 6z"></path><path d="M20.25 7.676h-2.766c-.14 0-.315-.091-.45-.235l-1.216-1.919a.727.727 0 00-.065-.086c-.42-.49-.987-.76-1.597-.76H9.844c-.61 0-1.177.27-1.597.76a.729.729 0 00-.065.086L6.967 7.444c-.104.114-.25.235-.404.235v-.375a.75.75 0 00-.75-.75H4.688a.75.75 0 00-.75.75v.375H3.75a2.252 2.252 0 00-2.25 2.25v8.997a2.252 2.252 0 002.25 2.25h16.5a2.252 2.252 0 002.25-2.25v-9a2.252 2.252 0 00-2.25-2.25zM12 18.176a4.5 4.5 0 110-9 4.5 4.5 0 010 9z"></path></svg>
                </label>
                <input type="file" name="image" class="image" id="upload_image" style="display:none" />
            </div>

            <div class="agent-contact-name mt-2">
                <h2 class="fs-6 mb-2">{{ $user->fullname }}</h2>
            </div>
            
        </div>
    </div>
    @if($user->getPackage)
    <div class="agent-contact-name mt-2 bg-light text-center p-2 mb-3">
        <p>Gói thành viên: <b class="fs-6 mb-0">{!! $user->getPackage->name !!}</b></p>
        <p>Ngày sử dụng: <b class="fs-6 mb-0">{!! $user->countEndDate() !!}</b></p>
    </div>
    @endif
    @if($user->checkAffiliate())
    <div class="agent-contact-name mt-2 bg-light text-center p-2 mb-3">
        <p>Tiền hoa hồng</p>
        <h4 class="fs-6 mb-0">{!! render_price($user->wallet??0) !!}</h4>
    </div>
    @endif

    <div class="widget mb-3">
        <div class="widget-title fs-sm mb-2">
            <b>@lang('Quản lý thông tin tài khoản')</b>
        </div>
        @if($user->type == 3)
        <a class="dropdown-item mb-1" href="{{ route('customer.affiliate') }}">
            <i class="fa-brands fa-affiliatetheme"></i> Tiếp thi liên kết
        </a>
        @endif
        <a class="dropdown-item mb-1" href="{{ route('customer.profile') }}">
            <img src="/assets/images/icons/user.svg" class="icon_menu"> @lang('Thông tin cá nhân')
        </a>
        {{--
        <a class="dropdown-item mb-1" href="{{ route('purchase.history') }}">
            <img src="/assets/images/icons/user.svg" class="icon_menu"> @lang('Lịch sử thanh toán')
        </a>
        --}}
        @if($user->type != 3)
        <a class="dropdown-item mb-1" href="{{ sc_route('customer.post') }}">
            <img src="/assets/images/icons/list.svg" class="icon_menu"> @lang('Quản lý tin đăng')
        </a>
        @endif
        <a class="dropdown-item mb-1" href="{{ route('customer.changePassword') }}">
            <i class="fa-solid fa-unlock-keyhole"></i> @lang('Thay đổi mật khẩu')
        </a>
        <a class="dropdown-item mb-1" href="{{ route('forget') }}">
            <img src="/assets/images/icons/lock.svg" class="icon_menu"> @lang('Quên mật khẩu')
        </a>
        <hr class="my-2">
        <a class="dropdown-item" href="{{ route('customer.logout') }}"><img src="/assets/images/icons/logout.svg" class="icon_menu"> @lang('Đăng xuất')</a>
    </div>
</div>