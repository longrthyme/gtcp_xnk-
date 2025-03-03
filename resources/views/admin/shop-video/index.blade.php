@extends('admin.layouts.index')
@section('seo')
    <title>{{ $title }}</title>
@endsection
@section('content')

@php
    if(isset($post)){
        extract($post->toArray());
        $description = $post->description ? $post->description->keyBy('lang')->toArray(): [];
    }
    $id = $id??0;
@endphp

<h6 class="fw-bold py-3 mb-0"><span class="text-muted fw-light">Dashboard /</span> {{ $title }}</h6>

<div class="row g-4">
    <div class="col-lg-6">
        <form action="{{ $url_post }}" method="POST" id="frm-create-post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{$id?? 0}}">
            <input type="hidden" name="product_id" value="{{ $product->id ?? 0 }}">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <h5>Thêm/Sửa</h5>
                        <a href="{{ route('admin_product') }}" class="btn btn-outline-primary">Về danh sách khóa học</a>
                        <a href="{{ route('admin_video', ['product_id' => $product->id]) }}" class="btn btn-outline-primary">Về danh sách</a>
                    </div>

                    @include('admin.partials.tab-lang-head')

                    @if(!empty($languages))
                    @php
                        $i=0;
                    @endphp
                    <div class="tab-content px-0">
                        @foreach($languages as $code => $lang)
                        <div class="tab-pane fade {{ $i == 0 ? 'show active' : '' }}" id="{{ $code }}" role="tabpanel" aria-labelledby="{{ $code }}-tab">
                            <div class="mb-3">
                                <label for="name_{{ $code }}">Tiêu đề ({{ $code }})</label>
                                <input type="text" class="form-control title_slugify" id="name_{{ $code }}" name="description[{{ $code }}][name]" placeholder="Tiêu đề" value="{{ $description[$code]['name'] ?? '' }}">
                            </div>

                            <div class="">
                                <label for="duration_{{ $code }}" class="form-label">Thời lượng - ({{ $code }})</label>
                                <input class="form-control" type="text" id="duration_{{ $code }}" name="description[{{ $code }}][duration]" value="{{ $description[$code]['duration'] ?? '' }}">
                            </div>
                        </div>

                        
                        @php $i++; @endphp
                        @endforeach
                    </div>
                    @endif

                    <hr>

                    <div class="mb-3">
                        <label for="duration" class="form-label">Video cha</label>
                        <select name="parent_id" class="form-select">
                            <option value="0">Chọn video cha</option>
                            @foreach($video_parents as $video_parent)
                            @if($video_parent->id != $id)
                            <option value="{{ $video_parent->id }}" {{ !empty($parent_id) && $parent_id == $video_parent->id?'selected': '' }}>{{ $video_parent->name }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="formFile" class="form-label">Upload Video (zip file)</label>
                        <input class="form-control" type="file" id="formFile" name="file_zip">
                    </div>
                    <div class="mb-3">
                        <label for="file_url" class="form-label">Video Url</label>
                        <input class="form-control" type="text" id="file_url" name="file_url" value="{{ $file??'' }}">
                    </div>
                    @if(!empty($file))
                    <div class="mb-3">
                        <a href="{{ url($file) }}" target="_blank"><i class="fas fa-play"></i> Xem video</a>
                    </div>
                    @endif



                </div>
            </div>
            <div class="row">
                <div class="col-lg-5">
                    @include('admin.partials.image', ['title'=>'Hình ảnh', 'id'=>'img', 'name'=>'image', 'image'=>$image??''])
                </div>
                <div class="col-lg-7">
                    @include('admin.partials.action_button')
                </div>
            </div>
        </form>
    </div>
    <div class="col-6">
        <div class="card">
            <div class="card-body" id="pjax-container">
                {!! $posts->links() !!}
                <div class="table-responsive">
                    <table class="table table-bordered" id="table_index">
                        <thead>
                            <tr>
                                <th class="text-center"><input type="checkbox" id="selectall" onclick="select_all()"></th>
                                <th class="text-center">Title</th>
                                <th class="text-center">Thumbnail</th>
                                <th class="text-center">Date</th>
                                <th class="text-center"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($posts as $item)
                                @include('admin.shop-video.video-item', ['post' => $item])
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {!! $posts->links() !!}
            </div>
        </div>
        
    </div>
</div>
@endsection

@push('scripts')

    <script src="{{ sc_file('assets/plugins/jquery.pjax.js')}}"></script>

    @include('admin.component.script_remove_list')

@endpush