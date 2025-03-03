@extends('admin.layouts.index')
@php
    if(isset($post)){
        extract($post->toArray());
        $description = $post->descriptions ? $post->descriptions->keyBy('lang')->toArray(): [];
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
        <div class="col-9">
            <!-- show error form -->
            <div class="errorTxt"></div>
            
            <div class="nav-align-top mb-4">
                @include('admin.partials.tab-lang-head')

                @include('admin.partials.tab-content')
            </div>
            
        </div> <!-- /.col-9 -->
        <div class="col-3">
            @include('admin.partials.action_button')

            <div class="card">
                <div class="card-body">
                    <h5>Thể loại Cha</h5>
                    <?php
                        $parent = $parent ?? 0;
                        $list_cate = (new \App\Admin\Models\AdminXNKCategory)->getTreeCategoriesAdmin();
                    ?>
                    <select class="form-control select2" name="category_parent">
                        <option value="0">== Không có ==</option>
                        @foreach($list_cate as $cate_id => $cate_name)
                            <option value="{{ $cate_id }}" {{ $parent == $cate_id ? 'selected' : '' }}>{{ $cate_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            @include('admin.partials.image', ['title'=>'Hình ảnh', 'id'=>'img', 'name'=>'image', 'image'=>$image??''])
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