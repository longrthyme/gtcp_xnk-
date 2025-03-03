<?php
	$menus = Menu::getByName($menu);
?>
<?php if($menus): ?>
	<?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	<div class="block-keyword py-5">
	    <div class="container">
	        <div class="section-title">
	            <h4><?php echo e($menu['label']); ?></h4>
	        </div>
	        <?php if($menu['child']): ?>
		        <?php
		        	$menu_child = array_chunk($menu['child'], 6);
		        ?>
		        <div class="list-keyword">
		        <?php $__currentLoopData = $menu_child; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		            <div class="nav-item-keyword">
		                <ul>
		                	<?php $__currentLoopData = $child; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		                    <li>
		                        <a href="<?php echo e(url($item['link']??'#')); ?>"><?php echo e($item['label']); ?></a>
		                    </li>
		                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		                </ul>
		            </div>
		        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		        </div>
	        <?php endif; ?>
	    </div>
	</div>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?><?php /**PATH /home/long/Downloads/GTCPLATFORM-main/resources/views/shortcode/keyword.blade.php ENDPATH**/ ?>