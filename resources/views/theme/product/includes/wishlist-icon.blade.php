<a class="save-post {{ $type != 'remove' ? 'saved-post' : '' }}" 
    data="{{ $id ?? '' }}" 
    data-bs-toggle="tooltip" 
    data-bs-placement="top" 
    title="{{ $type == 'remove' ? 'Lưu tin' : 'Bỏ lưu tin' }}" 
    href="#">
    @if($type == 'remove')
        <img src="{{ asset($templateFile.'/img/like.png') }}" />
    @else
        <img src="{{ asset($templateFile.'/img/liked.png') }}" />
    @endif
</a>
