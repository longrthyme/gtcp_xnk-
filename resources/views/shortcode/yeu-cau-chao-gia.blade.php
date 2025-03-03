@php
    $post_type = 'buy';

    $category = $modelCategory->getDetail(18);

    $categories = $modelCategory->getList(['parent' => $category->id]);
    $category_folder = $templatePath .'.product.'. $category->slug;
@endphp
@if(!empty($categories))
    @foreach($categories as $category_item)
        @php
            $products = $modelProduct->setCategory($category_item->id)->getList([
                'post_type' => $post_type??'sell',
                'transportation' => $transportation??0
            ]);

            $view = ($category_folder??'').'.product-list';
            if(!empty($category_folder) && \View::exists($category_folder.'.'. $category_item->slug ."-$post_type"))
            {
                $view = $category_folder.'.'. $category_item->slug ."-$post_type";
            }
            
        @endphp
        @if($products->count())
        <div class="container mb-3">
            <h4>Yêu cầu chào giá {{ $category_item->name }}</h4>
            @include($view)
        </div>
        @endif
    @endforeach
@else
    @php
        $view = $templatePath.'.product.product_list';
        if(!empty($category_path) && \View::exists($category_path . '.'. $category_sub->slug))
            $view = $category_path . '.'. $category_sub->slug;
    @endphp
    @include($view)
@endif
