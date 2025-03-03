@php
    $footer = $modelPage->getDetail('footer', 'slug');
@endphp
@if($footer)
<footer class="footer wow fadeIn" data-wow-delay="0.1s">
    <div class="container-fluid px-lg-5 py-5">
        {!! htmlspecialchars_decode($footer->content) !!}
    </div>
    <div class="copyright">
        <p>@2024 - Bản quyền thuộc về Công ty TNHH Kết Nối Thương Mại VNG. All rights reserved.</p>
    </div>
</footer>
@endif

<div class="click_phone quick-alo-phone quick-alo-show" id="quick-alo-phoneIcon" style="right: 60px;bottom: 280px;"> 
   <a class="hotline_index" target="_blank" href="mailto:{{ setting_option('email') }}?subject=Liên hệ&body={{ setting_option('company_name') }}" target="_top" title="Gửi Email">
        <div class="quick-alo-ph-circle"></div>
    </a>
    <a class="hotline_index" target="_blank" href="mailto:{{ setting_option('email') }}?subject=Liên hệ&body={{ setting_option('company_name') }}" title="Gửi Email">
        <div class="quick-alo-ph-circle-fill"></div>
    </a> 
    <a class="hotline_index" target="_blank" href="mailto:{{ setting_option('email') }}?subject=Liên hệ&body={{ setting_option('company_name') }}" title="Gửi Email">
        <div class="quick-alo-ph-img-circle quick-alo-ph-img-circle-email quick-alo-ph-img-circle-phone"> </div>
    </a> 
</div>
<div class="click_phone quick-alo-phone quick-alo-show" id="quick-alo-phoneIcon" style="right: 60px;bottom: 210px;"> 
   <a class="hotline_index" target="_blank" href="tel:{{ setting_option('hotline') }}" title="Phone">
        <div class="quick-alo-ph-circle"></div>
    </a>
    <a class="hotline_index" target="_blank" href="tel:{{ setting_option('hotline') }}" title="Phone">
        <div class="quick-alo-ph-circle-fill"></div>
    </a> 
    <a class="hotline_index" target="_blank" href="tel:{{ setting_option('hotline') }}" title="Phone">
        <div class="quick-alo-ph-img-circle quick-alo-ph-img-circle-hotline quick-alo-ph-img-circle-phone"> </div>
    </a> 
</div>

<div class="click_phone quick-alo-phone quick-alo-green quick-alo-show" id="quick-alo-phoneIcon" style="right: 60px;bottom: 140px;"> 
   <a class="hotline_index" target="_blank" href="{{ setting_option('zalo_url') }}" title="Zalo">
        <div class="quick-alo-ph-circle"></div>
    </a>
    <a class="hotline_index" target="_blank" href="{{ setting_option('zalo_url') }}" title="Zalo">
        <div class="quick-alo-ph-circle-fill"></div>
    </a> 
    <a class="hotline_index" target="_blank" href="{{ setting_option('zalo_url') }}" title="Zalo">
        <div class="quick-alo-ph-img-circle quick-alo-ph-img-circle-zalo"> </div>
    </a> 
</div>