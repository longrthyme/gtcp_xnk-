<?php 
    $tags = \App\Model\ThemeInfo::where('taginfo', '<>', '')->get();
    $data_tags = null;
    foreach ($tags as $key => $tag) {
        $taginfo = explode(',', $tag->taginfo);
        foreach($taginfo as $item){
            $data_tags[] = $item;
        }
    }
    // dd($data_tags);
?>
@if($data_tags)
    @foreach($data_tags as $index => $tag)
        <label for="tags_{{ $index }}" class="form-group">
            <input type="checkbox" class="category_item_input" value="{{ $index }}" id="category_{{ $index }}" >
            {{ $tag }}

            <input type="hidden" class="item-name-{{ $index }}" value="{{ $tag }}">
            <input type="hidden" class="item-url-{{ $index }}" value="{{ $tag }}">
        </label>
    @endforeach
@endif