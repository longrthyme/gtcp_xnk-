@if(auth()->check())
    @php
        $user = auth()->user();
    @endphp
<div class="btn-group">
    <div class="d-flex align-items-center">
        @if($user->avatar)
        <div class="avatar_user">
            <img src="{{  $user->avatar }}" alt="{{ $user->name }}" class="w-100">
        </div>
        @endif
        <div class="ms-2 text-white">
            <div class="text_orange fs-6 fw-bold">Hi, {{ $user->fullname }}</div>
            <div class="mt-1">{{ $user->email }}</div>
        </div>
    </div>
    <button type="button" class="btn border-0 dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fa-solid fa-sort-down text-white"></i>
    </button>
    <ul class="dropdown-menu">
        <li>
            <a class="dropdown-item" href="{{ route('customer.profile') }}">
                <img src="/upload/images/general/user.svg" class="icon_menu"> {{ sc_language_render('auth.info') }}
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="{{ route('customer.changePassword') }}">
                <img src="/upload/images/general/lock.svg" class="icon_menu"> {{ sc_language_render('auth.change_password') }}
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="{{ route('customer.logout') }}"><img src="/upload/images/general/logout.svg" class="icon_menu"> Logout</a>
        </li>
    </ul>
</div>
<div class="infor_user mt-3 mt-lg-5">
    <div class="item">
        <img src="{{ $templateFile .'/images/icon-man.svg' }}" alt="">
        <span class="">Giờ đã học : {{ $user->time_learned??0 }}</span> 
    </div>
    <div class="item">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
            <path d="M25.1367 7.81228C26.1618 6.78717 25.8848 4.84812 24.518 3.48129C23.1512 2.11447 21.2121 1.83747 20.187 2.86258C19.1619 3.8877 19.4389 5.82675 20.8057 7.19357C22.1725 8.56039 24.1116 8.8374 25.1367 7.81228Z" stroke="#FFA135" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M7.78748 25.1125C6.82498 26.1625 4.81248 25.9 3.49998 24.5C2.18748 23.1 1.83748 21.175 2.88748 20.2125" stroke="#FFA135" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M2.88751 20.2125C9.01251 14.875 14.875 9.01251 20.2125 2.88751" stroke="#FFA135" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M7.78748 25.1125C13.125 18.9875 18.9875 13.125 25.1125 7.78751" stroke="#FFA135" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M11.55 11.55C12.775 13.5625 16.625 16.625 16.625 16.625" stroke="#FFA135" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M15.75 21.875V15.75C17.9375 16.8 18.375 18.9875 18.375 21.4375V25.375" stroke="#FFA135" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
            <span>Khoá học hoàn thành : {{ $user->course_completed??0 }}</span> 
    </div>
    <div class="item">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
            <path d="M19.25 20.125C21.183 20.125 22.75 18.558 22.75 16.625C22.75 14.692 21.183 13.125 19.25 13.125C17.317 13.125 15.75 14.692 15.75 16.625C15.75 18.558 17.317 20.125 19.25 20.125Z" stroke="#FFA135" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M21.875 19.25V27.125L19.25 26.25L16.625 27.125V19.25" stroke="#FFA135" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M6.125 9.625H15.75" stroke="#FFA135" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M6.125 13.125H10.5" stroke="#FFA135" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M16.625 22.75H2.625V5.25H25.375V22.75H21.875" stroke="#FFA135" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <span>Chứng nhận đã cấp : {{ $user->certificate_issued??0 }}</span> 
    </div>
    @if(count($user->wishlist()))
    <div class="item">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
            <path d="M22.75 2.625H7.875C6.3875 2.625 5.25 3.7625 5.25 5.25C5.25 6.7375 6.3875 7.875 7.875 7.875H22.75V25.375" stroke="#FFA135" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M22.75 25.375H7.875C6.3875 25.375 5.25 24.2375 5.25 22.75V5.25" stroke="#FFA135" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M22.75 5.25H7.875" stroke="#FFA135" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M9.625 7.875V18.375L12.25 17.5L14.875 18.375V7.875" stroke="#FFA135" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        
        <span>Khoá học đang lưu: {{ count($user->wishlist()) }}</span> 

    </div>
    @endif
</div>
@else

<div class="btn-group">
    <div class="d-flex align-items-center">
        <div class="avatar_user">
            <img src="{{ asset('images/icon-user.png') }}" alt="avatar" class="w-100">
        </div>
        <div class="ms-2">
            <div class="text_orange fs-6 fw-bold">
                <a href="{{ route('login') }}" class="text_orange fs-6 fw-bold">{{ sc_language_render('auth.login') }}</a> / <a href="{{ route('register') }}" class="text_orange fs-6 fw-bold">{{ sc_language_render('auth.register') }}</a>
            </div>
        </div>
    </div>
</div>
    
@endif