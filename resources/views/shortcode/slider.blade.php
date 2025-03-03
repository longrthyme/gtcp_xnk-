@php extract($data) @endphp

@php 
    $sliders = $modelSlider->getList([
        'parent'    => $id
    ]); 
@endphp
@if(count($sliders)>0)
<div class="container-fluid p-0 wow fadeIn mb-3" data-wow-delay="0.1s">
    <div class="owl-carousel header-carousel">
        @foreach($sliders as $item)
        <div class="owl-carousel-item position-relative">
            <img class="img-fluid" src="{{ asset($item->src) }}" alt="{{ $item->name }}" />
            @if($item->description)
            <div class="owl-carousel-inner">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            {!! htmlspecialchars_decode($item->description) !!}
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
        @endforeach
    </div>
</div>
@endif