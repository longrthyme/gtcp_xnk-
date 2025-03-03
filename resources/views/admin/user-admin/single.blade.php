@extends('admin.layouts.index')
<?php
$email = (isset($data_admin) && !empty($data_admin)) ? $data_admin->email : "";
$name = (isset($data_admin) && !empty($data_admin)) ? $data_admin->name : "";
$admin_level = (isset($data_admin) && !empty($data_admin)) ? $data_admin->admin_level : "";
$sid = (isset($data_admin) && !empty($data_admin)) ? $data_admin->id : 0;
$title = (isset($data_admin) && !empty($data_admin)) ? "Cập nhật quản trị viên" : "Thêm quản trị viên";
$status = (isset($data_admin) && !empty($data_admin)) ? $data_admin->status : 0;
$date_update = (isset($data_admin) && !empty($data_admin)) ? $data_admin->created : date('Y-m-d h:i:s');
?>

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
          <li class="breadcrumb-item active">{{$title}}</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
  	<div class="container-fluid">
        <form action="{{ sc_route('admin_user_admin.postUserAdmin') }}" method="POST" id="frm-create-useradmin" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="sid" value="{{ $sid }}">
    	    <div class="row">
    	      	<div class="col-9">
    	        	<div class="card">
    		          	<div class="card-header">
    		            	<h4>{{$title}}</h4>
    		          	</div> <!-- /.card-header -->
    		          	<div class="card-body">
                            <!-- show error form -->
                            <div class="errorTxt"></div>
                            @if(count($errors)>0)
                                <div class="alert-tb alert alert-danger">
                                    @foreach($errors->all() as $err)
                                      <i class="fa fa-exclamation-circle"></i> {{ $err }}<br/>
                                    @endforeach
                                </div>
                            @endif
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="vi" role="tabpanel" aria-labelledby="vi-tab">
                                    <div class="form-group">
                                        <label for="name">Tên nhân viên</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="" value="{{ old('name', $name) }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="post_title">Email</label>
                                        <input type="text" class="form-control title_slugify" id="post_title" name="email" placeholder="" value="{{ old('email', $email) }}">
                                    </div>
                                    @if($sid)
                                    <div class="form-group">
                                        <label for="check_pass">Đổi mật khẩu?</label>
                                        <input type="checkbox" name="check_pass" id="check_pass" value="1">
                                    </div>
                                    @endif
                                    <div class="wrap-pass" {{ $sid==0 ? 'style=display:block' : 'style=display:none' }}>
                                        <div class="form-group">
                                            <label for="password">Mật khẩu</label>
                                            <input type="password" class="form-control" id="password" name="password" autocomplete="off" value="">
                                        </div>
                                        <div class="form-group">
                                            <label for="repassword">Xác nhận mật khẩu</label>
                                            <input type="password" class="form-control" id="repassword" name="password_confirmation" autocomplete="off" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        @php
                                            $listRoles = [];
                                            if(isset($user_roles) && is_array($user_roles)){
                                                foreach($user_roles as $value){
                                                    $listRoles[] = (int)$value;
                                                }
                                            }
                                        @endphp
                                        <label for="post_description">Chọn vai trò</label>
                                        <select name="roles[]" multiple class="form-control select2">
                                            <option value=""></option>
                                            @if(isset($roles) && is_array($roles))
                                                @foreach ($roles as $k => $v)
                                                    <option value="{{ $k }}"  {{ (count($listRoles) && in_array($k, $listRoles))?'selected':'' }}>{{ $v }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
    		        	</div> <!-- /.card-body -->
    	      		</div><!-- /.card -->
    	    	</div> <!-- /.col-9 -->
                <div class="col-3">
                    @include('admin.partials.action_button')
               </div> <!-- /.col-9 -->    	  	</div> <!-- /.row -->
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
        $('input[name="check_pass"]').click(function() {
            $('.wrap-pass').toggleClass('avtive-wpap-pass');
        });
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
    .wrap-pass{
        display: none;
    }
    .avtive-wpap-pass{
        display: block;
    }
    #frm-create-useradmin .error{
        color:#dc3545;
        font-size: 13px;
    }
</style>
@endsection