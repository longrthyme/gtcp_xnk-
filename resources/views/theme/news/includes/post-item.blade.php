@php
   $url = $post->getUrl();
   $date = \Carbon\Carbon::parse($post->created_at);
@endphp
<div class="box-news">
        <div class="thumb-product">
            <a href="{{ $url }}">
                <img src="{{ asset($post->image) }}" onerror="this.src='{{ asset('assets/images/placeholder.png') }}';">
            </a>
        </div>
        <div class="bottom-wrapper">
            <div class="content-product">
                <h3><a href="{{ $url }}">{{ $post->name }}</a></h3>
                <p class="fs-14 text_gray">{{ $date->format('Y-m-d') }}</p>
                <div class="des des-3">
                    {!! htmlspecialchars_decode($post->description) !!}
                </div>
            </div>
        </div>
</div>
