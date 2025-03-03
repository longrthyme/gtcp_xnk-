@php
    $location = $product->getLocation(['address1', 'country']);
    $options = $product->getOptions();
@endphp
<div class="item-product">
    <a href="{{ $product->getUrl() }}">
        <div class="thumb-product">
            <img src="{{ asset($product->image) }}" onerror="if (this.src != '{{ asset($product->getAuth->avatar) }}') this.src = '{{ asset($product->getAuth->avatar) }}';" alt="{{ $product->name }}">
        </div>
        <div class="bottom-wrapper">
            <div class="content-product">
                <h3 class="mb-0">{{ $product->name }}</h3>
            </div>
            <div class="price">
                @if($product->price_max>0)
                    <div class="priice-main">{!! render_price($product->price) !!} - {!! render_price($product->price_max) !!}</div>
                @else
                    @if($location != '')
                    <div class="price-location">
                        Nơi thực hiện: 
                        <span title="{{ $product->country }}">{{ $location }}</span>
                    </div>
                    @endif
                    <div class="price-main">Giá: {!! render_price($product->price) !!} {{ !empty($options[143]) ? '/ '. $options[143] : '' }}</div>
                @endif
            </div>
        </div>
    </a>
</div>