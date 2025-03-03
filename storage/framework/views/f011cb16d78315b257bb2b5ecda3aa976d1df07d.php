<?php
    $categories = $modelCategory->getList([
        'parent'    => 0,
        'limit' => 20
    ]);
    /*
    $show_category = $show_category??0;
    */

    $menus = Menu::getByName('Category-home');
?>
<div class="block-search">
    <div class="container">
        <div class="search-feature">
            <form action="<?php echo e(route('search')); ?>" class="form-inline form-search">
                <div class="input-search input-w-auto icon">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="search" name="keyword" class="form-control" placeholder="Tìm kiếm theo tiêu đề, từ khóa..." />
                </div>
                <div class="input-search">
                    <select name="category" class="select2">
                        <option value="">Chọn  danh mục</option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($item->id); ?>"><?php echo e($item->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <input type="submit" value="TÌM KIẾM">
            </form>
        </div>
        <?php if($show_category != 1): ?>
        <div class="list-cate-slider">
            <div class="archive-slider d-flex owl-carousel" style="opacity: 0">
                <?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    //$category = $modelCategory->getDetail($item['link'], 'slug');
                ?>
                <div class="item-cate">
                    <a href="<?php echo e(url($item['link']??'#')); ?>">
                        <div class="thumb-cate">
                            <img src="<?php echo e(asset($item['icon'])); ?>" alt="<?php echo $item['label']; ?>" width="36" height="36">
                        </div>
                        <div class="content-cate">
                            <h3><?php echo $item['label']; ?></h3>
                            
                            <p class="view">Xem tin <i class="fa-solid fa-arrow-right"></i></p>
                        </div>
                    </a>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                
            </div>
        </div>
        <?php endif; ?>
    </div>
</div><?php /**PATH /home/long/Downloads/GTCPLATFORM-main/resources/views/shortcode/filter.blade.php ENDPATH**/ ?>