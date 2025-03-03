<?php 
    $pages = (new \App\Admin\Models\AdminPage)->getListAdmin([]);
?>
@if(count($pages)>0)
    @foreach($pages as $page)
        <label for="category_{{ $page->id }}" class="form-group">
            <input type="checkbox" class="category_item_input" value="{{ $page->id }}" id="category_{{ $page->id }}" >
            {{ $page->name }}

            <input type="hidden" class="item-name-{{ $page->id }}" value="{{ $page->name }}">
            <input type="hidden" class="item-url-{{ $page->id }}" value="/{{ $page->slug }}.html">
        </label>
    @endforeach
@endif