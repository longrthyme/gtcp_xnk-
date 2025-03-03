@php
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
                'transportation' => $transportation??''
            ]);


            $view = ($category_folder??'').'.product-list';
            if(!empty($category_folder) && \View::exists($category_folder.'.'. $category_item->slug))
            {
                //dd($category_folder.'.'. $category_item->slug);
                $view = $category_folder.'.'. $category_item->slug;
            }
        @endphp
        <div class="mb-3">
            <h4>{{ $category_item->name }}</h4>
            @include($view)
        </div>
    @endforeach
@else
    @php
        $view = $templatePath.'.product.'. $category->slug .'.product-list';
        if(!empty($category_path) && \View::exists($category_path . '.'. $category_sub->slug))
            $view = $category_path . '.'. $category_sub->slug;

        //dd($view);
    @endphp
    @include($view)
@endif
