@php
    $limit = $limit??'';
    $post_type = $post_type??'';
    if($post_type != '')
        $post_type = explode(',', $post_type);
    $products = $modelProduct;

    $url = sc_route('shop');
    $templattePath_view = $templatePath .'.product.product_item';
    $templatePath_2 = '';
    if(!empty($category_id))
    {
        $category = $modelCategory->getDetail($category_id);
        if($category)
        {
            $category_parent = $category->getParentFirst($category);

            if($category->slug != $category_parent->slug)
                $url = $category->getUrl($category_parent->slug??'');
            else
                $url = $category->getUrl();
            $products = $products->setCategory($category_id);

            if(\View::exists($templatePath .'.product.'. $category_parent->slug .'.product_item'))
                $templattePath_view = $templatePath .'.product.'. $category_parent->slug .'.product_item';

            $templatePath_2 = $templatePath .".product.". $category->slug .".product-list";
            $category_folder = $templatePath .'.product.'. $category_parent->slug;
        }

        if($category_id == 7)
          $templattePath_view = '';
    }


    $products = $products->getList([
        'post_type' => 'sell',
        'user_id' => $author??0,
        'product_home' => $product_home??true,
        'limit' => $limit
    ]);
    $col_set = '';
    if(empty($col))
    {
        $col_set = 'col-20';
    }  

@endphp
<!-- @if($products->count())
<div class="block-product py-4">
    <div class="container">
        
        <div class="section-title">
            <h4 class="text-uppercase">{{ !empty($title) && $title!='' ? $title : $category->name??'' }}</h4>
            <div class="d-flex align-items-center ms-md-3">
                <i class="fa-solid fa-arrow-right-long"></i>
                <a href="/dang-tin" class="btn btn-custom ms-md-3">Đăng tin ngay!</a>
            </div>
            <a class="view-more" href="{{ $url }}">Xem tất cả <i class="fa-solid fa-arrow-right"></i></a>
        </div>
        @if(\View::exists($templattePath_view))
            <div class="row g-3">
                @foreach($products as $product)
                <div class="col-6 col-md-3 {{ $col_set }}">
                    @include($templattePath_view)
                </div>
                @endforeach
            </div>
            
        @else
            @includeIf($templatePath_2, compact('products', 'category_folder'))
        @endif
    </div>
</div>
@endif -->

@if($products->count())
<div class="block-product py-4">
    <div class="container">
        <div class="section-title">
            <h4 class="text-uppercase">
                {{ !empty($title) && $title != '' ? $title : $category->name ?? '' }}
            </h4>
            <div class="d-flex align-items-center ms-md-3">
                <i class="fa-solid fa-arrow-right-long"></i>
                <a href="/dang-tin" class="btn btn-custom ms-md-3">Đăng tin ngay!</a>
            </div>
            <a class="view-more" href="{{ $url }}">Xem tất cả <i class="fa-solid fa-arrow-right"></i></a>
        </div>

        @if(\View::exists($templattePath_view))
            <div class="list-cate-slider">
                <div class="archive-slider d-flex owl-carousel" style="opacity: 0">
                @if(\View::exists($templattePath_view))

            @foreach($products as $product)
                <div class="ms-2">
                    @include($templattePath_view)
                </div>
                @endforeach
            
            @endif
            
        @else
            @includeIf($templatePath_2, compact('products', 'category_folder'))
        @endif
    </div>
</div>
@endif
