<div class="shop-sidebar">
    <div class="menu-nav">
        <div class="pres-archive" data-bs-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="true" aria-controls="multiCollapseExample1">
            <div class="name-archive text-uppercase">Loại kho bãi</div>
            <i class="fa fa-angle-down"></i>
        </div>
        <div class="collapse multi-collapse show" id="multiCollapseExample1">
            <div class="item-check">
                <a href="{{ $category->getUrl() }}" class="item-radius" title="{{ $category->slug }}">Tất cả</a>
            </div>
            @foreach($categories as $item)
                @php
                    $menu_active = '';
                    if (url()->current() == $item->getUrl($category->slug??''))
                       $menu_active = ' active';
                @endphp
            <div class="item-check">
                <a href="{{ $item->getUrl($category->slug??'') }}" class="item-radius{{ $menu_active }}" title="{{ $category->slug }}">{{ $item->name }}</a>
            </div>
            @endforeach
        </div>
    </div>

    <div class="menu-nav">
        <div class="goods-origin" data-bs-toggle="collapse" href="#multiCollapseExample2" role="button" aria-expanded="true" aria-controls="multiCollapseExample2">
            <div class="name-origin text-uppercase">Diện tích </div>
            <i class="fa fa-angle-down"></i>
        </div>
        <div class="list-filter-item collapse multi-collapse show" id="multiCollapseExample2">
            <div class="item-check">
                <a href="javascript:;" data-name="acreage" class="item-radius filter-set {{ request('acreage') == 100 ? 'active' : '' }}" title="<100"><= 100 m2</a>
            </div>
            <div class="item-check">
                <a href="javascript:;" data-name="acreage" class="item-radius filter-set {{ request('acreage') == 100-200 ? 'active' : '' }}" title="100-200">100 - 200 m2</a>
            </div>
            <div class="item-check">
                <a href="javascript:;" data-name="acreage" class="item-radius filter-set {{ request('acreage') == 200-300 ? 'active' : '' }}" title="200-300">200 - 300 m2</a>
            </div>
            <div class="item-check">
                <a href="javascript:;" data-name="acreage" class="item-radius filter-set {{ request('acreage') == 300-400 ? 'active' : '' }}" title="300-400">300 - 400 m2</a>
            </div>
            <div class="item-check">
                <a href="javascript:;" data-name="acreage" class="item-radius filter-set {{ request('acreage') == 400-500 ? 'active' : '' }}" title="400-500">400 - 500 m2</a>
            </div>
            <div class="item-check">
                <a href="javascript:;" data-name="acreage" class="item-radius filter-set {{ request('acreage') == 500 ? 'active' : '' }}" title=">500">>= 500 m2</a>
            </div>
        </div>
    </div>

    @includeIf($templatePath .'.product.filter-option',['id' => 112, 'type' => 'price', 'title' => 'Khoảng giá'])

    {{--
    <div class="menu-nav">
        <div class="goods-origin" data-bs-toggle="collapse" href="#multiCollapseExample2" role="button" aria-expanded="true" aria-controls="multiCollapseExample2">
            <div class="name-origin text-uppercase">Khu vực </div>
            <i class="fa fa-angle-down"></i>
        </div>
        <div class="list-filter-item collapse multi-collapse show" id="multiCollapseExample2">
            @foreach($countries as $index => $item)
                @if($index<8)
                    <div class="item-check">
                        <a href="javascript:;" data-name="country" class="item-radius filter-set {{ request('country') == $item->name ? 'active' : '' }}">{{ $item->name_vi!= '' ? $item->name_vi :$item->name }}</a>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
    --}}
</div>