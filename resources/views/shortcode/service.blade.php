@php
	$categories = (new \App\ProductCategory)->getList([]);
@endphp

<div class="block position-relative my-5 my-3">
    <div class="position-absolute top-0 bottom-0 start-0 end-0 h-100 bg_wblue z-n1"></div>
    <div class="container">
        <div class="row mt-4 g-3">
            @foreach($categories as $index => $category)
                <div class="col-6 col-md-4">
                    <a class="service-item" href="{{ route('product', $category->slug) }}">
                        <div class="icon">
                            <img src="{{ asset($category->icon) }}">
                        </div>
                        <div class="content">{{ $category->name }}</div>
                    </a>
                </div>
            @endforeach
            
        </div>
    </div>
</div>