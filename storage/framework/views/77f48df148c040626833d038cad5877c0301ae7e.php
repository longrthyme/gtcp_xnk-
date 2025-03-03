<?php
    $post_type = 'buy';

    $category = $modelCategory->getDetail(18);

    $categories = $modelCategory->getList(['parent' => $category->id]);
    $category_folder = $templatePath .'.product.'. $category->slug;
?>
<?php if(!empty($categories)): ?>
    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $products = $modelProduct->setCategory($category_item->id)->getList([
                'post_type' => $post_type??'sell',
                'transportation' => $transportation??0
            ]);

            $view = ($category_folder??'').'.product-list';
            if(!empty($category_folder) && \View::exists($category_folder.'.'. $category_item->slug ."-$post_type"))
            {
                $view = $category_folder.'.'. $category_item->slug ."-$post_type";
            }
            
        ?>
        <?php if($products->count()): ?>
        <div class="container mb-3">
            <h4>Yêu cầu chào giá <?php echo e($category_item->name); ?></h4>
            <?php echo $__env->make($view, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php else: ?>
    <?php
        $view = $templatePath.'.product.product_list';
        if(!empty($category_path) && \View::exists($category_path . '.'. $category_sub->slug))
            $view = $category_path . '.'. $category_sub->slug;
    ?>
    <?php echo $__env->make($view, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>
<?php /**PATH /home/long/Downloads/GTCPLATFORM-main/resources/views/shortcode/yeu-cau-chao-gia.blade.php ENDPATH**/ ?>