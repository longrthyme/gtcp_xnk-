@extends($templatePath .'.layout')

@section('seo')
@include($templatePath .'.layouts.seo', $seo??[] )
@endsection

@section('content')
    <div class="page-archive py-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center py-5">
            <h3 class="text-white animated slideInDown">{{ $seo_title }}</h3>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a class="text-white" href="/">Trang chủ</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">{{ $seo_title }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="block-archive pt-5">
        <div class="container">
            <h3>Tìm kiếm với từ khóa "{{ request('keyword') }}"</h3>
        
            <div class="tab-content wow fadeIn" data-wow-delay="0.1s">
                <div class="tab-pane fade show active" id="tab-1" role="tabpanel" aria-bs-labelledby="pills-new-tab">
                    <!-- Product Start -->
                    <div class="block-product py-5">
                        <div class="row g-3">
                            @foreach($products as $product)
                            <div class="col-6 col-md-4 col-lg-3">
                                @include($templatePath .'.product.product_item')    
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- Product End -->
                </div>
            </div>
        </div>
    </div>

    @include('shortcode.keyword', ['menu'=>"Keyword-hot"])
    @include('shortcode.contact')

@endsection