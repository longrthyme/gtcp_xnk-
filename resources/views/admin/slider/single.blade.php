@extends('admin.layouts.index')
<?php
    if(isset($post)){
        extract($post->toArray());
        $description = $post->description ? $post->description->keyBy('lang')->toArray(): [];
    }

    $id = $id??0;
?>
@section('seo')
@include('admin.layouts.seo')
@endsection
@section('content')
    <h6 class="fw-bold py-3 mb-0"><span class="text-muted fw-light">Dashboard /</span> {{ $title }}</h6>

    <form action="{{ $url_action }}" method="POST" id="frm-slider" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ $id??0 }}">
        <div class="row">
          	<div class="col-9">
            	<div class="card">
    	          	<div class="card-body">
                        <h5>{{$title}}</h5>
                        @if($id)
                        <p>Shortcode: <span style="background: #f1f1f1; display: inline-block; padding: 3px">[slider id="{{ $id }}" items="4"]</span></p>
                        @endif
                        <!-- show error form -->
                        <div class="errorTxt"></div>
                        @include('admin.partials.tab-lang-head')

                        @php
                            $i=0;
                        @endphp
                        @if(!empty($languages))
                        <div class="tab-content px-0">
                            @foreach($languages as $code => $lang)
                            <div class="tab-pane fade {{ $i==0 ? 'show active':'' }}" id="{{ $code }}" role="tabpanel" aria-labelledby="{{ $code }}-tab">
                                <div class="form-group">
                                    <label for="name_{{ $code }}">Tiêu đề ({{ $code }})</label>
                                    <input type="text" class="form-control title_slugify" id="name_{{ $code }}" name="description[{{ $code }}][name]" placeholder="Tiêu đề" value="{{ $description[$code]['name'] ?? '' }}">
                                </div>                                 
                            </div>
                            @php
                            $i++;
                            @endphp
                            @endforeach
                        </div>
                        @endif

                        <div class="form-group">
                            <h4 class="border-bottom mt-4 mb-2">Slider item</h4>
                            @if($id==0)
                                <p style="color: #f00;">Vui lòng bấm cập nhật để thêm Slider con</p>
                            @else
                            <div class="row g-3">
                                <div class="text-end">
                                    <button type="button" class="btn btn-info edit-slider" data="0" data-parent="{{ $id }}">Thêm slider con</button>
                                </div>
                                <div class="col-lg-12 slider-items mt-3">
                                    <div class="form-group row border py-2">
                                        <div class="col-md-3">Hình ảnh</div>
                                        <div class="col-md-3">Tên</div>
                                        <div class="col-md-3">Link</div>
                                        <div class="col-md-3">Action</div>
                                    </div>
                                </div>
                                <div class="col-lg-12 slider-list" id="slider_list">
                                    @include('admin.slider.includes.slider-items', ['sliders'=>$sliders??[]])    
                                </div>
                            </div>
                            @endif
                        </div>
    	        	</div> <!-- /.card-body -->
          		</div><!-- /.card -->
        	</div> <!-- /.col-9 -->
            <div class="col-3">
                @include('admin.partials.action_button')
            </div> <!-- /.col-9 -->
      	</div> <!-- /.row -->
    </form>

<div class="content-html">

</div>
<!-- Modal -->
<div class="modal fade" id="sliderModal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Thêm Slider</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <div class="errorTxtModal col-lg-12" style="color: #f00;"></div>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-info post-slider">Save changes</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('assets/plugins/Sortable.js') }}" type="text/javascript"></script>
<script type="text/javascript">

    new Sortable(slider_list, {
        handle: '.icon_change_postion', // handle's class
        swap: true, // Enable swap plugin
            swapClass: 'highlight', // The class applied to the hovered swap item
        animation: 150,
        onUpdate: function (/**Event*/evt) {
            var form = document.getElementById('frm-slider');
            var fdnew = new FormData(form);
            axios({
                method: 'POST',
                url: '/admin/slider/sort',
                data: fdnew,
            }).then(res => {
                
            }).catch(e => console.log(e));
        }
    });

    jQuery(document).ready(function ($){
        /*$(".slider-list").sortable({
            update: function(event, ui) {
                console.log('fdfd');
                var form = document.getElementById('frm-slider');
                var fdnew = new FormData(form);
                axios({
                    method: 'POST',
                    url: 'admin/slider/sort',
                    data: fdnew,
                }).then(res => {
                    
                }).catch(e => console.log(e));
            }            
        });*/

    });
</script>
@endpush