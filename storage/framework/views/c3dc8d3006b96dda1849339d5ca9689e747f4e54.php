<?php extract($data) ?>

<?php 
    $sliders = $modelSlider->getList([
        'parent'    => $slider_id
    ]); 
?>
<?php if(count($sliders)>0): ?>
<div class="container mt-1">
    <div class="banner-carousel-loading">
    	<div class="owl-carousel banner-carousel" data='{"item":4, "tablet":4, "mobile":2}'>
            <?php $__currentLoopData = $sliders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(url($item->link??'#')); ?>" class="owl-carousel-item position-relative">
                <img class="img-fluid" src="<?php echo e(asset($item->src)); ?>" alt="<?php echo e($item->name); ?>" width="250" height="80" />
            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

	<div class="row align-item-center">
		<div class="col-lg-12 py-3 my-3 text-center slogan-top">
			<?php echo setting_option('slogan-top'); ?>

		</div>
	</div>
</div>
<?php endif; ?><?php /**PATH /home/long/Downloads/GTCPLATFORM-main/resources/views/shortcode/banner.blade.php ENDPATH**/ ?>