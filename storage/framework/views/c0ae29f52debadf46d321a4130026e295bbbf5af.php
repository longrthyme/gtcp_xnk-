<?php
    $page = $modelPage->getDetail(143);
    $ses = (int)$page->slug * 1000;
?>
<?php if($page): ?>
<div class="modal fade" id="popupModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <?php if($page->description != ''): ?>
                <div class="popup-top">
                    <?php echo htmlspecialchars_decode($page->description); ?>

                </div>
                <?php endif; ?>
                <div class="popup-body">
                <?php echo htmlspecialchars_decode($page->content); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php $__env->startPush('scripts'); ?>
    <script>
        jQuery(document).ready(function($) {
            setTimeout(function(){
                $('#popupModal').modal('show');
            }, <?php echo e($ses); ?>)
        });
    </script>
<?php $__env->stopPush(); ?><?php /**PATH /home/long/Downloads/GTCPLATFORM-main/resources/views/theme/layouts/popup.blade.php ENDPATH**/ ?>