<?php
    $limit = $limit??'';
    $products = $modelProduct;

    $url = sc_route('shop');

    if(!empty($category_id))
    {
        $category = $modelCategory->getDetail($category_id);

        $category_parent = $category->getParentFirst($category);
        $products = $products->setCategory($category_id);

        if(\View::exists($templatePath .'.product.'. $category_parent->slug .'.product_item'))
            $templattePath_view = $templatePath .'.product.'. $category_parent->slug .'.product_item';
    }
    $products = $products->getList([
        'post_type' => 'sell',
        'image' => true,
        'product_home' => true,
        'limit' => $limit
    ]);

?>
<?php if(!empty($category) && $category->count() && $products->count()): ?>
<div class="block-product py-4">
    <div class="container">
        
        <div class="section-title">
            <h4><?php echo e(!empty($title) && $title!='' ? $title : $category->name??''); ?></h4>
            <div class="d-flex align-items-center ms-md-3">
                <i class="fa-solid fa-arrow-right-long"></i>
                <a href="/dang-tin" class="btn btn-custom ms-md-3">Đăng tin ngay!</a>
            </div>
            <a class="view-more" href="<?php echo e($url); ?>">Xem tất cả <i class="fa-solid fa-arrow-right"></i></a>
        </div>
        <?php if(!empty($templattePath_view) && \View::exists($templattePath_view)): ?>
            <div class="row g-3">
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-6 col-md-3 col-20">
                    <?php echo $__env->make($templattePath_view, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            
        <?php else: ?>
            <?php if ($__env->exists($templatePath_2, compact('products', 'category_folder'))) echo $__env->make($templatePath_2, compact('products', 'category_folder'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?><?php /**PATH /home/long/Downloads/GTCPLATFORM-main/resources/views/shortcode/product_new.blade.php ENDPATH**/ ?>