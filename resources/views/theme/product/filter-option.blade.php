@php
    $option = \App\Models\ShopOption::find($id);
    $options = $option->posts;
@endphp

<div class="menu-nav">
    <div class="goods-origin" data-bs-toggle="collapse" href="#multiCollapseExample2" role="button" aria-expanded="true" aria-controls="multiCollapseExample2">
        <div class="name-origin text-uppercase">{{ $title??$option->name }} </div>
        <i class="fa fa-angle-down"></i>
    </div>
    <div class="list-filter-item collapse multi-collapse show" id="multiCollapseExample2">
        @foreach($options as $index => $item)
            <div class="item-check">
                <a href="javascript:;" data-name="{{ $type??'option' }}" title="{{ $item->unit }}" class="item-radius filter-set {{ request('option') == $item->name ? 'active' : '' }}">{{ $item->name }}</a>
            </div>
        @endforeach
    </div>
</div>