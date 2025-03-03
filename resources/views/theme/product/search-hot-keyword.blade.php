@php
    $menu = Menu::getByName('Hot-search')                          ;
@endphp
<div class="search-keyword">
    <h5>Từ khoá tìm kiếm</h5>
    <ul>
        @foreach($menu as $item)
        <li><a href="{{ route('search', ['keyword' => $item['link']]) }}" class="{{ $item['class'] }}">{{ $item['label'] }}</a></li>
        @endforeach
    </ul>
</div>