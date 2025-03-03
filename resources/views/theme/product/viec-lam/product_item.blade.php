@php
    $location = $product->getLocation(['address1', 'country']);
    $author = $product->getAuth;
@endphp
<div class="item-product vieclam-item">
    <a href="{{ $product->getUrl() }}">
        <div class="thumb-product">
            <div class="img">
                <img class="lazyload" data-src="{{ asset($product->image) }}" src="{{ asset('assets/images/no-image.jpg') }}" onerror="if (this.src != '{{ asset($product->getAuth->avatar??'') }}') this.src = '{{ asset($product->getAuth->avatar??'') }}';" alt="{{ $product->name }}">
            </div>
        </div>
        <div class="bottom-wrapper">
            <div class="content-product">
                <h3 class="mb-0" title="{{ $product->name }}">{{ $product->name }}</h3>
                <div><b>{{ $author->company }}</b></div>
            </div>
            <div class="price">
                @if($product->price_max>0)
                    <div class="priice-main">{!! render_price($product->price) !!} - {!! render_price($product->price_max) !!}</div>
                @else
                    @if(count($product->getAddressFull()))
                    <div class="price-location"><span title="{{ $location }}">{{ $location }}</span></div>
                    @endif
                    <div class="price-main">Mức lương : {!! render_price($product->price) !!}</div>
                @endif
            </div>
        </div>
    </a>
</div>