<?php
    $location = $product->getLocation(['address1', 'country']);
    $author = $product->getAuth;
?>
<div class="item-product vieclam-item">
    <a href="<?php echo e($product->getUrl()); ?>">
        <div class="thumb-product">
            <div class="img">
                <img class="lazyload" data-src="<?php echo e(asset($product->image)); ?>" src="<?php echo e(asset('assets/images/no-image.jpg')); ?>" onerror="if (this.src != '<?php echo e(asset($product->getAuth->avatar??'')); ?>') this.src = '<?php echo e(asset($product->getAuth->avatar??'')); ?>';" alt="<?php echo e($product->name); ?>">
            </div>
        </div>
        <div class="bottom-wrapper">
            <div class="content-product">
                <h3 class="mb-0" title="<?php echo e($product->name); ?>"><?php echo e($product->name); ?></h3>
                <div><b><?php echo e($author->company); ?></b></div>
            </div>
            <div class="price">
                <?php if($product->price_max>0): ?>
                    <div class="priice-main"><?php echo render_price($product->price); ?> - <?php echo render_price($product->price_max); ?></div>
                <?php else: ?>
                    <?php if(count($product->getAddressFull())): ?>
                    <div class="price-location"><span title="<?php echo e($location); ?>"><?php echo e($location); ?></span></div>
                    <?php endif; ?>
                    <div class="price-main">Mức lương : <?php echo render_price($product->price); ?></div>
                <?php endif; ?>
            </div>
        </div>
    </a>
</div><?php /**PATH /home/long/Downloads/GTCPLATFORM-main/resources/views/theme/product/viec-lam/product_item.blade.php ENDPATH**/ ?>