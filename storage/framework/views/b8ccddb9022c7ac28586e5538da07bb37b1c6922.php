<?php
    if(empty($products))
    {
        $category_id = $category_sub->id??$category->id;
        
        $products = $modelProduct->setCategory($category_id)->getList([
            'post_type' => $post_type,
            'transportation' => request('transportation')??''
        ]);
    }
?>

<?php if(!empty($products) && $products->count()): ?>
<div class="table-responsive text-center">
    <table class="table table-bordered mb-0 tablefilter">
        <thead class="table-light align-middle ">
            <tr>
                <th class="nosort">Phương thức vận chuyển</th>
                <th>Nơi đi</th>
                <th>Nơi đến</th>

                

                <th class="nosort">Lịch khởi hành</th>
                <th>Thời gian vận chuyển</th>
                <th>Giá vận chuyển</th>
                <th>Phụ phí</th>
                <th>Tổng giá vận chuyển</th>
                <th>Hiệu lực giá</th>
                <th class="nosort">Lựa chọn báo giá</th>
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
                <td><?php echo e($product->getAddressFullRender()); ?></td>
                <td><?php echo e($product->address_end); ?></td>

                <td><?php echo e($options[35]??''); ?></td>
                <td><?php echo e($options[36]??''); ?></td>
                <td>
                    <?php echo render_price($product->price??0); ?><?php echo e(!empty($options[159]) ? '/'. $options[159] : ''); ?>

                </td>
                <td>
                    <?php echo render_price($product->cost??0); ?>

                </td>
                <td>
                    
                    <?php echo render_price($product->price+$product->cost); ?><?php echo e(!empty($options[159]) ? '/'. $options[159] : ''); ?>

                </td>
                <td><?php echo e($product->getDateAvailable()); ?></td>

                <td><a href="<?php echo e($product->getUrl()); ?>" class="btn btn-contacts">Liên hệ ngay >> </a></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php else: ?>
    <p>Rất tiếc, thông tin bạn tìm kiếm chưa có sẵn, Vui lòng gửi yêu cầu chào giá để nhận được báo giá sớm nhất</p>
<?php endif; ?><?php /**PATH /home/long/Downloads/GTCPLATFORM-main/resources/views/theme/product/van-chuyen/lcl.blade.php ENDPATH**/ ?>