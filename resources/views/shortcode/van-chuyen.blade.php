@php
    $category_child = $modelCategory->getList(['parent' => 18]);
    $category = $modelCategory->getDetail(18);
@endphp

<div class="block-service">
    <div class="container">
        <div class="freight-services">
            @foreach($category_child as $item)
                @php
                    $products = $modelProduct->setCategory($item->id)->getList([
                        'product_home' => true,
                        'post_type' => 'sell',
                        'limit' => 10,
                        'user_id' => $author??0,
                    ]);

                    $slug = $category->slug??'';
                    $slug_sub = $item->slug??'';

                    $templateCategory_path = $templatePath .".product.". $slug .".product-list";
                    $templateCategorySub_path = $templatePath .".product.$slug.$slug_sub"; // goi blade view danh muc sub


                    $templattePath_view = '';
                    if (View::exists($templateCategorySub_path))
                        $templattePath_view = $templateCategorySub_path;
                    elseif (View::exists($templateCategory_path))
                        $templattePath_view = $templateCategory_path;

                @endphp
                @if($products->count())
                    <div class="title-freight">
                        <h4>Vận chuyển {{ $item->name }}</h4>
                    </div>
                    @includeIf($templattePath_view)
                @endif
            @endforeach
            {{--
            <div class="group-searchs">
                <div class="row g-4">
                    <div class="col-md-6 text-md-end">
                        <a href="#" class="btn">TÌM KIẾM CÔNG TY VẬN CHUYỂN  >></a>
                    </div>
                    <div class="col-md-6">
                        <a href="#" class="btn">TÌM KIẾM DỊCH VỤ KHÁC >></a>
                    </div>
                </div>
            </div>
            --}}
        </div>
        
    </div>
</div>