@extends($templatePath .'.layout')

@section('content')
<div id='contact-page' class="container my-lg-4 my-3">
    <div class="page-content">
        <div class="row">
            <div class="col-12 contact-page-info">
                <h1 class="page-title">{{ $page->title }}</h1>
                <div>
                    {!! htmlspecialchars_decode($page->content) !!}
                </div>
                
                <form method="POST" action="{{ route('contact.submit') }}" enctype="multipart/form-data">
                    @csrf
                    @include($templatePath .'.contact.contact_content')
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">{{ __('Send message') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection