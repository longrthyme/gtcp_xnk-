<?php
    $menu = Menu::getByName('Hot-search')                          ;
?>
<div class="search-keyword">
    <h5>Từ khoá tìm kiếm</h5>
    <ul>
        <?php $__currentLoopData = $menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li><a href="<?php echo e(route('search', ['keyword' => $item['link']])); ?>" class="<?php echo e($item['class']); ?>"><?php echo e($item['label']); ?></a></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</div><?php /**PATH /home/long/Downloads/GTCPLATFORM-main/resources/views/theme/product/search-hot-keyword.blade.php ENDPATH**/ ?>