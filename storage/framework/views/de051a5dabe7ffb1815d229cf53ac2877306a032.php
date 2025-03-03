<?php
    $category_child = $modelCategory->getList(['parent' => 18]);
    $category = $modelCategory->getDetail(18);
?>

<div class="block-service">
    <div class="container">
        <div class="freight-services">
            <?php $__currentLoopData = $category_child; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $products = $modelProduct->setCategory($item->id)->getList([
                        'product_home' => true,
                        'post_type' => 'sell',
                        'limit' => 10,
                        'user_id' => $author??0,
                    ]);

                    $slug = $category->slug??'';
                    $slug_sub = $item->slug??'';

                    $templateCategory_path = $templatePath .".product.". $slug .".product-list";
                    $templateCategorySub_path = $templatePath .".product.$slug.$slug_sub"; // goi blade view danh muc sub


                    $templattePath_view = '';
                    if (View::exists($templateCategorySub_path))
                        $templattePath_view = $templateCategorySub_path;
                    elseif (View::exists($templateCategory_path))
                        $templattePath_view = $templateCategory_path;

                ?>
                <?php if($products->count()): ?>
                    <div class="title-freight">
                        <h4>Vận chuyển <?php echo e($item->name); ?></h4>
                    </div>
                    <?php if ($__env->exists($templattePath_view)) echo $__env->make($templattePath_view, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
        </div>
        
    </div>
</div><?php /**PATH /home/long/Downloads/GTCPLATFORM-main/resources/views/shortcode/van-chuyen.blade.php ENDPATH**/ ?>