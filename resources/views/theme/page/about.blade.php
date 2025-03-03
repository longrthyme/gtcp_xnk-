@php extract($data) @endphp
@extends($templatePath .'.layouts.index')

@section('seo')
@endsection

@section('content')
<div id="about-banner-1" class="banner">
    
    <div class="bg-fill">
        <div class="bg-img w-100">
            @if($page->cover!='')
            <img class="w-100" src="{{ asset($page->cover) }}">
            @else
            <img class="w-100" src="{{ asset('assets/images/about-banner-1.png') }}">
            @endif
        </div>
        <div class="bg-overlay"></div>
    </div>
    <div class="banner-content h-100">
        <div class="container h-100">
            <div class="row h-100">
                <div class="offset-xl-3 col-xl-6 h-100">
                    <div class="box-text">
                        <h1 class="banner-title text-white fw-bold">{{ $page->title }}</h1>
                        <div class="banner-desc text-white mt-3">
                            {!! htmlspecialchars_decode($page->description) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="about-content" class="container">
    {!! htmlspecialchars_decode($page->content) !!}
</div>
@endsection
