@php
    $options = $product->getOptions();
@endphp
<div class="item-product">
    <a href="{{ $product->getUrl() }}">
        <div class="thumb-product">
             <img class="lazyload" data-src="{{ asset($product->image) }}" src="{{ asset('assets/images/no-image.jpg') }}" onerror="if (this.src != '{{ asset($product->getAuth->avatar??'') }}') this.src = '{{ asset($product->getAuth->avatar??'') }}';" alt="{{ $product->name }}">
        </div>
        <div class="bottom-wrapper">
            <div class="content-product">
                <h3 class="mb-0">{{ $product->name }}</h3>
                {{--<!-- <p>93 m² - 6 PN</p> -->--}}
            </div>
            <div class="price">
                @if($product->price_max>0)
                    <div class="priice-main">{!! render_price($product->price) !!} - {!! render_price($product->price_max) !!}</div>
                @else
                    {{--
                    @if(count($product->getAddressFull()))
                    <div class="price-location">Vị trí: {{ $product->getOrigin() }}</div>
                    @endif
                    @if($product->address_end)
                    <div class="price-location">Nơi bán: {{ $product->getPlaceSale() }}</div>
                    @endif
                    --}}
                    @if(!empty($options[189]))
                    <div class="price-location">Loại thiết bị: {{ $options[189]??'' }}</div>
                    @endif
                    <div class="price-location">Trọng tải: {{ $options[60]??'' }}</div>
                    <div class="price-main">Giá cho thuê: {!! render_price($product->price) !!}{{ !empty($options[143]) ? '/'. $options[143] : '' }}</div>
                @endif
            </div>
        </div>
    </a>
</div>