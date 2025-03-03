@extends($templatePath .'.layout')

@section('seo')
   @include($templatePath .'.layouts.seo', $seo??[] )
@endsection

@section('content')
   <div class="page-archive py-5">
        <div class="container text-center py-5">
            <h3 class="text-white">Nâng cấp tài khoản</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a class="text-white" href="/">Trang chủ</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">Nâng cấp tài khoản</li>
                </ol>
            </nav>
        </div>
    </div>

<section class="package-page">
   <div class="container">
      @include($templatePath .'.package.package-list')
   </div>
</section>

@endsection

@push('after-footer')
@endpush