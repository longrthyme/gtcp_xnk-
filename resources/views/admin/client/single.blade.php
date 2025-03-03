@extends('admin.layouts.index')
@php
    if(isset($post)){
        extract($post->toArray());
        $description = $post->description ? $post->description->keyBy('lang')->toArray(): [];
    }
@endphp

@section('seo')
    @include('admin.layouts.seo')
@endsection

@section('content')
<h6 class="fw-bold py-3 mb-0"><span class="text-muted fw-light">Dashboard /</span> {{ $title }}</h6>
<form action="{{ $url_post }}" method="POST" id="frm-create-page" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{$id??0}}">
    <div class="row">
        <div class="col-lg-9">
            <!-- show error form -->
            <div class="errorTxt"></div>
            
            <div class="nav-align-top mb-4">
                @include('admin.partials.tab-lang-head')

                @include('admin.partials.tab-content', [
                    'description_show'  => true
                ])
            </div>
            
        </div> <!-- /.col-9 -->
        <div class="col-lg-3">
            @include('admin.partials.action_button')

            @include('admin.partials.post_category')

            

            @include('admin.partials.image', ['title'=>'Hình ảnh', 'id'=>'img', 'name'=>'image', 'image'=>$image??''])
            @include('admin.partials.image', ['title'=>'Hình ảnh Banner', 'id'=>'cover-img', 'name'=>'cover', 'image'=>$cover??''])
        </div> <!-- /.col-9 -->
    </div> <!-- /.row -->
</form>

@endsection

@push('scripts')
<script type="text/javascript">
    @foreach($languages as $code => $lang)
        editorQuote('description_{{ $code }}');
        editor('content_{{ $code }}');
    @endforeach
</script>
@endpush