<div class="block-newletters py-5" style="background: url(<?php echo e(asset(setting_option('contact-bg'))); ?>) center center no-repeat; background-size: cover;">
    <div class="container">
        <div class="row g-3 align-items-center wow fadeInUp" data-wow-delay="0.3s">
            <div class="col-md-7">
                <div class="left-content">
                    <?php echo setting_option('contact-text'); ?>

                </div>
            </div>
            <div class="col-md-5">
                <div class="right-form">
                    <form method="POST" action="<?php echo e(sc_route('contact.submit')); ?>" id="contact_form">
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <input type="text" class="form-control" name="contact[company]" placeholder="Tên công ty" required />
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="name" name="contact[firstname]" placeholder="Tên người liên hệ" required />
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" id="email" name="contact[email]" placeholder="Email" required />
                        </div>
                        <div class="form-group">
                            <input type="tel" class="form-control" id="tel" name="contact[phone]" placeholder="Số điện thoại" required />
                        </div>
                        <div class="send">
                            <button class="btn btn-send" type="submit">GỬI</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div><?php /**PATH /home/long/Downloads/GTCPLATFORM-main/resources/views/shortcode/contact.blade.php ENDPATH**/ ?>