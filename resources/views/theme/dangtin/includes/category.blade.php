@php
    $category_list = $modelCategory->getList(['parent' => 0 ] );
    $type = $type??'';
@endphp
@if($type == '' && $category_list->count())
    <div class="category">
        <div class="list-group categories">
            @include($templatePath .'.dangtin.includes.category', ['type' => 'child', 'categories' => $category_list])
        </div>
    </div>
@else
    <div class="category-child category-{{ $category_id??0 }}">
        
        @foreach($categories as $category_item)
            <div class="list-group-item list-group-item-action categoryItem" data="{{$category_item->id}}">
                @if($category_item->icon)
                    <img src="{{ $category_item->icon }}" width="28" height="28">
                @endif
                {{$category_item->name}} <i class="fa-solid fa-chevron-right"></i>
            </div>
            @if($category_item->children()->count())
                @php
                    $category_childs = $modelCategory->getList(['parent' => $category_item->id ] );
                @endphp
                @include($templatePath .'.dangtin.includes.category', [
                    'type' => 'child', 
                    'categories' => $category_childs, 
                    'category_id' => $category_item->id
                ])
            @endif
        @endforeach
    </div>
@endif

