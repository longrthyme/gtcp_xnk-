@php
    $transportation = 'Đường bộ';
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
    <div class="d-flex flex-column">
    @foreach($categories as $category_item)
        @php
            $transportation = 'Đường bộ';
            if($category_item->id == 58)
                $transportation = '';

            $products = $modelProduct->setCategory($category_item->id)->getList([
                    'transportation' => $transportation??0
                ]);

            $view = ($category_folder??'').'.product-list';
            if(!empty($category_folder) && \View::exists($category_folder.'.'. $category_item->slug))
            {
                $view = $category_folder.'.'. $category_item->slug;
            }
        @endphp
        @if($products->count())
        <div class="mb-3" style="{{ $category_item->id == 58 ? 'order: 0' : 'order: 1'  }}">
            <h4>{{ $category_item->name }}</h4>
            @include($view)
        </div>
        @endif
    @endforeach
    </div>
@else
    @php
        $view = $templatePath.'.product.product_list';
        if(!empty($category_path) && \View::exists($category_path . '.'. $category_sub->slug))
            $view = $category_path . '.'. $category_sub->slug;
    @endphp
    @include($view)
@endif
