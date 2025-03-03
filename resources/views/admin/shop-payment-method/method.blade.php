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
    $invoice_currency = isset($invoice_currency) && $invoice_currency != '' ? json_decode($invoice_currency): [];
    
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
	      	<div class="col-lg-6">
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
                                        <th>Code payment</th>
                                        <th  class="text-center">Status</th>
                                        <th class="text-center" width="130">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($posts as $post)
                                    <tr class="{{ !empty($id) && $id == $post->id ? 'active' : '' }}">
                                        <td>
                                            {!! $post->name !!}
                                        </td>
                                        <td>{!! $post->code !!}</td>
                                        <td class="text-center">
                                            @if($post->hot)
                                                <span class="badge bg-danger">Popular</span>
                                            @endif
                                            @if($post->status)
                                                <span class="badge bg-primary">Hiển thị</span>
                                            @else
                                                <span class="badge bg-secondary">Ẩn</span>
                                            @endif
                                            <div class="text-nowrap">
                                                {{ date('Y-m-d H:i', strtotime($post->created_at)) }}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{route('admin_payment_method.item_edit', array($post->id))}}"><i class="fas fa-pencil-alt"></i></a>
                                            <a class="text-danger deleteBtn ml-2" href="{{ route('admin_payment_method.item_delete', $post->id) }}"><i class="fas fa-trash"></i></a>
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
            <div class="col-lg-6">
                <form action="{{ $url_action }}" method="POST" id="frm-create-post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$id?? 0}}">
                    <input type="hidden" name="method_id" value="{{ $method_id ?? 0 }}">
                    <input type="hidden" name="method_code" id="method_code" value="{{ $method->code ?? '' }}">
                    <div class="card">
                        <div class="card-header"><h4>Thêm/Sửa</h4></div> <!-- /.card-header -->
                        <div class="card-body">
                            <!-- show error form -->
                            <div class="errorTxt"></div>

                            <div class="row mb-3">
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
                            <div class="row mb-3">
                                <label class="col-lg-4 col-form-label" >Code payment</label>
                                <div class="col-lg-8">
                                    <input type="hidden" name="method_name" value="{{ old('method_name', $method_name??'') }}">
                                    <input type="text" class="form-control" id="code" name="code" value="{{ old('code', $code??'') }}" required>
                                    @error('code')
                                        <div class="text-danger" style="font-size: 12px;">
                                            {{ $errors->first('code') }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            

                            {{--
                            <div class="row mb-3">
                                <label class="col-lg-4 col-form-label" >Fee (%)</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" id="fee" name="fee" value="{{ old('fee', $fee??'') }}" required>
                                    @error('fee')
                                        <div class="text-danger" style="font-size: 12px;">
                                            {{ $errors->first('fee') }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            --}}

                            <div class="row mb-3">
                                <label class="col-lg-4 col-form-label" >Image</label>
                                <div class="col-lg-8 d-flex">
                                    <div class="demo-img mr-2">
                                        @if(!empty($image))
                                        <img class="img_view" src="{{ asset($image??'') }}" style="height: 35px;">
                                        @else
                                        <img class="img_view" src="{{ asset('assets/images/placeholder.png') }}" style="height: 35px;">
                                        @endif
                                    </div>

                                    <div class="input-group">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="image" id="image" value="{{ old('image', $image??'') }}">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary ckfinder-popup" type="button" id="img" data-show="img_view" data="image">Upload</button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <label class="col-lg-4 col-form-label">Trạng thái</label>
                                <div class="col-lg-8">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="status" name="status" value="1" {{ isset($status) && $status == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status">Hiển thị</label>
                                    </div>

                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-lg-4 col-form-label">Ngày đăng</label>
                                <div class="col-lg-8">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1"><i class="far fa-calendar-alt"></i></span>
                                        <input type='text' class="form-control" name="created_at" id='created_at' value="{{ $created_at??'' }}" />
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group text-end m-b-0">
                                <a class="btn btn-secondary btn-sm" href="{{ route('admin_payment_method.item', $method_id??0) }}">Danh sách</a>
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

        // get collection payment method by country
        $('.country_select2').on('select2:select', function (e) { 
            // var code = $(this).val();
            getCollection();
        });

        $('input[name="amount"]').on('input', function (e) {
            getCollection();
        });

        $(document).on('change', '#payment-method', function(){
            var val = $(this).val(),
                method_code = $('#method_code').val();
            $('input[name="code"]').val(method_code+'__'+val);
            $('input[name="method_name"]').val($(this).find('option:selected').text());
        });

        function getCollection() {
            var form = document.getElementById("frm-create-post"),
            formData = new FormData(form);
            axios({
                method: "post",
                url: "{{ route('admin_payment_method.collection_payment_method') }}",
                data: formData,
            })
            .then((res) => {
                if(!res.data.error)
                    $('#payment_method').html(res.data.view);

            })
            .catch((e) => console.log(e));
        }

    });
</script>
@endpush