@extends('admin.layouts.index')
@php
    if(!empty($product))
    {
        extract($product->toArray());
        $description = $product->descriptions ? $product->descriptions->keyBy('lang')->toArray(): [];
        $gallery = (isset($gallery) || $gallery != "") ? unserialize($gallery) : '';
    }
@endphp

@section('seo')
    @include('admin.layouts.seo')
@endsection

@section('content')
<h6 class="fw-bold py-3 mb-0"><span class="text-muted fw-light">Dashboard /</span> {{ $title }}</h6>
<div class="card">
    <div class="card-body" id="pjax-container">

        <div class="row">
            <div class="col-lg-9">
                @php

                    $category_parents = $modelCategory->getParentList($category->parent);
                    
                    if($category_parents)
                    {
                        $category_parents = array_reverse($category_parents);
                        $category_first = current($category_parents);
                    }
                    else
                    {
                        $category_first = $category;   
                    }
                    $content = $content??'';

                    
                    $post_type = request('post_type')??$product->post_type??'';

                    $catalogues = $product->getCatalogue()->where('type', 'catelogue')->get();
                    $certificates = $product->getCatalogue()->where('type', 'certificate')->get();

                    if(!empty($product))
                    {
                        $address = implodeAddress($product->getAddressFull()??'');
                        $address_end = $product->address_end;
                        
                        $product_options = $product->getOptions($json_decode_text=false);
                        if($product->date_available)
                        $date_available = date('d/m/Y', strtotime($product->date_available));
                    }
                @endphp

                <div class="form-group optionItem">
                    <div class="input-boder active" data-bs-toggle="modal" data-bs-target="#changeCategory">
                        <label>Danh mục tin đăng:</label>
                        <div class="category-breadcrumb">
                            <ul class="category_session" >
                                @if($category_parents && count($category_parents))
                                    @foreach($category_parents as $item)
                                        <li>{{ $item->name??'' }}</li>
                                    @endforeach
                                @endif
                                <li>{{ $category->name }}</li>
                            </ul>
                        </div>
                    </div>
                </div>

                @if($category_first)
                    @php
                        $templatePath_1 = $templatePath .'.dangtin.category.' . $category_first->slug . '.' . $category->slug;
                        $templatePath_2 = $templatePath .'.dangtin.category.' . $category_first->slug;

                    @endphp

                    @if(\View::exists($templatePath_1))
                        @include($templatePath_1)
                    @elseif(\View::exists($templatePath_2))

                        @include($templatePath_2)
                    @endif
                @endif
        
            </div> <!-- /.col-9 -->
            <div class="col-lg-3">
                @php
                    $status = $status ?? 1;
                    $created_at = $created_at??date('Y-m-d H:i');
                    $created_at = date('Y-m-d H:i', strtotime($created_at));
                @endphp
                <div class="card">
                    <div class="card-body">
                        <form action="{{ $url_post }}" method="POST" id="form_post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{$id??0}}">
                            <h5 class="card-title">Publish</h5>

                            <div class="form-group mb-3">
                                <label>Ngày đăng:</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                    <input type='text' class="form-control" name="created_at" id='created_at' value="{{ $created_at }}" />
                                </div>
                            </div>
                            <div class="form-group d-flex justify-content-end text-end mb-3">
                                <div class="form-check me-3">
                                    <input type="radio" id="radioDraft" name="status" class="form-check-input" value="0" {{ $status == 0 ? 'checked' : ''  }}>
                                    <label class="form-check-label" for="radioDraft"> Ẩn tin </label>
                                </div>
                                <div class="form-check me-3">
                                    <input type="radio" id="radioPublic" name="status" class="form-check-input" value="1" {{ $status == 1 ? 'checked' : ''  }}>
                                    <label class="form-check-label" for="radioPublic"> Hiện tin </label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" id="radio_reject" name="status" class="form-check-input" value="3" {{ $status == 3 ? 'checked' : ''  }}>
                                    <label class="form-check-label" for="radio_reject"> Từ chối </label>
                                </div>
                            </div>

                            @if($comments->count())
                            <div class="mb-3 bg-light">
                                <ul class="timeline">
                                    @foreach($comments as $item)
                                    <li class="timeline-item timeline-item-transparent">
                                        <span class="timeline-point-wrapper"><span class="timeline-point timeline-point-primary"></span></span>
                                        <div class="timeline-event">
                                            <div class="timeline-header mb-1">
                                                <h6 class="mb-0">{{ $item->getAdmin->name??'' }}</h6>
                                                <small class="text-muted">{{ $item->created_at }}</small>
                                            </div>
                                            <div>
                                                {!! $item->content !!}
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            <div class="mb-3">
                                <h5 class="mb-2">Lý do:</h5>
                                <textarea name="note" class="form-control w-100" rows="3"></textarea>
                                
                            </div>
                            <div class="text-center">
                                <button type="submit" name="submit" value="reject" class="btn btn-danger">Từ chối duyệt</button>
                            </div>

                            <hr>
                            @if(!empty($languages))
                            @foreach($languages as $code => $lang)

                                <div class="form-group">
                                    <label for="seo_title_{{ $code }}">Seo Title  ({{ $code }})</label>
                                    <input type="text" id="seo_title_{{ $code }}" name="description[{{ $code }}][seo_title]" class="form-control" value="{!! $description[$code]['seo_title'] ?? '' !!}">
                                </div>

                                <div class="form-group">
                                    <label for="seo_keyword_{{ $code }}">Seo Keyword  ({{ $code }})</label>
                                    <input type="text" id="seo_keyword_{{ $code }}" name="description[{{ $code }}][seo_keyword]" class="form-control" value="{!! $description[$code]['seo_keyword'] ?? '' !!}">
                                </div>

                                <div class="form-group">
                                    <label for="seo_description_{{ $code }}">Seo Description  ({{ $code }})</label>
                                    <textarea id="seo_description_{{ $code }}" name="description[{{ $code }}][seo_description]" class="form-control">{!! $description[$code]['seo_description'] ?? '' !!}</textarea>
                                </div>
                            @endforeach
                            @endif
                            <hr>



                            <div class="form-group text-end">
                                <button type="submit" name="submit" value="save" class="btn btn-info">Lưu</button>
                                <button type="submit" name="submit" value="apply" class="btn btn-success">Lưu và sửa</button>
                            </div>
                        </form>
                    </div> <!-- /.card-body -->
                </div><!-- /.card -->


                @include('admin.partials.image', ['title'=>'Hình ảnh', 'id'=>'img', 'name'=>'image', 'image'=>$image??''])
                @include('admin.partials.galleries', ['gallery_images'=> $gallery ?? ''])
                @include('admin.partials.image', ['title'=>'Hình ảnh Banner', 'id'=>'cover-img', 'name'=>'cover', 'image'=>$cover??''])
            </div> <!-- /.col-9 -->
        </div> <!-- /.row -->

        <div class="list-content-loading">
            <div class="half-circle-spinner">
                 <div class="circle circle-1"></div>
                 <div class="circle circle-2"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset($templateFile .'/css/dangtin.css?ver='. time()) }}">
@endpush
@push('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="{{ asset($templateFile .'/js/dangtin.js?ver='. time()) }}" type="text/javascript"></script>
<script type="text/javascript">
    $('.form-content ').removeClass('d-none');
    @foreach($languages as $code => $lang)
        // editorQuote('description_{{ $code }}');
        // editor('content_{{ $code }}');
    @endforeach

    $(':button[type=submit]').click(function(){
        var button_value = $(this).val();
        if(button_value == 'reject')
        {
            if (!$.trim($('textarea[name="note"]').val())) {
                alert('Nhập lý do từ chối duyệt tin');
                $('textarea[name="note"]').focus();
                return false;   
            }
        }
        $('.list-content-loading').show();
        $('form#form_post').submit();
    });

</script>
@endpush