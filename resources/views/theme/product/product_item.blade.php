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
            </div>
            <div class="price">
                @if($product->price_max>0)
                    <div class="priice-main">{!! render_price($product->price) !!} - {!! render_price($product->price_max) !!}</div>
                @else
                    
                    @if(count($product->getAddressFull()))
                    <div class="price-location">Xuất xứ: {{ $product->getOrigin() }}</div>
                    @endif
                    @if($product->address_end)
                    <div class="price-location">Nơi bán: {{ $product->getPlaceSale() }}</div>
                    @endif
                    <div class="price-main">Giá EXW : {!! render_price($product->price) !!} {{ !empty($options[136]) ? '/ '. $options[136] : '' }}</div>
                @endif
            </div>
        </div>
    </a>
</div>