<?php
    $footer = $modelPage->getDetail('footer', 'slug');
?>
<?php if($footer): ?>
<footer class="footer wow fadeIn" data-wow-delay="0.1s">
    <div class="container-fluid px-lg-5 py-5">
        <?php echo htmlspecialchars_decode($footer->content); ?>

    </div>
    <div class="copyright">
        <p>@2024  - Bản quyền thuộc về Công ty TNHH Kết Nối Thương Mại VNG. All rights reserved.</p>
    </div>
</footer>
<?php endif; ?>

<div class="click_phone quick-alo-phone quick-alo-show" id="quick-alo-phoneIcon" style="right: 60px;bottom: 280px;"> 
   <a class="hotline_index" target="_blank" href="mailto:<?php echo e(setting_option('email')); ?>?subject=Liên hệ&body=<?php echo e(setting_option('company_name')); ?>" target="_top" title="Gửi Email">
        <div class="quick-alo-ph-circle"></div>
    </a>
    <a class="hotline_index" target="_blank" href="mailto:<?php echo e(setting_option('email')); ?>?subject=Liên hệ&body=<?php echo e(setting_option('company_name')); ?>" title="Gửi Email">
        <div class="quick-alo-ph-circle-fill"></div>
    </a> 
    <a class="hotline_index" target="_blank" href="mailto:<?php echo e(setting_option('email')); ?>?subject=Liên hệ&body=<?php echo e(setting_option('company_name')); ?>" title="Gửi Email">
        <div class="quick-alo-ph-img-circle quick-alo-ph-img-circle-email quick-alo-ph-img-circle-phone"> </div>
    </a> 
</div>
<div class="click_phone quick-alo-phone quick-alo-show" id="quick-alo-phoneIcon" style="right: 60px;bottom: 210px;"> 
   <a class="hotline_index" target="_blank" href="tel:<?php echo e(setting_option('hotline')); ?>" title="Phone">
        <div class="quick-alo-ph-circle"></div>
    </a>
    <a class="hotline_index" target="_blank" href="tel:<?php echo e(setting_option('hotline')); ?>" title="Phone">
        <div class="quick-alo-ph-circle-fill"></div>
    </a> 
    <a class="hotline_index" target="_blank" href="tel:<?php echo e(setting_option('hotline')); ?>" title="Phone">
        <div class="quick-alo-ph-img-circle quick-alo-ph-img-circle-hotline quick-alo-ph-img-circle-phone"> </div>
    </a> 
</div>

<div class="click_phone quick-alo-phone quick-alo-green quick-alo-show" id="quick-alo-phoneIcon" style="right: 60px;bottom: 140px;"> 
   <a class="hotline_index" target="_blank" href="<?php echo e(setting_option('zalo_url')); ?>" title="Zalo">
        <div class="quick-alo-ph-circle"></div>
    </a>
    <a class="hotline_index" target="_blank" href="<?php echo e(setting_option('zalo_url')); ?>" title="Zalo">
        <div class="quick-alo-ph-circle-fill"></div>
    </a> 
    <a class="hotline_index" target="_blank" href="<?php echo e(setting_option('zalo_url')); ?>" title="Zalo">
        <div class="quick-alo-ph-img-circle quick-alo-ph-img-circle-zalo"> </div>
    </a> 
</div><?php /**PATH /home/long/Downloads/GTCPLATFORM-main/resources/views/theme/layouts/footer.blade.php ENDPATH**/ ?>