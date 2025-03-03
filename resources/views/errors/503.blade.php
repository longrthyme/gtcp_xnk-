@extends('theme.layout.index')
@section('seo')
<title>{{ Helpers::get_option_minhnn('seo-title-add') }}</title>
<link rel="canonical" href="{{ url('/') }}" />
<meta name="robots" content="index, follow">
<meta name="description" content="{{ Helpers::get_option_minhnn('seo-description-add') }}">
<meta property="og:title" content="{{ Helpers::get_option_minhnn('og-title') }}" />
<meta property="og:description" content="{{ Helpers::get_option_minhnn('og-description') }}" />
<meta property="og:image" content="{{ url(Helpers::get_option_minhnn('og-image')) }}" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:site_name" content="{{ Helpers::get_option_minhnn('og-site-name') }}" />
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col text-center y-wrapper-60">
                <hr class="w-50 mx-auto mt-4">
                <h2>Under maintenance</h2>
                <p>Please come back latter</p>
                <div class="tbl_back clear">
                </div>
            </div>
        </div>
    </div>
@endsection
