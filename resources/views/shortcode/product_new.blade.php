@php
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

@endphp
@if(!empty($category) && $category->count() && $products->count())
<div class="block-product py-4">
    <div class="container">
        
        <div class="section-title">
            <h4>{{ !empty($title) && $title!='' ? $title : $category->name??'' }}</h4>
            <div class="d-flex align-items-center ms-md-3">
                <i class="fa-solid fa-arrow-right-long"></i>
                <a href="/dang-tin" class="btn btn-custom ms-md-3">Đăng tin ngay!</a>
            </div>
            <a class="view-more" href="{{ $url }}">Xem tất cả <i class="fa-solid fa-arrow-right"></i></a>
        </div>
        @if(!empty($templattePath_view) && \View::exists($templattePath_view))
            <div class="row g-3">
                @foreach($products as $product)
                <div class="col-6 col-md-3 col-20">
                    @include($templattePath_view)
                </div>
                @endforeach
            </div>
            
        @else
            @includeIf($templatePath_2, compact('products', 'category_folder'))
        @endif
    </div>
</div>
@endif