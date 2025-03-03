
<!-- Topbar Start -->
<div class="container-fluid bg-brown topbar p-0">
    <div class="row gx-0 d-none d-lg-flex">
        <div class="col-lg-7 px-5 text-start d-inline-flex align-items-center">
            @if(!empty($menu_header_top) && $menu_header_top)
            <ul>
                @foreach($menu_header_top as $item)
                <li>
                    <a href="{{ url($item['link']??'#') }}" class="{{ $item['class']??'' }}">{{ $item['label'] }}</a>
                </li>
                @endforeach
            </ul>
            @endif
        </div>
        <div class="col-lg-5">
            <div class="d-flex justify-content-end">
                <div class="me-2">
                    <ul>
                        @if(!auth()->check())
                        <li>
                            <a class="topbar-link" href="{{ sc_route('login') }}">Đăng nhập</a>
                        </li>
                        <li>
                            <a class="topbar-link" href="{{ sc_route('register') }}">Đăng ký miễn phí</a>
                        </li>
                        
                        @else
                        <li class="">
                            <div class="dropdown top-auth-dropdown">
                                <a class="navbar-tool dropdown-toggle topbar-link" href="{{ route('customer.profile') }}" rel="noindex nofollow">
                                    <i class="fas fa-user"></i>
                                    {{ auth()->user()->fullname }}
                                </a>
                                <div class="dropdown-menu fade-up m-0">
                                    <a class="dropdown-item text-dark" href="{{ route('customer.profile') }}" rel="noindex nofollow">
                                        <img src="/assets/images/icons/user.svg" class="icon_menu"> @lang('Thông tin cá nhân')
                                    </a>
                                    @if(auth()->user()->type != 3)
                                        @if(auth()->user()->type == 1)
                                            <a class="dropdown-item text-dark" href="{{ sc_route('account_upgrade') }}" rel="noindex nofollow">
                                                <i class="fa-solid fa-arrow-up-right-dots"></i> @lang('Nâng cấp tài khoản')
                                            </a>
                                        @endif
                                    <a class="dropdown-item text-dark" href="{{ sc_route('customer.post') }}" rel="noindex nofollow">
                                        <img src="/assets/images/icons/list.svg" class="icon_menu"> @lang('Quản lý tin đăng')
                                    </a>
                                    @endif
                                    @if(auth()->user()->type == 3)
                                    <a class="dropdown-item text-dark" href="{{ route('customer.affiliate') }}" rel="noindex nofollow">
                                        <i class="fa-brands fa-affiliatetheme"></i> Tiếp thi liên kết
                                    </a>
                                    @endif
                                    <a class="dropdown-item text-dark" href="{{ route('customer.changePassword') }}" rel="noindex nofollow">
                                        <i class="fa-solid fa-unlock-keyhole"></i> @lang('Thay đổi mật khẩu')
                                    </a>
                                    <a class="dropdown-item text-dark" href="{{ route('forget') }}" rel="noindex nofollow">
                                        <img src="/assets/images/icons/lock.svg" class="icon_menu"> @lang('Quên mật khẩu')
                                    </a>
                                    <a class="dropdown-item text-dark" href="{{ route('customer.logout') }}"><img src="/assets/images/icons/logout.svg" class="icon_menu"> @lang('Đăng xuất')</a>
                                </div>
                            </div>
                        </li>   
                        @endif
                    </ul>
                </div>
                <div class="btn login-user">
                    <a href="{{ sc_route('dangtin') }}"><img src="{{ asset('upload/images/general/PlusCircle.png') }}" /> Đăng tin</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Topbar End -->

<header class="header">
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg justify-content-between container-fluid menu-bg navbar-light px-xl-5 px-lg-4 py-1">
        <div class="header-left">
            <a href="/" class="navbar-brand ms-4 ms-lg-0 py-0">
                <img class="me-3" src="{{ asset(setting_option('logo')) }}" alt="{{ asset(setting_option('company_name')) }}" width="60" height="60" />
            </a>
            <div class="d-lg-none text-end ms-auto">
                <ul class="d-flex">
                @if(!auth()->check())
                <li class="me-1">
                    <a class="text-dark" href="{{ sc_route('register') }}" rel="noindex nofollow"><b>Đăng ký miễn phí</b></a> /
                </li>
                <li>
                    <a class="text-dark" href="{{ sc_route('login') }}" rel="noindex nofollow"><b>Đăng nhập</b></a>
                </li>
                @else
                <li>
                    <a class="navbar-tool text-dark" href="{{ route('customer.profile') }}" rel="noindex nofollow">
                        <i class="fas fa-user"></i>
                        <b>{{ auth()->user()->fullname }}</b>
                    </a>
                </li>   
                @endif
            </ul>
            </div>
            <div class="header-nav">
                <div class="navbar-toggler-mobile">
                    <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-label="Toggle navigation">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                </div>
                <div class="navbar-collapse offcanvas offcanvas-end collapse" id="navbarCollapse">
                    <div class="offcanvas-header d-xl-none">
                        <!-- <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Offcanvas</h5> -->
                        <img src="{{ asset(setting_option('logo')) }}" width="80px">
                        <button type="button" class="btn-close btn-close-black" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>

                    <div class="m-menu-item d-xl-none d-flex align-items-center justify-content-between mt-2 p-3">
                        <div class="d-inline-flex align-items-center me-2">
                            <ul>
                                @if(!auth()->check())
                                <li>
                                    <a href="{{ sc_route('register') }}" rel="noindex nofollow">Đăng ký miễn phí</a>
                                </li>
                                <li>
                                    <a href="{{ sc_route('login') }}" rel="noindex nofollow">Đăng nhập</a>
                                </li>
                                @else
                                <li>
                                    <a class="navbar-tool" href="{{ route('customer.profile') }}" rel="noindex nofollow">
                                        <i class="fas fa-user"></i>
                                        {{ auth()->user()->fullname }}
                                    </a>
                                </li>   
                                @endif
                            </ul>
                        </div>
                        <div class="btn login-user d-inline-flex">
                            <a href="{{ sc_route('dangtin') }}"><img src="{{ asset('upload/images/general/PlusCircle.png') }}" /> Đăng tin</a>
                        </div>
                    </div>
                    
                    <div class="offcanvas-body justify-content-center">
                        @include($templatePath .'.layouts.menu-main')

                        <div class="m-menu-item d-xl-none mt-2">
                            @if(!empty($menu_header_top) && $menu_header_top)
                            <ul class="navbar-nav">
                                @foreach($menu_header_top as $item)
                                <li class="nav-item "><a href="{{ url($item['link']??'#') }}" class="nav-link">{{ $item['label'] }}</a></li>
                                @endforeach
                            </ul>
                            @endif
                        </div>

                        <div class="m-menu-item d-xl-none d-flex align-items-center justify-content-center mt-2 p-3">
                            <div class="nav-item dropup">
                                <a href="#" class="nav-link dropdown-toggle currency text-uppercase" data-bs-toggle="dropdown" rel="noindex nofollow">
                                    {{ sc_currency_info()['symbol'] }}
                                </a>
                                <div class="dropdown-menu fade-up m-0">
                                    <ul class="shop-currency">
                                        @foreach($modelCurrency->getListActive() as $item)
                                        <li>
                                            <a href="{{ sc_route('currency', ['code' => $item->code]) }}" class="text-uppercase" rel="noindex nofollow">
                                                {{ $item->symbol }}
                                            </a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="gtranslate_wrapper"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-right d-none d-lg-flex">
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle currency text-uppercase" data-bs-toggle="dropdown">
                    <!-- <img src="{{ asset('upload/images/general/dollar-sign.png') }}" /> VNĐ -->
                    {{ sc_currency_info()['symbol'] }}
                </a>
                <div class="dropdown-menu fade-up m-0">
                    <ul class="shop-currency">
                        @foreach($modelCurrency->getListActive() as $item)
                        <li>
                            <a href="{{ sc_route('currency', ['code' => $item->code]) }}" class="text-uppercase" rel="noindex nofollow">
                                {{ $item->symbol }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="gtranslate_wrapper"></div>
        </div>
    </nav>
    <!-- Navbar End -->
</header>