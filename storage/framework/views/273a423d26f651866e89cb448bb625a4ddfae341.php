
<!-- Topbar Start -->
<div class="container-fluid bg-brown topbar p-0">
    <div class="row gx-0 d-none d-lg-flex">
        <div class="col-lg-7 px-5 text-start d-inline-flex align-items-center">
            <?php if(!empty($menu_header_top) && $menu_header_top): ?>
            <ul>
                <?php $__currentLoopData = $menu_header_top; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                    <a href="<?php echo e(url($item['link']??'#')); ?>" class="<?php echo e($item['class']??''); ?>"><?php echo e($item['label']); ?></a>
                </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <?php endif; ?>
        </div>
        <div class="col-lg-5">
            <div class="d-flex justify-content-end">
                <div class="me-2">
                    <ul>
                        <?php if(!auth()->check()): ?>
                        <li>
                            <a class="topbar-link" href="<?php echo e(sc_route('login')); ?>">Đăng nhập</a>
                        </li>
                        <li>
                            <a class="topbar-link" href="<?php echo e(sc_route('register')); ?>">Đăng ký miễn phí</a>
                        </li>
                        
                        <?php else: ?>
                        <li class="">
                            <div class="dropdown top-auth-dropdown">
                                <a class="navbar-tool dropdown-toggle topbar-link" href="<?php echo e(route('customer.profile')); ?>" rel="noindex nofollow">
                                    <i class="fas fa-user"></i>
                                    <?php echo e(auth()->user()->fullname); ?>

                                </a>
                                <div class="dropdown-menu fade-up m-0">
                                    <a class="dropdown-item text-dark" href="<?php echo e(route('customer.profile')); ?>" rel="noindex nofollow">
                                        <img src="/assets/images/icons/user.svg" class="icon_menu"> <?php echo app('translator')->get('Thông tin cá nhân'); ?>
                                    </a>
                                    <?php if(auth()->user()->type != 3): ?>
                                        <?php if(auth()->user()->type == 1): ?>
                                            <a class="dropdown-item text-dark" href="<?php echo e(sc_route('account_upgrade')); ?>" rel="noindex nofollow">
                                                <i class="fa-solid fa-arrow-up-right-dots"></i> <?php echo app('translator')->get('Nâng cấp tài khoản'); ?>
                                            </a>
                                        <?php endif; ?>
                                    <a class="dropdown-item text-dark" href="<?php echo e(sc_route('customer.post')); ?>" rel="noindex nofollow">
                                        <img src="/assets/images/icons/list.svg" class="icon_menu"> <?php echo app('translator')->get('Quản lý tin đăng'); ?>
                                    </a>
                                    <?php endif; ?>
                                    <?php if(auth()->user()->type == 3): ?>
                                    <a class="dropdown-item text-dark" href="<?php echo e(route('customer.affiliate')); ?>" rel="noindex nofollow">
                                        <i class="fa-brands fa-affiliatetheme"></i> Tiếp thi liên kết
                                    </a>
                                    <?php endif; ?>
                                    <a class="dropdown-item text-dark" href="<?php echo e(route('customer.changePassword')); ?>" rel="noindex nofollow">
                                        <i class="fa-solid fa-unlock-keyhole"></i> <?php echo app('translator')->get('Thay đổi mật khẩu'); ?>
                                    </a>
                                    <a class="dropdown-item text-dark" href="<?php echo e(route('forget')); ?>" rel="noindex nofollow">
                                        <img src="/assets/images/icons/lock.svg" class="icon_menu"> <?php echo app('translator')->get('Quên mật khẩu'); ?>
                                    </a>
                                    <a class="dropdown-item text-dark" href="<?php echo e(route('customer.logout')); ?>"><img src="/assets/images/icons/logout.svg" class="icon_menu"> <?php echo app('translator')->get('Đăng xuất'); ?></a>
                                </div>
                            </div>
                        </li>   
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="btn login-user">
                    <a href="<?php echo e(sc_route('dangtin')); ?>"><img src="<?php echo e(asset('upload/images/general/PlusCircle.png')); ?>" /> Đăng tin</a>
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
                <img class="me-3" src="<?php echo e(asset(setting_option('logo'))); ?>" alt="<?php echo e(asset(setting_option('company_name'))); ?>" width="60" height="60" />
            </a>
            <div class="d-lg-none text-end ms-auto">
                <ul class="d-flex">
                <?php if(!auth()->check()): ?>
                <li class="me-1">
                    <a class="text-dark" href="<?php echo e(sc_route('register')); ?>" rel="noindex nofollow"><b>Đăng ký miễn phí</b></a> /
                </li>
                <li>
                    <a class="text-dark" href="<?php echo e(sc_route('login')); ?>" rel="noindex nofollow"><b>Đăng nhập</b></a>
                </li>
                <?php else: ?>
                <li>
                    <a class="navbar-tool text-dark" href="<?php echo e(route('customer.profile')); ?>" rel="noindex nofollow">
                        <i class="fas fa-user"></i>
                        <b><?php echo e(auth()->user()->fullname); ?></b>
                    </a>
                </li>   
                <?php endif; ?>
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
                        <img src="<?php echo e(asset(setting_option('logo'))); ?>" width="80px">
                        <button type="button" class="btn-close btn-close-black" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>

                    <div class="m-menu-item d-xl-none d-flex align-items-center justify-content-between mt-2 p-3">
                        <div class="d-inline-flex align-items-center me-2">
                            <ul>
                                <?php if(!auth()->check()): ?>
                                <li>
                                    <a href="<?php echo e(sc_route('register')); ?>" rel="noindex nofollow">Đăng ký miễn phí</a>
                                </li>
                                <li>
                                    <a href="<?php echo e(sc_route('login')); ?>" rel="noindex nofollow">Đăng nhập</a>
                                </li>
                                <?php else: ?>
                                <li>
                                    <a class="navbar-tool" href="<?php echo e(route('customer.profile')); ?>" rel="noindex nofollow">
                                        <i class="fas fa-user"></i>
                                        <?php echo e(auth()->user()->fullname); ?>

                                    </a>
                                </li>   
                                <?php endif; ?>
                            </ul>
                        </div>
                        <div class="btn login-user d-inline-flex">
                            <a href="<?php echo e(sc_route('dangtin')); ?>"><img src="<?php echo e(asset('upload/images/general/PlusCircle.png')); ?>" /> Đăng tin</a>
                        </div>
                    </div>
                    
                    <div class="offcanvas-body justify-content-center">
                        <?php echo $__env->make($templatePath .'.layouts.menu-main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                        <div class="m-menu-item d-xl-none mt-2">
                            <?php if(!empty($menu_header_top) && $menu_header_top): ?>
                            <ul class="navbar-nav">
                                <?php $__currentLoopData = $menu_header_top; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="nav-item "><a href="<?php echo e(url($item['link']??'#')); ?>" class="nav-link"><?php echo e($item['label']); ?></a></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                            <?php endif; ?>
                        </div>

                        <div class="m-menu-item d-xl-none d-flex align-items-center justify-content-center mt-2 p-3">
                            <div class="nav-item dropup">
                                <a href="#" class="nav-link dropdown-toggle currency text-uppercase" data-bs-toggle="dropdown" rel="noindex nofollow">
                                    <?php echo e(sc_currency_info()['symbol']); ?>

                                </a>
                                <div class="dropdown-menu fade-up m-0">
                                    <ul class="shop-currency">
                                        <?php $__currentLoopData = $modelCurrency->getListActive(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li>
                                            <a href="<?php echo e(sc_route('currency', ['code' => $item->code])); ?>" class="text-uppercase" rel="noindex nofollow">
                                                <?php echo e($item->symbol); ?>

                                            </a>
                                        </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                    <!-- <img src="<?php echo e(asset('upload/images/general/dollar-sign.png')); ?>" /> VNĐ -->
                    <?php echo e(sc_currency_info()['symbol']); ?>

                </a>
                <div class="dropdown-menu fade-up m-0">
                    <ul class="shop-currency">
                        <?php $__currentLoopData = $modelCurrency->getListActive(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <a href="<?php echo e(sc_route('currency', ['code' => $item->code])); ?>" class="text-uppercase" rel="noindex nofollow">
                                <?php echo e($item->symbol); ?>

                            </a>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
            <div class="gtranslate_wrapper"></div>
        </div>
    </nav>
    <!-- Navbar End -->
</header><?php /**PATH /home/long/Downloads/GTCPLATFORM-main/resources/views/theme/layouts/header.blade.php ENDPATH**/ ?>