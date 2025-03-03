<?php
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
                    
                    <?php if(count($product->getAddressFull())): ?>
                    <div class="price-location">Xuất xứ: <?php echo e($product->getOrigin()); ?></div>
                    <?php endif; ?>
                    <?php if($product->address_end): ?>
                    <div class="price-location">Nơi bán: <?php echo e($product->getPlaceSale()); ?></div>
                    <?php endif; ?>
                    <div class="price-main">Giá EXW : <?php echo render_price($product->price); ?> <?php echo e(!empty($options[136]) ? '/ '. $options[136] : ''); ?></div>
                <?php endif; ?>
            </div>
        </div>
    </a>
</div><?php /**PATH /home/long/Downloads/GTCPLATFORM-main/resources/views/theme/product/product_item.blade.php ENDPATH**/ ?>