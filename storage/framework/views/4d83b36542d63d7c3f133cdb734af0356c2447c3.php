<?php
    $options = $product->getOptions();
?>
<div class="item-product">
    <a href="<?php echo e($product->getUrl()); ?>">
        <div class="thumb-product">
            <img class="lazyload" data-src="<?php echo e(asset($product->image)); ?>" src="<?php echo e(asset('assets/images/no-image.jpg')); ?>" onerror="if (this.src != '<?php echo e(asset($product->getAuth->avatar??'')); ?>') this.src = '<?php echo e(asset($product->getAuth->avatar??'')); ?>';" alt="<?php echo e($product->name); ?>">
        </div>
        <div class="bottom-wrapper">
            <div class="price">
                <?php if(!empty($options[202])): ?>
                    <div>Loại xe: <?php echo e($options[202]??''); ?></div>
                    <div>Trọng tải: <?php echo e($options[206]??''); ?><?php echo e($options[136]??''); ?></div>
                    <div class="price-main">Giá vận chuyển: <?php echo render_price($product->price); ?></div>
                    <div class="price-main">Giá xe chờ: <?php echo render_price($options[213]??0); ?></div>
                <?php else: ?>
                    <?php if(!empty($options[126])): ?>
                    <div class="price-location">Tuyến vận chuyển chính: <span title="<?php echo e($options[126]); ?>"><?php echo e($options[126]); ?></span></div>
                    <?php endif; ?>
                    <div>
                        <?php echo e($product->getAddressFull()?current($product->getAddressFull()):''); ?> - <?php echo e($product->getAddressEnd()?current($product->getAddressEnd()):''); ?>

                    </div>
                    <?php if(!empty($options[35])): ?>
                    <div>
                        Khởi hành: <?php echo e($options[35]); ?>

                    </div>
                    <?php endif; ?>
                    <div class="price-main">Giá vận chuyển : <?php echo render_price($product->price); ?><?php echo e(!empty($options[159]) ? '/'. $options[159] : ''); ?></div>
                <?php endif; ?>
            </div>
        </div>
    </a>
</div><?php /**PATH /home/long/Downloads/GTCPLATFORM-main/resources/views/theme/product/van-chuyen/product_item.blade.php ENDPATH**/ ?>