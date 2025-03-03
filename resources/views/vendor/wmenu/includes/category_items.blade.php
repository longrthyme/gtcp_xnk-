<?php 
    $char_first = $char_first??'';
    $parent_id = $parent_id ?? 0;

    $dategories = $modelCategory->getList([
        'parent'    => $parent_id
    ]);
?>
@if(count($dategories)>0)
    @foreach($dategories as $category)
        <label for="page_{{ $category->id }}" class="form-group">
            <input type="checkbox" class="category_item_input" value="{{ $category->id }}" id="page_{{ $category->id }}" >
            {{ $char_first }}{{ $category->name }}

            <input type="hidden" class="item-name-{{ $category->id }}" value="{{ $category->name }}">
            <input type="hidden" class="item-url-{{ $category->id }}" value="{{ $category->slug }}">
        </label>
        @if(count($category->children)>0)
            @include('vendor.wmenu.includes.category_items', ['parent_id'=> $category->id, 'char_first' => $char_first.'--'])
        @endif
    @endforeach
@endif