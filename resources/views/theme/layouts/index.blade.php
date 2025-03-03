<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset(setting_option('favicon')) }}" />

    @include($templatePath .'.layouts.seo', $seo??[] )

    @yield('seo')

    <!-- theme -->
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:opsz,wght@6..12,700&family=Nunito:wght@400;700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{ asset($templateFile .'/plugins/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

    <!-- pluginsraries Stylesheet -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.css" />
    <link href="{{ asset($templateFile . '/plugins/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset($templateFile . '/plugins/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset($templateFile . '/plugins/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset($templateFile .'/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/xzoom/1.0.15/xzoom.min.css">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" />
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">

    <meta name="csrf-token" content="{{ csrf_token() }}" />

    @stack('head-style')
    <!-- Template Stylesheet -->
    <link href="{{ asset($templateFile .'/css/style.css?ver='. $templateVer) }}" rel="stylesheet">

    <!-- theme -->
    
    {!! htmlspecialchars_decode(setting_option('header-script')) !!}
    
    @stack('styles')

    @stack('head-script')

    
</head>

<body>
        {!! htmlspecialchars_decode(setting_option('body-script')) !!}
        @php 
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
        @endphp

        @php $headerMenu = Menu::getByName('Menu-main'); @endphp
        
        <div id="google_translate_element" style="display: none;"></div>
        
        @include($templatePath .'.layouts.header')
        <main class="main">
            @yield('content')
        </main>

        @include($templatePath .'.layouts.footer')
        

        <script src="//code.jquery.com/jquery-3.6.0.min.js"></script>
        
        <!-- JavaScript pluginsraries -->
        <script src="{{ asset($templateFile .'/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/xzoom/1.0.15/xzoom.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
        
        <script src="{{ asset($templateFile .'/plugins/easing/easing.min.js') }}"></script>
        
        <script src="{{ asset($templateFile .'/plugins/owlcarousel/owl.carousel.min.js') }}"></script>
        {{--
        <script src="{{ asset($templateFile .'/plugins/wow/wow.min.js') }}"></script>
        <script src="{{ asset($templateFile .'/plugins/waypoints/waypoints.min.js') }}"></script>
        <script src="{{ asset($templateFile .'/plugins/counterup/counterup.min.js') }}"></script>
        <script src="{{ asset($templateFile .'/plugins/tempusdominus/js/moment.min.js') }}"></script>
        <script src="{{ asset($templateFile .'/plugins/tempusdominus/js/moment-timezone.min.js') }}"></script>
        <script src="{{ asset($templateFile .'/plugins/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>
        --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.2.0/lazysizes.min.js" async=""></script>

       <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
       <script src="//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>


        {{--main js--}}
        <script src="/js/axios.min.js"></script>
        <script src="/js/sweetalert2.all.min.js"></script>
        <script src="/js/jquery.validate.min.js"></script>
        <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
        
        <script src="{{ asset($templateFile .'/js/main.js?ver='. $templateVer) }}"></script>
        <script src="{{ asset('/js/customer.js?ver='. $templateVer) }}"></script>
        {{--end main js--}}

        <script src="//cdn.gtranslate.net/widgets/latest/dwf.js" defer></script>
        <script>window.gtranslateSettings = {"default_language":"vi","detect_browser_language":false,"wrapper_selector":".gtranslate_wrapper","flag_size":18,"switcher_horizontal_position":"inline"}</script>

        {{--
        <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
        <script type="text/javascript">
            function googleTranslateElementInit() {
                new google.translate.TranslateElement({ pageLanguage: 'vi', layout: google.translate.TranslateElement.InlineLayout.SIMPLE, autoDisplay: false }, 'google_translate_element');
            }

            function translateLanguage(lang, lang_vn)
            {
                googleTranslateElementInit();
                var $frame = $('.VIpgJd-ZVi9od-xl07Ob-OEVmcd');
                console.log($frame);
                if (!$frame.length) {
                    alert("Error: Could not find Google translate frame.");
                    return false;
                }
                // alert($frame.length);
                $frame.each(function(index, el) {
                    // alert($(this).contents().find('.VIpgJd-ZVi9od-vH1Gmf span.text:contains(' + lang_vn + ')').length);

                    if($(this).contents().find('.VIpgJd-ZVi9od-vH1Gmf span.text:contains(' + lang + ')').length > 0){
                        $(this).contents().find('.VIpgJd-ZVi9od-vH1Gmf span.text:contains(' + lang + ')').get(0).click();
                        return false;
                    }
                    if($(this).contents().find('.VIpgJd-ZVi9od-vH1Gmf span.text:contains(' + lang_vn + ')').length > 0){
                        $(this).contents().find('.VIpgJd-ZVi9od-vH1Gmf span.text:contains(' + lang_vn + ')').get(0).click();
                        return false;
                    }
                });
                
                return false;
            }
            
            jQuery(document).ready(function(){
                $(document).on('click', '.lang-choise a', function(){
                    var lang = $(this).attr('data'),
                    lang_vn = $(this).attr('data-vn');
                    @if($agent->isMobile())
                    // alert(lang +'____'+ lang_vn);
                    @endif
                    console.log(lang +'____'+ lang_vn);

                    translateLanguage(lang, lang_vn);

                    var html = $(this).html();
                    $('.lang-current').html( html );
                    // location.reload();
                });
                var current_lang = readCookie('googtrans');
                if(current_lang){
                    $('.lang-choise li').each(function(){
                        var current = $(this).find('a').data('lang'),
                            html = $(this).find('a').html();
                        // console.log(current);
                        current = current.replace("|", "/");
                        if(current_lang == "/"+current)
                        {
                            // console.log(html);
                            $('.lang-current').html( html );
                            return false;
                        }
                    });
                }
                // console.log(current_lang);
            });

            function readCookie(name) {
                var c = document.cookie.split('; '),
                cookies = {}, i, C;

                for (i = c.length - 1; i >= 0; i--) {
                    C = c[i].split('=');
                    cookies[C[0]] = C[1];
                 }

                 return cookies[name];
            }
        </script>
        --}}

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

        {!! htmlspecialchars_decode(setting_option('footer-script')) !!}
        @stack('after-footer')
        @stack('scripts')
</body>

</html>
