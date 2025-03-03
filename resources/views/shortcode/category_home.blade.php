@php
	$menu = Menu::getByName($menu_slug);
    $languages = \App\Models\ShopLanguage::getListActive();
@endphp

<div class="block position-relative">
    <div class="position-absolute top-0 bottom-0 start-0 end-0 h-50 bg_wblue z-n1"></div>
    <div class="container">
        <div class="row g-4">
            <div class="col-12 text-center">
                <h3 class="title_block">{{ $title }}</h3>
                {!! htmlspecialchars_decode($subtitle) !!}
            </div>
        
            <div class="col-12">
                <!-- list -->
                <ul class="nav nav-tabs list_service" id="myTab" role="tablist">
                    @foreach($menu as $index => $item)
                        @php
                            $category = $modelCategory->getDetail($item['link'], 'slug')
                        @endphp
                    <li class="nav-item item" role="presentation">
                        <div class="{{ $index==0?'active':'' }}" id="tab-{{ $index }}" data-bs-toggle="tab" data-bs-target="#tab{{ $index }}" type="button" role="tab" aria-controls="tab{{ $index }}" aria-selected="true">
                            <div class="icon">
                                <img src="{{ asset($category->icon) }}">
                            </div>
                            <div class="content">{{ $category->name }}</div>
                        </div>

                    </li>
                    @endforeach
                </ul>
            </div>
        
            <!-- slide 2 row-->
            <div class="col-12 position-relative">
                <div class="tab-content" id="myTabContent">
                    @foreach($menu as $index => $item)
                        @php
                            $category = $modelCategory->getDetail($item['link'], 'slug');

                            $products = $modelProduct->setCategory($category->id)->getList([
                                'limit' => 6
                            ]);
                            
                        @endphp
                        <div class="tab-pane fade {{ $index==0?'show active':'' }}" id="tab{{ $index }}" role="tabpanel" aria-labelledby="tab-{{ $index }}">
                            <div class="swiper slide_2_row px-3">
                                <div class="swiper-wrapper">
                                    @foreach($products as $product)
                                    <div class="swiper-slide">
                                        @include($templatePath .'.product.product_item_2')
                                    </div>
                                    @endforeach
                                </div>
                                <div class="swiper-pagination"></div>
                            </div>
                            <div class="swiper-button-next slide_2_row_next"></div>
                            <div class="swiper-button-prev slide_2_row_prev"></div>

                            <div class="mt-4 text-center">
                                <a href="{{ route('product', $category->slug) }}" class="btn btn_primary rounded-pill fw-medium">{{ sc_language_render('front.all') }}</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
        </div>
    </div>
</div>