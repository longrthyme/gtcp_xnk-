@php
    $slider = $modelSlider->getDetail($id);
    $sliders = $modelSlider->getList([
    'sort_order'    => 'order__asc',
        'parent'    => $id
    ]); 
@endphp
@if(count($sliders)>0)

<div class="block-partner pb-5">
    <div class="container position-relative">
        <div class="section-title">
            <h4>{{ $slider->name }}</h4>
            <!-- <a href="#">Xem tất cả <i class="fa-solid fa-arrow-right"></i></a> -->
        </div>
        <div class="swiper partner-slider">
            <div class="swiper-wrapper">
                @foreach($sliders as $item)
                <div class="swiper-slide">
                    <div class="thumb-partner">
                        <img src="{{ asset($item->src) }}" alt="" />
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="swiper-pagination"></div>
    </div>
</div>
@endif