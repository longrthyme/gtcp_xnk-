@php
    $options = $product->getOptions();
@endphp
<div class="item-product">
    <a href="{{ $product->getUrl() }}">
        <div class="thumb-product">
            <img class="lazyload" data-src="{{ asset($product->image) }}" src="{{ asset('assets/images/no-image.jpg') }}" onerror="if (this.src != '{{ asset($product->getAuth->avatar??'') }}') this.src = '{{ asset($product->getAuth->avatar??'') }}';" alt="{{ $product->name }}">
        </div>
        <div class="bottom-wrapper">
            <div class="price">
                @if(!empty($options[202]))
                    <div>Loại xe: {{ $options[202]??'' }}</div>
                    <div>Trọng tải: {{ $options[206]??'' }}{{ $options[136]??'' }}</div>
                    <div class="price-main">Giá vận chuyển: {!! render_price($product->price) !!}</div>
                    <div class="price-main">Giá xe chờ: {!! render_price($options[213]??0) !!}</div>
                @else
                    @if(!empty($options[126]))
                    <div class="price-location">Tuyến vận chuyển chính: <span title="{{ $options[126] }}">{{ $options[126] }}</span></div>
                    @endif
                    <div>
                        {{ $product->getAddressFull()?current($product->getAddressFull()):'' }} - {{ $product->getAddressEnd()?current($product->getAddressEnd()):'' }}
                    </div>
                    @if(!empty($options[35]))
                    <div>
                        Khởi hành: {{ $options[35] }}
                    </div>
                    @endif
                    <div class="price-main">Giá vận chuyển : {!! render_price($product->price) !!}{{ !empty($options[159]) ? '/'. $options[159] : '' }}</div>
                @endif
            </div>
        </div>
    </a>
</div>