<?php
	$agent = new \Jenssegers\Agent\Agent;
?>
<ul class="navbar-nav">
	<?php $__currentLoopData = $headerMenu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<?php
			$class_active ='';
		?>
		<?php if(empty($value['child'])): ?>
			<li class="nav-item <?php echo e($class_active); ?>"><a href="<?php echo e($value['link']); ?>" class="nav-link"><?php echo e($value['label']); ?></a></li>
		<?php else: ?>
			<li class="nav-item dropdown <?php echo e($class_active); ?>">
				<a href="<?php echo e($value['link']); ?>" class="nav-link"><?php echo e($value['label']); ?></a>
				<?php if($agent->isMobile()): ?>
				<div href="<?php echo e($value['link']); ?>" class="nav-toggle dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"></div>
				<?php endif; ?>
				
				<?php echo $__env->make($templatePath .'.layouts.menu-main-child', ['data' => $value['child']], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			</li>
		<?php endif; ?>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul><?php /**PATH /home/long/Downloads/GTCPLATFORM-main/resources/views/theme/layouts/menu-main.blade.php ENDPATH**/ ?>