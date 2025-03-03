@extends('admin.layouts.index')
@section('seo')
    @include('admin.layouts.seo')
@endsection
@section('content')

@php
    if(!empty($post))
    {
        extract($post->toArray());
        $setting = $post->setting ? $post->setting->keyBy('key')->toArray(): [];
    }
    $id = $id??0;
    $type_data = $type_data??'';
    $type = $type??'';
    //$created_at = isset($created_at)?date('Y-m-d H:i', strtotime($created_at)) : date('Y-m-d H:i');
@endphp

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2 justify-content-end">
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
          <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
  	<div class="container-fluid">
	    <div class="row">
	      	<div class="col-lg-7">
	        	<div class="card">
                    <h5 class="card-header">{{ $title }}</h5>
		          	<div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="table_index">
                                <thead>
                                    <tr>
                                        <th class="text-center">ID</th>
                                        <th>Title</th>
                                        <th>Type</th>
                                        <th  class="text-center">Trạng thái</th>
                                        <th class="text-center" width="100">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($posts as $item)
                                    @php
                                        $childs = $item->posts;
                                    @endphp
                                    <tr class="{{ !empty($id) && $id == $item->id ? 'active' : '' }}">
                                        <td class="text-center">{!! $item->id !!}</td>
                                        <td>{!! $item->name !!}</td>
                                        
                                        <td>
                                            {{ $item->type??'' }}
                                            {{ $item->type_data??'' }}
                                        </td>
                                        <td class="text-center">
                                            @if($item->status)
                                            <span class="badge bg-primary">Hiển thị</span>
                                            @else
                                            <span class="badge bg-secondary">Ẩn</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a class="btn btn-sm" href="{{route('admin_product.option_edit', array($item->id))}}"><i class="fas fa-pencil-alt"></i></a>
                                            <a class="btn btn-sm text-danger ml-2" href="{{ route('admin_product.option_delete', $item->id) }}"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    @if($childs)
                                        @foreach($childs as $item)
                                        <tr class="{{ !empty($id) && $id == $item->id ? 'active' : '' }}">
                                            <td class="text-center">{!! $item->id !!}</td>
                                            <td> -- {!! $item->name !!}</td>
                                            
                                            <td>
                                                {{ $item->type??'' }}
                                                {{ $item->type_data??'' }}
                                            </td>
                                            <td class="text-center">
                                                @if($item->status)
                                                <span class="badge bg-primary">Hiển thị</span>
                                                @else
                                                <span class="badge bg-secondary">Ẩn</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a class="btn btn-sm" href="{{route('admin_product.option_edit', array($item->id))}}"><i class="fas fa-pencil-alt"></i></a>
                                                <a class="btn btn-sm text-danger ml-2" href="{{ route('admin_product.option_delete', $item->id) }}"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
		        	</div> <!-- /.card-body -->
	      		</div><!-- /.card -->
	    	</div> <!-- /.col -->
            <div class="col-lg-5">
                <form action="{{ $url_action }}" method="POST" id="frm-create-post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$id?? 0}}">
                    <div class="card">
                        <h5 class="card-header">Thêm/Sửa</h5>
                        <div class="card-body">
                            <!-- show error form -->
                            <div class="errorTxt"></div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Title</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $name??'') }}" required>
                                    @error('name')
                                        <div class="text-danger" style="font-size: 12px;">
                                            {{ $errors->first('name') }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Đơn vị tính</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="unit" name="unit" value="{{ old('unit', $unit??'') }}">
                                    @error('unit')
                                        <div class="text-danger" style="font-size: 12px;">
                                            {{ $errors->first('unit') }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            
                            <div class="row gy-3">
                                <div class="col-md">
                                    <label class="col-form-label">Kiểu hiển thị</label>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input category_item_input" value="input" name="type" id="type_input" {{ $type=='input' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="type_input">Input</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input category_item_input" value="date" name="type" id="type_date" {{ $type=='date' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="type_date">Date</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input category_item_input" value="textarea" name="type" id="textarea" {{ $type=='textarea' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="textarea">Textarea</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input category_item_input" value="select" name="type" id="select" {{ $type=='select' ? 'checked' : '' }}>
                                        
                                        <label class="custom-control-label" for="select">Select</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input category_item_input" value="radio" name="type" id="radio" {{ $type=='radio' ? 'checked' : '' }}>
                                        
                                        <label class="custom-control-label" for="radio">Radio</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input category_item_input" value="checkbox" name="type" id="checkbox" {{ $type=='checkbox' ? 'checked' : '' }}>
                                        
                                        <label class="custom-control-label" for="checkbox">Checkbox</label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <label class="col-form-label">Kiểu dữ liệu</label>
                                    <div class="form-group type-data type-input" style="{{ $type!='input' ? 'display: none' : ''  }};">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input category_item_input" value="text" name="type_data" id="type_text" {{ $type_data=='text' ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="type_text">Text</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input category_item_input" value="number" name="type_data" id="type_number" {{ $type_data=='number' ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="type_number">Number</label>
                                        </div>
                                    </div>
                                    <div class="form-group type-data type-select" style="{{ $type!='select' ? 'display: none' : ''  }};">
                                        <div class="custom-control custom-radio">
                                            <input type="checkbox" class="custom-control-input category_item_input" value="multiple" name="type_data" id="multiple" {{ $type_data=='multiple' ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="multiple">Multiple</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            

                            @include('admin.partials.post_category', ['multiple' => 'none', 'post' => $post??[]])

                            <div class="row mb-2">
                                <label class="col-lg-2 col-form-label">Bắt buộc</label>
                                <div class="col-lg-10 icheck-primary pt-1">
                                    <input type="checkbox" id="required" name="required" value="1" {{ isset($required) && $required == 1 ? 'checked' : '' }}>
                                    <label for="required">Bắt buộc nhập</label>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-lg-2 col-form-label">Trạng thái</label>
                                <div class="col-lg-10 icheck-primary pt-1">
                                    <input type="checkbox" id="status" name="status" value="1" {{ isset($status) && $status == 1 ? 'checked' : '' }}>
                                    <label for="status">Hiển thị</label>
                                </div>
                            </div>
                            
                            <div class="form-group text-end m-b-0">
                                <a class="btn btn-secondary btn-sm" href="{{ route('admin_product.option') }}">Danh sách</a>
                                @if(!empty($id))
                                <button class="btn btn-primary btn-sm" type="submit">Cập nhật</button>
                                @else
                                <button class="btn btn-primary btn-sm" type="submit">Thêm</button>
                                @endif
                            </div>

                        </div>
                    </div>
                </form>
            </div>
	  	</div> <!-- /.row -->
  	</div> <!-- /.container-fluid -->
</section>
@endsection

@push('scripts')
<script>
    jQuery(document).ready(function($) {
        $('input[name="type"]').on('change', function(){
            var type = $(this).val();
            $('.type-data').hide();
            $('.type-'+ type).show();
            
        });
        $('.deleteBtn').click(function() {
            if (confirm('Bạn có chắc muốn xóa tài khoản này?')) {
                return true;
            }
            return false;
        });

    });
</script>
@endpush