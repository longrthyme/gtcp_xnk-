<div class="card_box card_rounded p-2">
    <div class="thumbnail">
        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
    </div>
    <div class="content">
        <div class="py-2 fw-medium text_blue">
            <i class="fa-regular fa-clock"></i>
            <span class="ms-1 fs-14">1h30phút</span>
        </div>
        <div class="title py-2">{{ $product->name }}</div>
        <div class="more_infor">
            <div>
                <select class="selectpicker cart_select_language">
                	@foreach($languages as $code => $lang)
                    <option value="{{ $code }}">{{ sc_language_render('lang.'.$code) }}</option>
                    @endforeach
                </select>
            </div>
            <a href="{{ route('product', $product->slug) }}" class="btn btn_orange fw-bold rounded-pill">{{ sc_language_render('product.join') }}</a>
        </div>
    </div>
</div>