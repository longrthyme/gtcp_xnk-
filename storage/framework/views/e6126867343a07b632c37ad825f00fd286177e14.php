<?php
    if(empty($products))
    {
        $category_id = $category_sub->id??$category->id;
        
        $products = $modelProduct->setCategory($category_id)->getList([
            'post_type' => $post_type,
        ]);
    }
?>


<?php if(!empty($products) && $products->count()): ?>
<div class="table-responsive text-center">
    <table class="table table-bordered mb-0 tablefilter">
        <thead class="table-light align-middle">
            <tr>
                <th class="nosort">Loại xe</th>
                <th class="nosort">Trọng tải</th>
                <th>Thùng xe Dài</th>
                <th>Thùng xe Rộng</th>
                <th>Thùng xe Cao</th>
                <th>Giá 10km đầu</th>
                <th>Giá 11km - 44km</th>
                <th>Giá từ km 45</th>
                <th>Thời gian chờ</th>

                <th>Hiệu lực giá</th>
                <th class="nosort">Lựa chọn xe</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $options = $product->getOptions();
                    
                    $options_unit = (new \App\Models\ShopOption)->whereIn('id', array_keys($options))->get()->pluck('unit', 'id')->toArray();
                    
                    $product_categories = $product->getCategories();
                    if(count($product_categories))
                    {
                        $category_end = end($product_categories);
                        $category_end = $modelCategory->getDetail($category_end['id']);
                    }
                ?>
                <tr>
                    <td><?php echo e($options[202]??''); ?> - <?php echo e($options[30]??''); ?></td>
                    <td><?php echo e($options[206]??''); ?><?php echo e($options[136]??''); ?></td>
                    <td>
                        <?php echo e($options[207]??''); ?><?php echo e($options_unit[207]??''); ?>

                    </td>
                    <td>
                        <?php echo e($options[208]??''); ?><?php echo e($options_unit[208]??''); ?>

                    </td>
                    <td>
                        <?php echo e($options[209]??''); ?><?php echo e($options_unit[209]??''); ?>

                    </td>
                    <td><?php echo render_price($product->price); ?></td>
                    <td><?php echo !empty($options[211]) ? render_price($options[211]) : ''; ?>/km</td>
                    <td><?php echo !empty($options[212]) ? render_price($options[212]) : ''; ?>/km</td>
                    <td><?php echo !empty($options[213]) ? render_price($options[213]) : ''; ?>/h</td>
                    <td><?php echo e($product->getDateAvailable()); ?></td>
                    <td><a href="<?php echo e($product->getUrl()); ?>" class="btn btn-contacts">Liên hệ ngay >> </a></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php else: ?>
    <p>Rất tiếc, thông tin bạn tìm kiếm chưa có sẵn, Vui lòng gửi yêu cầu chào giá để nhận được báo giá sớm nhất</p>
<?php endif; ?><?php /**PATH /home/long/Downloads/GTCPLATFORM-main/resources/views/theme/product/van-chuyen/ftl.blade.php ENDPATH**/ ?>