@php extract($data) @endphp

@php 
    $sliders = $modelSlider->getList([
        'parent'    => $slider_id
    ]); 
@endphp
@if(count($sliders)>0)
<div class="container mt-1">
    <div class="banner-carousel-loading">
    	<div class="owl-carousel banner-carousel" data='{"item":4, "tablet":4, "mobile":2}'>
            @foreach($sliders as $item)
            <a href="{{ url($item->link??'#') }}" class="owl-carousel-item position-relative">
                <img class="img-fluid" src="{{ asset($item->src) }}" alt="{{ $item->name }}" width="250" height="80" />
            </a>
            @endforeach
        </div>
    </div>

	<div class="row align-item-center">
		<div class="col-lg-12 py-3 my-3 text-center slogan-top">
			{!! setting_option('slogan-top') !!}
		</div>
	</div>
</div>
@endif