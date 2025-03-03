<div class="block-search">
    <div class="search-feature">
        <form action="{{ $url_action_filter }}" class="form-inline form-search" id="form-search">
            <input type="hidden" name="url_current" value="{{ url()->current() }}">
            <input type="hidden" name="post_type" value="{{ $post_type }}">
            <input type="hidden" name="type_get" value="ajax">
            <input type="hidden" name="category_parent" value="{{ $category_id }}">
            <div class="input-search input-w-auto icon">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="search" name="keyword" class="form-control" value="{{ request('keyword') }}" placeholder="Tìm kiếm theo tiêu đề, từ khóa..." />
            </div>
            <div class="input-search input-search-small">
                <select name="country" class="select2">
                    <option value="">Xuất xứ hàng hóa</option>
                    @foreach($countries as $item)
                        <option value="{{ $item->name }}" {{ request('country') == $item->name ? 'selected' : ''  }}>{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="input-search input-search-small">
                <select name="place_sale" class="select2">
                    <option value="">Nơi bán</option>
                    @foreach($countries as $item)
                        <option value="{{ $item->name }}" {{ request('place_sale') == $item->name ? 'selected' : ''  }}>{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <input type="submit" value="TÌM KIẾM" class="productSearch-btn">
        </form>
    </div>
</div>