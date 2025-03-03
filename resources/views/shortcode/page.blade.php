@php    
    $dataSearch = [
        'limit' => $limit??6
    ];

    $products = $modelProduct->getList($dataSearch);
    $page = $modelPage->getDetail($id);
@endphp
@if($style == 2)
    @include('shortcode.page-2')
@else
<section class="position-relative">
    <div class="position-absolute top-0 bottom-0 start-0 end-0 z-n1">
        <img src="{{ asset($page->cover) }}" alt="" class="w-100 h-100 ">
    </div>
    @if($slogan !='')
    <div class="p-3 text-center text-white bg-dark bg-opacity-25">{!! $slogan !!}</div>
    @endif
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-3">
                @include('auth.sidebar')
            </div>
            <div class="col-lg-9 mt-5 mt-lg-0">
                
                <h4 class="text-center text-white fw-bold">{{ $page->name }}</h4>
                
                <div class="text-center text-white">
                    {!! htmlspecialchars_decode($page->description) !!}
                </div>
                <!-- list card -->
                <div class="row mt-4">
                    @foreach($products as $product)
                    <div class="col-12 col-md-6 col-lg-4">
                        @include($templatePath .'.product.product_item')
                    </div>
                    @endforeach
                    
                </div>
                <!-- show more -->
                <div class="row mt-3">
                    <div class="col-12 text-center">
                        <a href="#" class="btn btn-light rounded-pill fw-semibold">Xem tất cả</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif