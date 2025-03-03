@extends('admin.layouts.index')
@php
    if(isset($data_role))
        extract($data_role->toArray());

@endphp

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
          <li class="breadcrumb-item active">{{$title_head}}</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
  	<div class="container-fluid">
        <form action="{{ route('admin_role.post') }}" method="POST" id="frm-create-useradmin" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $id??0 }}">
    	    <div class="row">
    	      	<div class="col-9">
    	        	<div class="card">
    		          	<div class="card-header">
    		            	<h4>{{ $title_head }}</h4>
    		          	</div> <!-- /.card-header -->
    		          	<div class="card-body">
                            <!-- show error form -->
                            <div class="errorTxt"></div>
                            @if ($errors->has('name'))
                                <span class="form-text">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('name') }}
                                </span>
                            @endif
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="vi" role="tabpanel" aria-labelledby="vi-tab">
                                    <div class="form-group">
                                        <label for="name">Tên</label>
                                        <input type="text" class="form-control title_slugify" id="name" name="name" value="{{ $name ?? '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="slug">Slug</label>
                                        <input type="text" class="form-control" id="slug" name="slug" value="{{ $slug ?? '' }}">
                                    </div>

                                    <div class="form-group">
                                        @php
                                            $listPermission = [];
                                            
                                            if(isset($permission_selected) && is_array($permission_selected)){
                                                foreach($permission_selected as $value){
                                                    $listPermission[] = (int)$value;
                                                }
                                            }
                                        @endphp

                                        <label for="post_description">Quyền</label>
                                        <select name="permission[]" id="admin_level" class="form-control select2" multiple="multiple" onautocomplete="off">
                                            <option value=""></option>
                                            @foreach ($permission as $k => $v)
                                                <option value="{{ $k }}"  {{ (count($listPermission) && in_array($k, $listPermission))?'selected':'' }}>{{ $v }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
    		        	</div> <!-- /.card-body -->
    	      		</div><!-- /.card -->
    	    	</div> <!-- /.col-9 -->
                <div class="col-3">
                    @include('admin.partials.action_button')
               </div> <!-- /.col-9 -->    	  	
            </div> <!-- /.row -->
        </form>
  	</div> <!-- /.container-fluid -->
</section>
<script type="text/javascript">
    jQuery(document).ready(function ($){
        //xử lý validate
        $("#frm-create-useradmin").validate({
            rules: {
                email: {
                  required: true,
                  // email: true
                },
                name: "required",
                password: "required",
                repassword: {
                    equalTo: "#password"
                },
            },
            messages: {
                email: {
                  required: "Vui lòng nhập Email",
                  // email: "Email không hợp lệ"
                },
                name: "Nhập tên nhân viên",
                password: "Nhập mật khẩu",
                repassword: "Mật khẩu không chính xác",
            },

            // errorElement : 'div',
            // errorLabelContainer: '.errorTxt',
            invalidHandler: function(event, validator) {
                $('html, body').animate({
                    scrollTop: 0
                }, 500);
            }
        });

        //check change pass
        // $('#check_change_pass').click(function() {
        //     $('.wrap-password').css();
        // });
    });
</script>
<script type="text/javascript">
	CKEDITOR.replace('post_content',{
		width: '100%',
		resize_maxWidth: '100%',
		resize_minWidth: '100%',
		height:'300',
		filebrowserBrowseUrl: '{{ route('ckfinder_browser') }}',
	});
	CKEDITOR.instances['post_content'];

    CKEDITOR.replace('post_content_en',{
        width: '100%',
        resize_maxWidth: '100%',
        resize_minWidth: '100%',
        height:'300',
        filebrowserBrowseUrl: '{{ route('ckfinder_browser') }}',
    });
    CKEDITOR.instances['post_content_en'];
</script>
@endsection
@section('style')
<style>
    #frm-create-useradmin .error{
        color:#dc3545;
        font-size: 13px;
    }
</style>
@endsection