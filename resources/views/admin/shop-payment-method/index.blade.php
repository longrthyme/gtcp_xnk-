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
    $created_at = isset($created_at)?date('Y-m-d H:i', strtotime($created_at)) : date('Y-m-d H:i');
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
                                        <th>Title</th>
                                        <th>Payment Method</th>
                                        <th>Code payment</th>
                                        <th  class="text-center">Trạng thái</th>
                                        <th class="text-center" width="100">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($posts as $post)
                                    <tr class="{{ !empty($id) && $id == $post->id ? 'active' : '' }}">
                                        <td>{!! $post->name !!}</td>
                                        
                                        <td>
                                            <a href="{{ route('admin_payment_method.item', $post->id) }}" title="Payment method" class="btn btn-outline-info">Manager Method ({{ $post->method()->count() }})</a>
                                        </td>
                                        <td>{!! $post->code !!}</td>
                                        <td class="text-center">
                                            <div>
                                                {{ date('Y-m-d H:i', strtotime($post->created_at)) }}
                                            </div>
                                            @if($post->status)
                                            <span class="badge badge-primary">Hiển thị</span>
                                            @else
                                            <span class="badge badge-secondary">Ẩn</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{route('admin_payment_method.edit', array($post->id))}}"><i class="fas fa-pencil-alt"></i></a>
                                            <a class="text-danger ml-2" href="{{ route('admin_payment_method.delete', $post->id) }}"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="fr">
                            {!! $posts->links() !!}
                        </div>
		        	</div> <!-- /.card-body -->
	      		</div><!-- /.card -->
	    	</div> <!-- /.col -->
            <div class="col-lg-7">
                <form action="{{ $url_action }}" method="POST" id="frm-create-post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$id?? 0}}">
                    <input type="hidden" name="game_id" value="{{ $game->id ?? 0 }}">
                    <input type="hidden" name="category_id" value="{{ $category->id ?? 0 }}">
                    <div class="card">
                        <div class="card-header"><h4>Thêm/Sửa</h4></div> <!-- /.card-header -->
                        <div class="card-body">
                            <!-- show error form -->
                            <div class="errorTxt"></div>

                            <div class="form-row mb-2">
                                <label class="col-lg-4 col-form-label" >Title</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $name??'') }}" required>
                                    @error('name')
                                        <div class="text-danger" style="font-size: 12px;">
                                            {{ $errors->first('name') }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row mb-2">
                                <label class="col-lg-4 col-form-label" >Code payment</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" id="code" name="code" value="{{ old('code', $code??'') }}" required>
                                    @error('code')
                                        <div class="text-danger" style="font-size: 12px;">
                                            {{ $errors->first('code') }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="bg-light p-3 my-3 border">
                                <div class="form-group mb-2">
                                    @include('admin.shop-payment-method.setting')
                                </div>
                            </div>

                            <div class="row mb-2">
                                <label class="col-lg-4 col-form-label">Trạng thái</label>
                                <div class="col-lg-8 icheck-primary pt-1">
                                    <input type="checkbox" id="status" name="status" value="1" {{ isset($status) && $status == 1 ? 'checked' : '' }}>
                                    <label for="status">Hiển thị</label>
                                </div>
                            </div>
                            
                            <div class="form-group text-end m-b-0">
                                <a class="btn btn-secondary btn-sm" href="{{ route('admin_payment_method') }}">Danh sách</a>
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
        $('.deleteBtn').click(function() {
            if (confirm('Bạn có chắc muốn xóa tài khoản này?')) {
                return true;
            }
            return false;
        });

    });
</script>
@endpush