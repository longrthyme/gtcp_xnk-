<?php
    $location = $product->getLocation(['address1', 'country']);
    $options = $product->getOptions();
?>
<div class="item-product">
    <a href="<?php echo e($product->getUrl()); ?>">
        <div class="thumb-product">
            <img class="lazyload" data-src="<?php echo e(asset($product->image)); ?>" src="<?php echo e(asset('assets/images/no-image.jpg')); ?>" onerror="if (this.src != '<?php echo e(asset($product->getAuth->avatar??'')); ?>') this.src = '<?php echo e(asset($product->getAuth->avatar??'')); ?>';" alt="<?php echo e($product->name); ?>">
        </div>
        <div class="bottom-wrapper">
            <div class="content-product">
                <h3 class="mb-0"><?php echo e($product->name); ?></h3>
            </div>
            <div class="price">
                <?php if($product->price_max>0): ?>
                    <div class="priice-main"><?php echo render_price($product->price); ?> - <?php echo render_price($product->price_max); ?></div>
                <?php else: ?>
                    <?php if($location != ''): ?>
                    <div class="price-location">
                        Vị trí kho bãi: 
                        <span title="<?php echo e($product->country); ?>"><?php echo e($location); ?></span>
                    </div>
                    <?php endif; ?>
                    <div class="price-main">Giá cho thuê : <?php echo render_price($product->price); ?><?php echo e(!empty($options[143]) ? '/'. $options[143] : ''); ?></div>
                <?php endif; ?>
            </div>
        </div>
    </a>
</div><?php /**PATH /home/long/Downloads/GTCPLATFORM-main/resources/views/theme/product/kho-bai/product_item.blade.php ENDPATH**/ ?>