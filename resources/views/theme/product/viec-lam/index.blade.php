@php
    if(empty($products))
    {
        $category_id = $category_sub->id??$category->id;
        
        $products = $modelProduct->setCategory($category_id)->getList([
            'post_type' => $post_type
        ]);
    }
@endphp
<div class="row g-3">
    @foreach($products as $product)
    <div class="col-lg-4 col-md-6">
        @include($category_folder . '.product_item')
    </div>
    @endforeach
</div>
@if($products instanceof \Illuminate\Pagination\AbstractPaginator)
{!! $products->links() !!}
@endif