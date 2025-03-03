<?php
  $segment_check = Request::segment(2); 
  $segment_check3 = Request::segment(3); 
  $menus = \App\Models\AdminMenu::getListVisible();
  // dd($menus);
?>
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
   <div class="app-brand demo border-bottom">
      <a href="javascript:;" class="app-brand-link">
         <!-- <span class="app-brand-text demo menu-text fw-bolder ms-2 text-uppercase">ADMIN</span> -->
         <img src="{{ asset('assets/images/logo-admin.png') }}" alt="">
      </a>
      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
         <i class="bx bx-chevron-left bx-sm align-middle"></i>
      </a>
   </div>
   <div class="menu-inner-shadow"></div>
   <ul class="menu-inner py-1">
      <!-- Dashboard -->
      <li class="menu-item">
         <a href="{{route('admin.dashboard')}}" class="menu-link">
            <i class="menu-icon fas fa-tachometer-alt"></i>
            <div data-i18n="Analytics">Dashboard</div>
         </a>
      </li>
      <li class="menu-item">
         <a href="/" class="menu-link" target="_blank">
            <i class="menu-icon fas fa-home"></i>
            <div data-i18n="Analytics">Xem trang chủ</div>
         </a>
      </li>

      @if (count($menus))
         {{-- Level 0 --}}
         @foreach ($menus[0] as $level0)
            {{-- LEvel 1  --}}
            @if (!empty($menus[$level0->id]) && $level0->hidden == 0)
               <li class="menu-item has-treeview">
                  <a href="javascript:void(0);" class="menu-link menu-toggle">
                     <i class="menu-icon {{ $level0->icon }}"></i>
                     <div data-i18n="Account Settings">{!! __($level0->title) !!}</div>
                  </a>

                  <ul class="menu-sub">
                     @foreach ($menus[$level0->id] as $level1)
                     @php
                        $menu_active = '';
                        if (\App\Models\AdminMenu::checkUrlIsChild(url()->current(), sc_url_render($level1->uri)))
                           $menu_active = 'active';
                     @endphp
                     <li class="menu-item {{ $menu_active }}">
                        <a href="{{ $level1->uri?sc_url_render($level1->uri):'#' }}" class="menu-link {{ $menu_active }}">
                           <div data-i18n="{!! __($level1->title) !!}"><i class="menu-icon {{ $level1->icon }}"></i> {!! __($level1->title) !!}</div>
                        </a>
                     </li>
                     @endforeach
                  </ul>
               </li> 
            @else
               @if ($level0->hidden == 0)
                  <li class="menu-item {{ \App\Models\AdminMenu::checkUrlIsChild(url()->current(), sc_url_render($level0->uri)) ? 'active' : '' }}">
                     <a href="{{ $level0->uri?sc_url_render($level0->uri):'#' }}" class="menu-link">
                        <i class="menu-icon {{ $level0->icon }}"></i>
                        {!! __($level0->title) !!}
                     </a>
                  </li> 
               @endif
            @endif
            {{-- LEvel 1  --}}
         @endforeach
         {{-- Level 0 --}}
      @endif

      <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Setting</span>
      </li>
      @if (Auth::guard('admin')->user() && Auth::guard('admin')->user()->checkUrlAllowAccess(route('admin_theme_option')))
      <li class="menu-item">
         <a href="{{route('admin_theme_option')}}" class="menu-link"><i class="menu-icon fas fa-sliders-h"></i> Theme Option</a>
      </li>

      <li class="menu-item">
         <a href="{{route('admin_menu')}}" class="menu-link"><i class="menu-icon fas fa-bars"></i> Menu</a>
      </li>
      @endif

      <li class="menu-item">
         <a href="{{ route('admin_user_admin.change_password') }}" class="menu-link"><i class="menu-icon fas fa-user-circle"></i> Tài khoản</a>
      </li>
       <li class="menu-item">
         <a href="{{ route('admin.logout') }}" class="menu-link"><i class="menu-icon fas fa-sign-out-alt"></i> Logout</a>
       </li>
      
   </ul>
</aside>