<?php $__env->startSection('content'); ?>
    <!-- Page Header Start -->
    <div class="single-breadcrumbs bg-light">
        <div class="container py-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/"><?php echo e(sc_language_render('front.home')); ?></a></li>
                    <?php if(!empty($categories)): ?>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $item_category = $modelCategory->getDetail($item['id']);
                                if($index <2)
                                    $item_url = $item_category->getUrl($item_slug??'');
                            ?>
                            <li class="breadcrumb-item"><a href="<?php echo e($index <2? $item_url: $item_url.'?category='. $item['id']); ?>"><?php echo e($item_category->name); ?></a></li>
                            <?php
                                $item_slug = $item['slug'];
                            ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->
    <div class="block-single">
        <div class="container">
            <div class="row g-3">
                <div class="col-md-9">
                    <?php if(!empty($category_main) && \View::exists($templatePath .".product.". $category_main->slug .".single-content")): ?>
                        <?php echo $__env->make($templatePath .".product.". $category_main->slug .".single-content", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php else: ?>
                    <div class="content-detail">
                        <h2><?php echo e($product->name); ?></h2>
                        <div class="bottom-info">
                            <div class="item icon-clock">
                                <i class="fa-regular fa-clock"></i>
                                <?php echo e(date('H:i d/m/Y', strtotime($product->created_at))); ?>

                            </div>
                            
                            <div class="item">
                                <?php if(count($product->getAddressFull())): ?>
                                <div class=""><i class="fa-solid fa-location-dot"></i> <?php echo e(implode(', ', $product->getAddressFull())); ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="ms-auto">
                                <?php echo $__env->make($templatePath .'.layouts.share-box', ['text' => $product->name], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>

                        <?php if(!empty($galleries)): ?>
                        <div class="image-gallery-block">
                            <div class="xzoom-container">
                                <a data-fancybox-trigger="gallery" href="javascript:;">
                                    <img class="xzoom" id="xzoom-default" src="<?php echo e($product->getGallery()[0]); ?>"
                                        xoriginal="<?php echo e($product->getGallery()[0]); ?>" title="Product 1 is awesome" />
                                </a>
                                
                                <div class="xzoom-thumbs">
                                    <?php $__currentLoopData = $product->getGallery(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a class="popup" data-fancybox="gallery" href="<?php echo e($item); ?>">
                                        <img class="xzoom-gallery" src="<?php echo e($item); ?>" xpreview="<?php echo e($item); ?>" title="Product 1 is awesome" width="112" />
                                    </a>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <div class="product-detail_description">
                            <h5>Mô tả chi tiết</h5>
                            <div style="white-space: pre-line;">
                                <?php echo htmlspecialchars_decode($product->content??''); ?>

                            </div>
                        </div>

                        

                    </div>
                    <?php endif; ?>
                </div>

                <div class="col-md-3">
                    <div class="right-sidebar">
                        <div class="info-sidebar">
                            <div class="product-price">
                                <div class="price-single">
                                    <?php echo render_price($product->price); ?>

                                    <?php echo e(!empty($options[136]) ? '/ '. $options[136] : ''); ?>

                                    <?php echo e(!empty($options[143]) ? '/'. $options[143] : ''); ?>

                                </div>
                                <div class="likepost">
                                    <a class="save-post <?php echo e($product->wishlist() ? 'saved-post' : ''); ?>" 
                                        data="<?php echo e($product->id); ?>" 
                                        data-bs-toggle="tooltip" 
                                        data-bs-placement="top" 
                                        title="<?php echo e($product->wishlist() ? 'Bỏ lưu tin' : 'Lưu tin'); ?>" 
                                        href="#">
                                        <?php if($product->wishlist()): ?>
                                            <img src="<?php echo e(asset($templateFile.'/img/liked.png')); ?>" />
                                        <?php else: ?>
                                            <img src="<?php echo e(asset($templateFile.'/img/like.png')); ?>" />
                                        <?php endif; ?>
                                    </a>
                                </div>
                            </div>
                            <div class="phone-contact">
                                <?php if($customer): ?>
                                <a href="<?php echo e(auth()->check()? 'tel:'. $customer->getPhone() :'javascript:;'); ?>">
                                    <img src="<?php echo e(asset($templateFile .'/img/phone-call.png')); ?>" />
                                    <span><?php echo e($customer->getPhone()); ?></span>
                                </a>
                                <?php endif; ?>
                                <?php if(!auth()->check()): ?>
                                <p>Đăng nhập để xem số điện thoại</p>
                                <?php endif; ?>
                            </div>
                            <div class="group-btn">
                                <a href="mailto:<?php echo e($customer->email); ?>" class="btn" data-bs-toggle="modal" data-bs-target="#getContactModal"><img src="<?php echo e(asset($templateFile.'/img/envelope.png')); ?>" /> Gửi email</a>
                                <a href="<?php echo e($customer->getUrl()); ?>" class="btn">Xem Hồ sơ người đăng</a>
                            </div>
                        </div>

                        <?php if ($__env->exists($templatePath .'.product.'. $category_main->slug .'.product_advance')) echo $__env->make($templatePath .'.product.'. $category_main->slug .'.product_advance', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        
                    </div>
                </div>

            </div>
        </div>
    </div>



    <?php echo $__env->make('shortcode.product', ['category_id' => $category->id??0, 'limit' => 50, 'title' => "Tin Liên Quan"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="container mb-5">
        <div class="row">
            <div class="col-lg-9">
                <?php if ($__env->exists($templatePath .'.product.search-hot-keyword')) echo $__env->make($templatePath .'.product.search-hot-keyword', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
    </div>  

    <?php echo $__env->make('shortcode.keyword', ['menu'=>"Keyword-hot"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('shortcode.contact', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    


<div class="modal fade" id="getContactModal" tabindex="-1" role="dialog" aria-labelledby="getContactModalLabel" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="getContactModalLabel">Thông tin liên hệ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="list-content-loading">
                    <div class="half-circle-spinner">
                        <div class="circle circle-1"></div>
                        <div class="circle circle-2"></div>
                    </div>
                </div>
                <form id="customer-register" class="form-contact" role="form" method="POST" action="<?php echo e(sc_route('contact.submit')); ?>">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="contact[url]" value="<?php echo e(url()->current()); ?>">
                    <input type="hidden" name="contact[product_title]" value="<?php echo e($product->name); ?>">
                    <div class="row mt-2 mb-5 align-items-center">
                        <div class="mb-3 col-sm-12">
                            <label for="name" class="control-label">Họ tên<span class="required">*</span></label>
                            <input id="name" type="text" class="form-control" placeholder="Họ tên" name="contact[name]" value="">
                        </div>
                        <div class="mb-3 col-sm-12">
                            <label for="phone" class="control-label">Số điện thoại<span class="required">*</span></label>
                            <input id="phone" type="text" class="form-control" placeholder="Số điện thoại" name="contact[phone]" value="">
                        </div>
                        <div class="mb-3 col-sm-12">
                            <label for="email" class="control-label">Email<span class="required">*</span></label>
                            <input id="email" type="email" class="form-control" placeholder="Email" name="contact[email]" value="">
                        </div>
                        <div class="mb-3 col-sm-12">
                            <label for="password" class="control-label">Lời nhắn<span class="required">*</span></label>
                            <textarea name="" class="form-control" rows="5"></textarea>
                        </div>
                        
                        <div class="mb-3 col-sm-12">
                            <div class="error-message"></div>
                        </div>
                        <div class="col-sm-12 text-center d-grid">
                            <button type="submit" class="btn btn-primary btn-register">Gửi yêu cầu</button>
                        </div>
                    
                </div></form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    jQuery(document).ready(function($) {
        $(document).on('click', '.btn-expand', function(){
            console.log('fdafd');
            $(this).closest('.view-main').addClass('isfull');
        });
        $(document).on('click', '.btn-compress', function(){
            console.log('fdaf232323232d');
            $(this).closest('.view-main').removeClass('isfull');
        });

        $(document).on('click', '.btn-view-file', function(){
            var src = $(this).attr('href');
            if(src)
                $('.view-main').find('iframe').attr('src', src);

            return false
        });
    });
</script>       
<?php $__env->stopPush(); ?>
<?php echo $__env->make($templatePath .'.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/long/Downloads/GTCPLATFORM-main/resources/views/theme/product/single.blade.php ENDPATH**/ ?>