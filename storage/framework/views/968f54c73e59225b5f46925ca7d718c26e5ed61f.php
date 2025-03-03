<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo e(asset(setting_option('favicon'))); ?>" />

    <?php echo $__env->make($templatePath .'.layouts.seo', $seo??[] , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->yieldContent('seo'); ?>

    <!-- theme -->
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:opsz,wght@6..12,700&family=Nunito:wght@400;700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="<?php echo e(asset($templateFile .'/plugins/bootstrap-icons/bootstrap-icons.css')); ?>" rel="stylesheet">

    <!-- pluginsraries Stylesheet -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.css" />
    <link href="<?php echo e(asset($templateFile . '/plugins/animate/animate.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset($templateFile . '/plugins/owlcarousel/assets/owl.carousel.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset($templateFile . '/plugins/tempusdominus/css/tempusdominus-bootstrap-4.min.css')); ?>" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="<?php echo e(asset($templateFile .'/plugins/bootstrap/css/bootstrap.min.css')); ?>" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/xzoom/1.0.15/xzoom.min.css">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/select2/css/select2.min.css')); ?>" />
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">

    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />

    <?php echo $__env->yieldPushContent('head-style'); ?>
    <!-- Template Stylesheet -->
    <link href="<?php echo e(asset($templateFile .'/css/style.css?ver='. $templateVer)); ?>" rel="stylesheet">

    <!-- theme -->
    
    <?php echo htmlspecialchars_decode(setting_option('header-script')); ?>

    
    <?php echo $__env->yieldPushContent('styles'); ?>

    <?php echo $__env->yieldPushContent('head-script'); ?>

    
</head>

<body>
        <?php echo htmlspecialchars_decode(setting_option('body-script')); ?>

        <?php 
            $headerMenu = Menu::getByName('Menu-main');
            $footerMenu = Menu::getByName('Footer-Menu');
            $telegram = setting_option('telegram');
            $instagram = setting_option('instagram');
            $facebook = setting_option('facebook');
            $youtube = setting_option('youtube');
            $tiktok = setting_option('tiktok');
            $twitter = setting_option('twitter');
            $pinterest = setting_option('pinterest');

            $agent = new  Jenssegers\Agent\Agent(); 
            $langs = (new \App\Models\ShopLanguage)->getListAll();
        ?>

        <?php $headerMenu = Menu::getByName('Menu-main'); ?>
        
        <div id="google_translate_element" style="display: none;"></div>
        
        <?php echo $__env->make($templatePath .'.layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <main class="main">
            <?php echo $__env->yieldContent('content'); ?>
        </main>

        <?php echo $__env->make($templatePath .'.layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        

        <script src="//code.jquery.com/jquery-3.6.0.min.js"></script>
        
        <!-- JavaScript pluginsraries -->
        <script src="<?php echo e(asset($templateFile .'/plugins/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/xzoom/1.0.15/xzoom.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
        
        <script src="<?php echo e(asset($templateFile .'/plugins/easing/easing.min.js')); ?>"></script>
        
        <script src="<?php echo e(asset($templateFile .'/plugins/owlcarousel/owl.carousel.min.js')); ?>"></script>
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.2.0/lazysizes.min.js" async=""></script>

       <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
       <script src="//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>


        
        <script src="/js/axios.min.js"></script>
        <script src="/js/sweetalert2.all.min.js"></script>
        <script src="/js/jquery.validate.min.js"></script>
        <script src="<?php echo e(asset('assets/plugins/select2/js/select2.min.js')); ?>"></script>
        
        <script src="<?php echo e(asset($templateFile .'/js/main.js?ver='. $templateVer)); ?>"></script>
        <script src="<?php echo e(asset('/js/customer.js?ver='. $templateVer)); ?>"></script>
        

        <script src="//cdn.gtranslate.net/widgets/latest/dwf.js" defer></script>
        <script>window.gtranslateSettings = {"default_language":"vi","detect_browser_language":false,"wrapper_selector":".gtranslate_wrapper","flag_size":18,"switcher_horizontal_position":"inline"}</script>

        

        <script>
            jQuery(document).ready(function($) {
                var current_lang = readCookie('googtrans');
                if(!current_lang)
                {
                    $('.gt_option').find('.gt_current').removeClass('gt_current');
                    var gt_name = $('.gt_option').find('a[data-gt-lang="vi"]'),
                        img_wrc = gt_name.find('img').attr('data-gt-lazy-src');
                        gt_name.find('img').attr('src', img_wrc);
                    // console.log(gt_name[0]);
                    $('.gt_selected').html(gt_name[0]);
                }
            });
            function readCookie(name) {
                var c = document.cookie.split('; '),
                cookies = {}, i, C;
                for (i = c.length - 1; i >= 0; i--) {
                    C = c[i].split('=');
                    cookies[C[0]] = C[1];
                 }
                console.log(cookies);

                 return cookies[name];
            }
        </script>

        <?php echo htmlspecialchars_decode(setting_option('footer-script')); ?>

        <?php echo $__env->yieldPushContent('after-footer'); ?>
        <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html>
<?php /**PATH /home/long/Downloads/GTCPLATFORM-main/resources/views/theme/layouts/index.blade.php ENDPATH**/ ?>