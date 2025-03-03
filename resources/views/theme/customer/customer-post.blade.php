@php
  $agent = new  Jenssegers\Agent\Agent();
@endphp

@extends($templatePath .'.layout')

@section('content')
<div class="page-archive py-5 wow fadeIn" data-wow-delay="0.1s">
      <div class="container text-center py-5">
          <h3 class="text-white animated slideInDown">Tin đăng của thành viên "{{ $user->fullname }}"</h3>
          <nav aria-label="breadcrumb animated slideInDown">
              <ol class="breadcrumb justify-content-center mb-0">
                  <li class="breadcrumb-item"><a class="text-white" href="/">Trang chủ</a></li>
              </ol>
          </nav>
      </div>
  </div>

<section class="py-5">
    <div class="container">
        <div> Hiện có {{ $products->count() }} tin đăng</div>
        <div class="row mt-3">
            <div class="col-lg-12">
                <div class="row">
                  @if(count($products)>0)
                      @foreach($products as $product)
                          <div class="col-lg-3 col-6">
                            @include($templatePath .'.product.product_item', compact('product'))
                          </div>
                      @endforeach
                  @endif
                </div>
            </div>
        </div>
    </div>
</section>

  @include('shortcode.keyword', ['menu'=>"Keyword-hot"])
  @include('shortcode.contact')
@endsection