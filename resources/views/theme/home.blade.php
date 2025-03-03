@extends($templatePath .'.layout')

@section('seo')
@endsection

@section('content')
	{!! htmlspecialchars_decode($page->content) !!}

	@include($templatePath .'.layouts.popup')
@endsection

@push('scripts')
@endpush