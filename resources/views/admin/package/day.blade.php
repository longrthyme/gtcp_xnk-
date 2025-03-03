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
	      	<div class="col-lg-5">
	        	<div class="card">
		          	<div class="card-header d-flex justify-content-between">
		            	<h3 class="card-title">{{ $title }}</h3>
		          	</div> <!-- /.card-header -->
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
                                            <a href="{{route('admin_package.day_edit', array($item->id))}}"><i class="fas fa-pencil-alt"></i></a>
                                            <a class="text-danger ml-2" href="{{ route('admin_package.day_delete', $item->id) }}"><i class="fas fa-trash"></i></a>
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
                                                <a href="{{route('admin_package.day_edit', array($item->id))}}"><i class="fas fa-pencil-alt"></i></a>
                                                <a class="text-danger ml-2" href="{{ route('admin_package.day_delete', $item->id) }}"><i class="fas fa-trash"></i></a>
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
            <div class="col-lg-7">
                <form action="{{ $url_action }}" method="POST" id="frm-create-post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$id?? 0}}">
                    <div class="card">
                        <div class="card-header"><h4>Thêm/Sửa</h4></div> <!-- /.card-header -->
                        <div class="card-body">
                            <!-- show error form -->
                            <div class="errorTxt"></div>

                            <div class="form-row mb-2">
                                <label class="col-form-label">Title</label>
                                <div>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $name??'') }}" required>
                                    @error('name')
                                        <div class="text-danger" style="font-size: 12px;">
                                            {{ $errors->first('name') }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row mb-2">
                                <label class="col-form-label">Số lượng của kiểu</label>
                                <div>
                                    <input type="text" class="form-control" id="day" name="day" value="{{ old('day', $day??'') }}" required>
                                    @error('day')
                                        <div class="text-danger" style="font-size: 12px;">
                                            {{ $errors->first('day') }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row mb-2">
                                <label class="col-form-label">Kiểu</label>
                                <div>
                                    <select name="type" class="form-select">
                                        <option value="day" {{ $type == 'day' ? 'selected' : '' }}>day</option>
                                        <option value="month" {{ $type == 'month' ? 'selected' : '' }}>month</option>
                                        <option value="year" {{ $type == 'year' ? 'selected' : '' }}>year</option>
                                    </select>
                                    @error('type')
                                        <div class="text-danger" style="font-size: 12px;">
                                            {{ $errors->first('type') }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row mb-2">
                                <label class="col-form-label">Số lượng khuyến mãi</label>
                                <div>
                                    <input type="number" class="form-control" id="qty" name="qty" value="{{ old('qty', $qty??'') }}" required>
                                    @error('qty')
                                        <div class="text-danger" style="font-size: 12px;">
                                            {{ $errors->first('qty') }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-2">
                                <label class="col-lg-3 col-form-label">Trạng thái</label>
                                <div class="col-lg-9 icheck-primary pt-1">
                                    <input type="checkbox" id="status" name="status" value="1" {{ isset($status) && $status == 1 ? 'checked' : '' }}>
                                    <label for="status">Hiển thị</label>
                                </div>
                            </div>
                            
                            <div class="form-group text-end m-b-0">
                                <a class="btn btn-secondary btn-sm" href="{{ route('admin_package.day') }}">Danh sách</a>
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