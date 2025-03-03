@php
	$seo_image = $seo_image??setting_option('og-image');
	if($seo_image!='')
		$seo_image = asset($seo_image);

	$index = $index??'index, follow';
@endphp
<title>{!! $seo_title ?? setting_option('seo-title-add') !!}</title>
<link rel="canonical" href="{{ url()->current() }}" />

<meta name="robots" content="{{ $index }}">

<meta name="description" content="{!! $seo_description ?? strip_tags(setting_option('seo-description-add')) !!}">
<meta name="keywords" content="{{ $seo_keyword??'' }}">
<meta property="og:title" content="{!! $seo_title ?? setting_option('og-title') !!}" />
<meta property="og:description" content="{{ $seo_description ?? strip_tags(setting_option('og-description')) }}" />
<meta property="og:image" content="{{ $seo_image }}" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:site_name" content="{{ setting_option('og-site-name') }}" />