@php
    $option = \App\Models\ShopOption::find(104);
    $options = $option->posts;

    $options_ = $options->toArray();

    if(!empty($category_sub))
    {
    
        $options_ = array_map(function($k) use($category_sub) {
            $unit_decode = json_decode($k['unit'])??[];
            if(is_array($unit_decode) && in_array($category_sub->id, $unit_decode))
                return $k;
        }, $options->toArray());
        $options_ = array_filter($options_);
    }


@endphp
<div class="block-search">
    <div class="search-feature">
        <form action="{{ $url_action_filter }}" class="form-inline form-search" id="form-search">
            <div class="input-search">
                <select class="form-control select2" name="transportation">
                    <option value="">Phương thức vận chuyển</option>
                    @if(count($options_))
                        @foreach($options_ as $item)
                            <option value="{{ $item['name'] }}" {{ request('transportation') == $item['name'] ? 'selected' : '' }}>{{ $item['name'] }}</option>
                        @endforeach
                    @endif
                </select>
            </div>

            <div class="input-search">
                <select class="form-control seaport" name="location_origin">
                    <option value="">Nhập nơi đi</option>
                </select>
            </div>
            <div class="input-search">
                <select class="form-control seaport" name="destination">
                    <option value="">Nhập nơi đến</option>
                </select>
            </div>
            <input type="submit" value="TÌM KIẾM" class="productSearch-btn">
            <input type="hidden" name="category_parent" value="{{ $category_sub->id??$category->id }}">
            <input type="hidden" name="url_current" value="{{ url()->current() }}">
            <input type="hidden" name="type_get" value="ajax">
        </form>
    </div>
</div>