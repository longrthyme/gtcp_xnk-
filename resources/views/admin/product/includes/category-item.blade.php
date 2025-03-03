<ul id="muti_menu_post" class="muti_menu_right_category">
    @foreach($categories as $category)
    @php
        $checked = '';
        if(in_array($category->id, $array_checked))
            $checked = 'checked';
    @endphp
    <li class="category_menu_list">
        <label for="checkbox_cmc_{{ $category->id }}">
            <input type="checkbox" class="category_item_input" name="category_item[]" value="{{ $category->id }}" id="checkbox_cmc_{{ $category->id }}" {{ $checked }}>
            <span>{{ $category->name }}</span>
        </label>

        @if($category->children->count())
            @include('admin.product.includes.category-item', ['categories' => $category->children])
        @endif
    </li>
    @endforeach
</ul>