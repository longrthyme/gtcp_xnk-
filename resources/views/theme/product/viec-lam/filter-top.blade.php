<div class="block-search">
    <div class="search-feature">
        <form action="{{ $url_action_filter }}" class="form-inline form-search" id="form-search">
            <input type="hidden" name="url_current" value="{{ url()->current() }}">
            <input type="hidden" name="type_get" value="ajax">
            <input type="hidden" name="category_parent" value="{{ $category_first->id }}">
            <div class="input-search icon">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="search" name="keyword" class="form-control" value="{{ request('keyword') }}" placeholder="Nhập vị trí tuyển dụng" />
            </div>

            <div class="input-search">
                <select class="form-control seaport" name="location_origin">
                    <option value="">Nhập nơi làm việc</option>
                </select>
            </div>

            <div class="input-search icon">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="search" name="price" class="form-control number_format" value="{{ request('price') }}" placeholder="Nhập mức lương" />
            </div>

            <input type="submit" value="TÌM KIẾM" class="productSearch-btn">
        </form>
    </div>
</div>