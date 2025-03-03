@php
    $categories = $modelCategory->getList([
        'parent'    => 0,
        'limit' => 20
    ]);
    /*
    $show_category = $show_category??0;
    */

    $menus = Menu::getByName('Category-home');
@endphp
<div class="block-search">
    <div class="container">
        <div class="search-feature">
            <form action="{{ route('search') }}" class="form-inline form-search">
                <div class="input-search input-w-auto icon">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="search" name="keyword" class="form-control" placeholder="Tìm kiếm theo tiêu đề, từ khóa..." />
                </div>
                <div class="input-search">
                    <select name="category" class="select2">
                        <option value="">Chọn  danh mục</option>
                        @foreach($categories as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <input type="submit" value="TÌM KIẾM">
            </form>
        </div>
        @if($show_category != 1)
        <div class="list-cate-slider">
            <div class="archive-slider d-flex owl-carousel" style="opacity: 0">
                @foreach($menus as $item)
                @php
                    //$category = $modelCategory->getDetail($item['link'], 'slug');
                @endphp
                <div class="item-cate">
                    <a href="{{ url($item['link']??'#') }}">
                        <div class="thumb-cate">
                            <img src="{{ asset($item['icon']) }}" alt="{!! $item['label'] !!}" width="36" height="36">
                        </div>
                        <div class="content-cate">
                            <h3>{!! $item['label'] !!}</h3>
                            {{--<p>{{ $category->products()->where('status', 1)->count() }} tin</p>--}}
                            <p class="view">Xem tin <i class="fa-solid fa-arrow-right"></i></p>
                        </div>
                    </a>
                </div>
                @endforeach
                
            </div>
        </div>
        @endif
    </div>
</div>