@php
    $post_type = 'buy';
    if(empty($products))
    {
        $category_id = $category_sub->id??$category->id;
        
        $products = $modelProduct->setCategory($category_id)->getList([
            'post_type' => $post_type??''
        ]);
    }
    $category_folder = $category_folder??'';
    
@endphp
@if(empty($category_sub) && !empty($categories))
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
        <div class="mb-3">
            <h4>{{ $category_item->name }}</h4>
            @include($view)
        </div>
    @endforeach
@else
    @php
        $view = $templatePath.'.product.product_list';
        if(!empty($category_path) && \View::exists($category_path . '.'. $category_sub->slug))
            $view = $category_path . '.'. $category_sub->slug;
    @endphp
    @include($view)
@endif
