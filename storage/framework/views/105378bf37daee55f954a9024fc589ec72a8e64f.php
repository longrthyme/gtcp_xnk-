<?php
    if(empty($products))
    {
        $category_id = $category_sub->id??$category->id;
        
        $products = $modelProduct->setCategory($category_id)->getList([
            'post_type' => $post_type
        ]);
    }
?>
<div class="row g-3">
    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-lg-4 col-md-6">
        <?php echo $__env->make($category_folder . '.product_item', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php if($products instanceof \Illuminate\Pagination\AbstractPaginator): ?>
<?php echo $products->links(); ?>

<?php endif; ?><?php /**PATH /home/long/Downloads/GTCPLATFORM-main/resources/views/theme/product/viec-lam/product-list.blade.php ENDPATH**/ ?>