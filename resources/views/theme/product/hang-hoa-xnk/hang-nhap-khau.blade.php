@php
    if(empty($products))
    {
        $category_id = $category_sub->id??$category->id;
        $products = $modelProduct->setCategory($category_id)->getList([
            'post_type' => 'buy'
        ]);
    }
@endphp
<div class="row g-3">
    @foreach($products as $product)
    <div class="col-6 col-md-3">
        @if(!empty($templatePath_category) && \View::exists($templatePath_category . '.product_item'))
            @include($templatePath_category . '.product_item')
        @else
            @include($templatePath .'.product.product_item')
        @endif
    </div>
    @endforeach
</div>
{!! $products->links() !!}