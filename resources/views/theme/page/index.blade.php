@extends($templatePath.'.layout')

@section('seo')
@endsection

@section('content')
    <div class="page-archive py-5">
        <div class="container text-center py-5">
            <h3 class="text-white">{{ $seo_title }}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a class="text-white" href="/">Trang chủ</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">{{ $page->name }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container my-lg-4 my-3">

        <div class='page-content'>
            <div class="page-wrapper">
                <div class="row">
                    <div class="col-12 mx-auto">
                        {!! htmlspecialchars_decode($page->content) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('shortcode.keyword', ['menu'=>"Keyword-hot"])
    @include('shortcode.contact')
@endsection