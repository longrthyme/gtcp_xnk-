@extends($templatePath .'.layout')

@section('seo')
@include($templatePath .'.layouts.seo', $seo??[] )
@endsection


@section('content')
<section class="container-fluid py-5 product-detail">
  <div class="container">
    <!--=================================
    breadcrumb -->

    <nav class="mb-4" aria-label="breadcrumb animated slideInDown">
        <ol class="breadcrumb breadcrumb-style mb-0">
            <li class="breadcrumb-item"><a href="/">@lang('Trang chủ')</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $news->name }}</li>
        </ol>
    </nav>
    <!--=================================
    breadcrumb -->

    <div class="row">
      <div class="col-lg-8">
        <div class="blog-detail">
          
            <div class="blog-post-title mb-3">
              <h2>{{ $news->name }}</h2>
            </div>

            <div class="py-3 entry-meta d-flex align-items-center flex-wrap justify-content-between">
              <div>
                <span><i class="far fa-clock"></i> {{ date('d-m-Y', strtotime($news->created_at)) }}</span>
              </div>
              @include($templatePath .'.layouts.share-box', ['text' => $news->name])
            </div>

            <div class="blog-post-content border-0">
              {!! htmlspecialchars_decode($news->content) !!}
            </div>
            <hr>
            
        </div>

        <h5 class="text-primary mt-4">{{ sc_language_render('news.related') }}</h5>
        <ul>
          @if($post_lastests->count())
            @foreach($post_lastests as $item)
            <li>
              <a class="text-dark" href="{{ $item->getUrl() }}">{{ $item->name }}</a>
            </li>
            @endforeach
          @endif
        </ul>
      </div>
      <div class="col-lg-4 mt-5 mt-lg-0">
        <div class="blog-sidebar">
          <div class="widget">
            <div class="widget-title">
              <h6>Bài mới nhất</h6>
            </div>
              @if($news_featured->count())
                  @foreach($news_featured as $item)
                  <div class="row mb-3">
                      <div class="col-md-3">
                        <img class="img-fluid" src="{{ asset($item->image) }}" alt="">
                      </div>
                      <div class="col-md-9">
                        <a class="text-dark" href="{{ $item->getUrl() }}"><b>{{ $item->name }} </b></a>
                        <div class="blog-meta mt-2">
                          <span><i class="far fa-clock"></i> {{ date('d-m-Y', strtotime($item->created_at)) }}</span>
                        </div>
                      </div>
                  </div>
                  @endforeach
              @endif
          </div>
        </div>
      </div>
  </div>
</section>

@endsection
