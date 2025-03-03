@if(!empty($languages) && count($languages)>1)
@php 
    $i=0; 
    $type = $type??'';
@endphp

<ul class="nav nav-tabs" id="tabLang" role="tablist">
    @foreach($languages as $code => $lang)
    <li class="nav-item">
        <a class="nav-link {{ $i++ == 0 ? 'active' : '' }}" id="{{ $type.$code }}-tab" data-bs-toggle="tab" href="#{{ $type.$code }}" role="tab" aria-controls="{{ $type.$code }}" aria-selected="false">{{ $lang->name }}</a>
    </li>
    @endforeach
</ul>
@endif