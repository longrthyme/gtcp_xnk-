@php
    $states = \App\Models\LocationProvince::get();
    $countries = \App\Models\LocationCountry::get();
@endphp

@extends($templatePath .'.layouts.index')

@section('seo')
    @include($templatePath .'.layouts.seo', $seo??[] )
@endsection


@section('content')
    <div class="page-archive py-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center py-5">
            <h3 class="text-white animated slideInDown">Thành viên</h3>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a class="text-white" href="/">Trang chủ</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">Thành viên</li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="my-post">
        <div class="container my-lg-4 my-3">
            <div class="row">
                <div class="col-lg-3  col-12 mb-4">
                    @include($templatePath .'.customer.includes.sidebar-customer')
                </div>
                <div class="col-lg-9">
                    <div class="sc-notice">
                        @if(Session::has('message') || Session::has('status'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            
                            {!! Session::get('message') !!}
                            {!! Session::get('status') !!}
                        </div>
                        @endif

                        @if(Session::has('success'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            
                            {!! Session::get('success') !!}
                        </div>
                        @endif

                        @if(Session::has('error'))
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            
                            {!! Session::get('error') !!}
                        </div>
                        @endif

                        @if(Session::has('warning'))
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            
                            {!! Session::get('warning') !!}
                        </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection