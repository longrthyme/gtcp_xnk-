@extends($templatePath .'.layout')

@section('seo')
	@include($templatePath .'.layouts.seo', $seo??[])
@endsection

@section('content')
    <!-- Page Header Start -->
    <div class="single-breadcrumbs bg-light">
        <div class="container py-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/">{{ sc_language_render('front.home') }}</a></li>
                    @if(!empty($categories))
                        @foreach($categories as $index => $item)
                            @php
                                $item_category = $modelCategory->getDetail($item['id']);
                                if($index <2)
                                    $item_url = $item_category->getUrl($item_slug??'');
                            @endphp
                            <li class="breadcrumb-item"><a href="{{ $index <2? $item_url: $item_url.'?category='. $item['id'] }}">{{ $item_category->name }}</a></li>
                            @php
                                $item_slug = $item['slug'];
                            @endphp
                        @endforeach
                    @endif
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->
    <div class="block-single pb-5">
        <div class="container">
            <div class="row g-3">
                <div class="col-md-9">
                    
                    <div class="content-detail">
                        <h2>{{ $product->name }}</h2>
                        <div class="bottom-info">
                            <div class="item icon-clock">
                                <i class="fa-regular fa-clock"></i>
                                {{ date('H:i d/m/Y', strtotime($product->created_at)) }}
                            </div>
                            <!-- <div class="item icon-eye">
                                69,656 người xem
                            </div> -->
                            <div class="item">
                                @if(count($product->getAddressFull()))
                                <div class=""><i class="fa-solid fa-location-dot"></i> {{ implode(', ', $product->getAddressFull()) }}</div>
                                @endif
                            </div>
                        </div>


                        <div class="product-detail_description">
                            <h5 class="mb-0">Mô tả chi tiết</h5>
                            <div class="mb-3" style="white-space: pre-line;">
                                {!! htmlspecialchars_decode($product->content??'') !!}
                            </div>

                            <h5 class="mb-2">Thông tin chung</h5>
                            <div>
                                <table class="table table-striped">
                                    <tr>
                                        <td>Số lượng tuyển dụng:</td>
                                        <td>{{ $product->stock }}</td>
                                    </tr>
                                    <tr>
                                        <td>Mức lương dự kiến:</td>
                                        <td>{!! render_price($product->price) !!}</td>
                                    </tr>
                                    <tr>
                                        <td>Chế độ phúc lợi:</td>
                                        <td>{{ $options[65]??'' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Hạn nộp hồ sơ:</td>
                                        <td>{{ $product->getDateAvailable() }}</td>
                                    </tr>
                                    <tr>
                                        <td>Dự kiến phỏng vấn:</td>
                                        <td>{{ $options[63]??'' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Bắt đầu làm việc:</td>
                                        <td>{{ $options[64]??'' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        @includeIf($templatePath .'.product.search-hot-keyword')

                    </div>
                </div>

                <div class="col-md-3">
                    <div class="right-sidebar">
                        <div class="info-sidebar">
                            <div class="product-price">
                                <div class="price-single">
                                    <div>Mức lương dự kiến</div>
                                    {!! render_price($product->price) !!}
                                </div>
                                <div class="likepost">
                                    <a class="save-post {{ $product->wishlist() ? 'saved-post' : '' }}" 
                                        data="{{ $product->id }}" 
                                        data-bs-toggle="tooltip" 
                                        data-bs-placement="top" 
                                        title="{{ $product->wishlist() ? 'Bỏ lưu tin' : 'Lưu tin' }}" 
                                        href="#">
                                        @if($product->wishlist())
                                            <img src="{{ asset($templateFile.'/img/liked.png') }}" />
                                        @else
                                            <img src="{{ asset($templateFile.'/img/like.png') }}" />
                                        @endif
                                    </a>
                                </div>
                            </div>
                            <div class="phone-contact">
                                @if($customer)
                                <a href="{{ auth()->check()? 'tel:'. $customer->getPhone() :'javascript:;' }}">
                                    <img src="{{ asset($templateFile .'/img/phone-call.png') }}" />
                                    <span>{{ $customer->getPhone() }}</span>
                                </a>
                                @endif
                                @if(!auth()->check())
                                <p>Đăng nhập để xem só điện thoại</p>
                                @endif
                            </div>
                            <div class="group-btn">
                                <a href="mailto:{{ $customer->email }}" class="btn" data-bs-toggle="modal" data-bs-target="#getContactModal"><img src="{{ asset($templateFile.'/img/envelope.png') }}" /> Gửi email</a>
                                <a href="{{ $customer->getUrl() }}" class="btn">Xem Hồ sơ người đăng</a>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>



    @include('shortcode.product', ['category_id' => $category->id??0, 'col' => 4, 'limit' => 15, 'title' => "Tin Liên Quan"])

    @include('shortcode.keyword', ['menu'=>"Keyword-hot"])
    @include('shortcode.contact')


<div class="modal fade" id="getContactModal" tabindex="-1" role="dialog" aria-labelledby="getContactModalLabel" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="getContactModalLabel">Thông tin liên hệ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="list-content-loading">
                    <div class="half-circle-spinner">
                        <div class="circle circle-1"></div>
                        <div class="circle circle-2"></div>
                    </div>
                </div>
                <form id="customer-register" class="form-contact" role="form" method="POST" action="{{ sc_route('contact.submit') }}">
                    @csrf
                    <input type="hidden" name="contact[url]" value="{{ url()->current() }}">
                    <input type="hidden" name="contact[product_title]" value="{{ $product->name }}">
                    <div class="row mt-2 mb-5 align-items-center">
                        <div class="mb-3 col-sm-12">
                            <label for="name" class="control-label">Họ tên<span class="required">*</span></label>
                            <input id="name" type="text" class="form-control" placeholder="Họ tên" name="contact[name]" value="">
                        </div>
                        <div class="mb-3 col-sm-12">
                            <label for="phone" class="control-label">Số điện thoại<span class="required">*</span></label>
                            <input id="phone" type="text" class="form-control" placeholder="Số điện thoại" name="contact[phone]" value="">
                        </div>
                        <div class="mb-3 col-sm-12">
                            <label for="email" class="control-label">Email<span class="required">*</span></label>
                            <input id="email" type="email" class="form-control" placeholder="Email" name="contact[email]" value="">
                        </div>
                        <div class="mb-3 col-sm-12">
                            <label for="password" class="control-label">Lời nhắn<span class="required">*</span></label>
                            <textarea name="" class="form-control" rows="5"></textarea>
                        </div>
                        
                        <div class="mb-3 col-sm-12">
                            <div class="error-message"></div>
                        </div>
                        <div class="col-sm-12 text-center d-grid">
                            <button type="submit" class="btn btn-primary btn-register">Gửi yêu cầu</button>
                        </div>
                    
                </div></form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    jQuery(document).ready(function($) {
        $(document).on('click', '.btn-expand', function(){
            console.log('fdafd');
            $(this).closest('.view-main').addClass('isfull');
        });
        $(document).on('click', '.btn-compress', function(){
            console.log('fdaf232323232d');
            $(this).closest('.view-main').removeClass('isfull');
        });

        $(document).on('click', '.btn-view-file', function(){
            var src = $(this).attr('href');
            if(src)
                $('.view-main').find('iframe').attr('src', src);

            return false
        });
    });
</script>       
@endpush