@extends('admin.layouts.index')
<?php
if(isset($post)){
    extract($post->toArray());

    $description = $post->descriptions ? $post->descriptions->keyBy('lang')->toArray(): [];
}
    $id = $id??0;
    $parent = $parent??0;
?>

@section('seo')
    @include('admin.layouts.seo')
@endsection
@section('content')
    <h6 class="fw-bold py-3 mb-0"><span class="text-muted fw-light">Dashboard /</span> {{ $title }}</h6>

    <form action="{{ $url_post }}" method="POST" id="frm-create-category" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ $id }}">
	    <div class="row">
	      	<div class="col-9">
                <div class="nav-align-top mb-4">
                    @include('admin.partials.tab-lang-head')

                    @include('admin.partials.tab-content', [
                        'post_url'  => $post_url??''
                    ])
                </div>

	    	</div> <!-- /.col-9 -->
            <div class="col-3">
                @include('admin.partials.action_button')

                <div class="card">
                    <div class="card-body">
                        <h5>Chọn thể loại Cha</h5>
                        <select class="form-control select2" name="category_parent">
                            <option value="0">== Không có ==</option>
                            @foreach($categories as $category_id => $category_name)
                            <option value="{{ $category_id }}" {{ $category_id == $parent?'selected': '' }}>{{ $category_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                @include('admin.partials.image', ['title'=>'Icon', 'id'=>'img_icon', 'name'=>'icon', 'image'=>$icon??''])
                @include('admin.partials.image', ['title'=>'Hình ảnh', 'id'=>'img', 'name'=>'image', 'image'=>$image??''])

            </div> <!-- /.col-9 -->
	  	</div> <!-- /.row -->
    </form>

@endsection

@push('scripts')
<script type="text/javascript">
    jQuery(document).ready(function ($){
        
        @foreach($languages as $code => $lang)
            if($('#description_{{ $code }}').length)
                editorQuote('description_{{ $code }}');
            if($('#content_{{ $code }}').length)
                editor('content_{{ $code }}');
        @endforeach

    });
</script>
@endpush