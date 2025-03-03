<div class="dropdown-menu">
	<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<?php
			$link = url($menu['link']??'#')
		?>
	    <div class="<?php echo e(count($menu['child'])?'dropdown':''); ?>">
	    	<a class="dropdown-item" href="<?php echo e($link); ?>"><?php echo e($menu['label']); ?></a>

		    <?php if($menu['child']): ?>
		    	<div href="<?php echo e($value['link']); ?>" class="nav-toggle <?php echo e(count($menu['child'])?'dropdown-toggle':''); ?>" data-bs-toggle="dropdown" aria-expanded="false"></div>
		    	<?php echo $__env->make($templatePath .'.layouts.menu-main-child', ['data' => $menu['child']], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		    <?php endif; ?>
	    </div>		
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php /**PATH /home/long/Downloads/GTCPLATFORM-main/resources/views/theme/layouts/menu-main-child.blade.php ENDPATH**/ ?>