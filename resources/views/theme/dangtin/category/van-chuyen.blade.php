@php
    $price = $product->price??'';
    $cost = $product->cost??0;
    $price_max = $product->price_max??'';

    if($price)
    {
        $price_format = number_format($price);
        $tongcuoc = number_format($price + $cost);
    }
    if($cost)
        $cost_format = number_format($cost);
        
    $start_title = 'Nơi';
    $start_title_1 = 'Cảng';

    if( in_array($category->id, [42, 46, 48]) )
        $start_title = 'Cảng';
    elseif( in_array($category->id, [43, 49]) )
        $start_title = 'Ga';

    if( in_array($category->id, [51, 52, 53]) )
        $start_title_1 = 'Ga';

    $category_slug = $category->slug;

@endphp

<div class="text-center author_type mb-3">
    <div class="radio-group">
        @if($user->type != 2)
        <div>
            <input type="radio" name="post_type" class="post_type" id="btncheck_ban" value="sell" {{ $post_type == 'sell' ? 'checked' : '' }}>
            <label for="btncheck_ban">Chào giá</label>
        </div>
        @endif
        <div>
            <input type="radio" name="post_type" class="post_type" id="btncheck_mua" value="buy" {{ $post_type == 'buy' ? 'checked' : '' }}>
            <label for="btncheck_mua">Yêu cầu chào giá</label>
        </div>
    </div>
</div>

<div class="form-content {{ request('post_type') != '' ? '' : 'd-none' }}">
    @include($templatePath . '.dangtin.category.van-chuyen.'. $category->slug .'-'. ($post_type != ''? $post_type : 'sell'))
</div>