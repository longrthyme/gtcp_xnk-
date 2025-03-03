@extends('admin.layouts.index')
<?php
    if(isset($package))
        extract($package->toArray());
    $id = $id??0;
?>
@section('seo')
    @include('admin.layouts.seo')
@endsection
@section('content')

<h6 class="fw-bold py-3 mb-0"><span class="text-muted fw-light">Dashboard /</span> {{ $title }}</h6>


<form action="{{route('admin.package.post')}}" method="POST" id="frm-create-page" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{ $id ?? 0 }}">
    <div class="row">
      	<div class="col-9">
        	<div class="card">
	          	<div class="card-body">
                    <!-- show error form -->
                    <div class="errorTxt"></div>

                    <div class="form-group">
                        <label for="post_title">Tiêu đề</label>
                        <input type="text" class="form-control title_slugify" id="post_title" name="name" placeholder="Tiêu đề" value="{{ $name ?? '' }}">
                    </div>

                    <div class="form-group">
                        <label for="code">Mã gói tin</label>
                        <input type="text" class="form-control" id="code" name="code" value="{{ $code ?? '' }}">
                    </div>

                    <div class="row g-3">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="price">Giá</label>
                                <input type="text" class="form-control" id="price" name="price" value="{{ $price ?? 0 }}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="promotion">Khuyến mãi</label>
                                <input type="text" class="form-control" id="promotion" name="promotion" value="{{ $promotion ?? 0 }}">
                            </div>
                        </div>
                    
                    
                        {{--
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="max_day">Ngày sử dụng</label>
                                    <input type="text" class="form-control" id="max_day" name="max_day" value="{{ $max_day ?? 0 }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="download">Số lượt tải tài liệu</label>
                                    <input type="text" class="form-control" id="download" name="download" value="{{ $download ?? 0 }}">
                                </div>
                            </div>
                        </div>
                        --}}

                        <div class="col-lg-12">
                            <label for="sort">Sắp xếp tăng dần</label>
                            <input type="number" class="form-control" id="sort" name="sort" value="{{ $sort ?? 0 }}">
                        </div>

                        <div class="form-group col-lg-6">
                            <!-- <label for="view">Lượt xem</label> -->
                            <input type="hidden" class="form-control" id="view" name="view" value="1">
                        </div>
                        <!-- <div class="form-group col-lg-6">
                            <label for="max_day">Max day</label>
                            <input type="number" class="form-control" id="max_day" name="max_day" value="{{ $max_day ?? 0 }}">
                        </div> -->
                    </div>

	        	</div> <!-- /.card-body -->
      		</div><!-- /.card -->

            <!-- Switches -->
            <div class="card mb-4">
                <h5 class="card-header">Giá gói:</h5>
                <div class="card-body">
                    <div class="d-flex w-100">
                        <span class="px-2" style="min-width: 90px">Tên</span>
                        <span class="px-2" style="flex: 1;">Giá</span>
                        <span class="px-2" style="flex: 1;">Giá khuyến mãi</span>
                    </div>
                    @foreach($packagedays as $item)
                        @php
                            $price_item = $price_day->where('day_id', $item->id)->first();
                        @endphp
                        <div class="input-group mt-2">
                            <span class="input-group-text" style="min-width: 90px">{{ $item->name }}</span>
                            <input type="number" class="form-control" placeholder="Giá" name="package_price[{{ $item->id }}][price]" value="{{ $price_item->price??0 }}">
                            <input type="number" class="form-control" placeholder="Giá khuyến mãi" name="package_price[{{ $item->id }}][promotion]" value="{{ $price_item->promotion??0 }}">
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Switches -->
            <div class="card mb-4">
                <h5 class="card-header">Quyền lợi thành viên:</h5>
                <div class="card-body">
                    @foreach($options as $item)
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="option_{{ $item->id }}" name="option[]" value="{{ $item->id }}" {{ in_array($item->id, $package_options) ? 'checked' : '' }} >
                        <label class="form-check-label" for="option_{{ $item->id }}">{{ $item->name }}</label>
                    </div>
                    @endforeach
                </div>
            </div>

    	</div> <!-- /.col-9 -->
        <div class="col-3">
            @include('admin.partials.action_button')
            @include('admin.partials.image', ['title'=>'Hình ảnh', 'id'=>'cover_img', 'name'=>'cover', 'image'=>$cover??''])
        </div> <!-- /.col-9 -->
  	</div> <!-- /.row -->
</form>

<script type="text/javascript">
    jQuery(document).ready(function ($){
        editor('content');
        $('.slug_slugify').slugify('.title_slugify');

        //Date range picker
        $('#reservationdate').datetimepicker({
            format: 'YYYY-MM-DD hh:mm:ss'
        });
        
        //xử lý validate
        $("#frm-create-page").validate({
            rules: {
                name: "required",
                code: "required",
                service_id: "required",
            },
            messages: {
                name: "Nhập tên gói tin",
                code: "Nhập mã gói tin",
                service_id: "Chọn gói dịch vụ",
            },
            errorElement : 'div',
            errorLabelContainer: '.errorTxt',
            invalidHandler: function(event, validator) {
                $('html, body').animate({
                    scrollTop: 0
                }, 500);
            }
        });
    });
</script>
@endsection