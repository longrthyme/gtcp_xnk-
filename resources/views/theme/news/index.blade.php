@extends($templatePath .'.layout')

@section('seo')
@include($templatePath .'.layouts.seo', $seo??[] )
@endsection

@section('content')
    {{--
    <div class="page-archive py-5">
        <div class="container text-center py-5">
            <h3 class="text-white  ">{{ $seo_title }}</h3>
            <nav aria-label="breadcrumb  ">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a class="text-white" href="/">Trang chủ</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">{{ $category->name }}</li>
                </ol>
            </nav>
        </div>
    </div>
    --}}

    <div class="container text-center">
        {!! htmlspecialchars_decode($category->content) !!}
    </div>

    @includeIf($templatePath .'.news.tabs')

     <div class="container">
       <div class="row g-3">
           @if(count($news)>0)
               @foreach($news as $index => $post)
               <div class="col-lg-6">
                   @include($templatePath .'.news.includes.post-item', compact('post'))
               </div>
               @endforeach
           @endif
           {!! $news->links() !!}
       </div>
     </div>
@endsection