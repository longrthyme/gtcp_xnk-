<?php
    if(empty($products))
    {
        $category_id = $category_sub->id??$category->id;
        
        $products = $modelProduct->setCategory($category_id)->getList([
            'post_type' => $post_type
        ]);
    }

?>


<?php if(!empty($products) && $products->count()): ?>
<div class="table-responsive text-center">
    <table class="table table-bordered mb-0 tablefilter">
        <thead class="table-light align-middle">
            <tr>
                <th>Phương thức vận chuyển</th>
                <th>Loại hàng hoá</th>
                <th>Trọng lượng</th>
                <th>Thể tích</th>

                <th>Dài</th>
                <th>Rộng</th>
                <th>Cao</th>
                
                <th>Nơi đi</th>
                <th>Nơi đến</th>
                <th>Ngày bốc hàng dự kiến</th>
                <th>Thời hạn báo giá</th>
                <th class="nosort">Liên hệ báo giá</th>
            </tr>
        </thead>
        <tbody class="align-middle">
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $options = $product->getOptions();
                //dd($options);
                $product_categories = $product->getCategories();
                if(count($product_categories))
                {
                    $category_end = end($product_categories);
                    $category_end = $modelCategory->getDetail($category_end['id']);
                }
            ?>
            <tr>
                <td><?php echo e($options[104]??''); ?></td>
                <td><?php echo e($category_item->name??''); ?></td>
                <td><?php echo e($options[44]??''); ?><?php echo e(sc_option_unit(44)); ?> <?php echo e($options[159]??''); ?></td>
                <td><?php echo e($options[45]??''); ?><?php echo e(sc_option_unit(45)); ?></td>

                <td><?php echo e($options[156]??''); ?><?php echo e(sc_option_unit(156)); ?></td>
                <td><?php echo e($options[157]??''); ?><?php echo e(sc_option_unit(157)); ?></td>
                <td><?php echo e($options[158]??''); ?><?php echo e(sc_option_unit(158)); ?></td>

                
                <td><?php echo e(implode(', ', $product->getAddressFull())); ?></td>
                <td><?php echo e(implode(', ', $product->getAddressEnd())); ?></td>
                <td><?php echo e($options[35]??''); ?></td>
                <td><?php echo e($product->getDateAvailable()); ?></td>
                
                <td><a href="<?php echo e($product->getUrlBaoGia()); ?>" class="btn btn-contacts">Báo giá ngay >> </a></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php else: ?>
    <p>Rất tiếc, thông tin bạn tìm kiếm chưa có sẵn, Vui lòng gửi yêu cầu chào giá để nhận được báo giá sớm nhất</p>
<?php endif; ?><?php /**PATH /home/long/Downloads/GTCPLATFORM-main/resources/views/theme/product/van-chuyen/bb-buy.blade.php ENDPATH**/ ?>