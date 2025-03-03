@php
$provinces = \App\Models\LocationProvince::get();
@endphp

@extends('admin.layouts.index')
@section('seo')
    <title>Thành viên</title>
@endsection
@section('content')
<h6 class="fw-bold py-3 mb-0"><span class="text-muted fw-light">Dashboard /</span> {{ $title }}</h6>

<?php
    if(isset($user)){
        extract($user->toArray());

        $package = $user->getPackage;
        if($package)
            $package_name = $package->name;
        $count_endDate = $user->countEndDate();
    }

    $id = $id??0;
    $type = $type??0;
    $province_id = $province_id??0;
    $role = $role??0;
    $account_type = $account_type??0;

    $user_disabled = '';
    $company_disabled = 'disabled';
    if($account_type)
    {
        $company_disabled = '';
        $user_display = 'disabled';
    }

?>
<form action="{{ $url_action }}" method="post" accept-charset="utf-8"  enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{ $user->id ?? 0 }}">

    <div class="row">
        <div class="col-9">
            <div class="card">
                <div class="card-body">
                    <h5>{{ $title }}</h5>
                    <!-- show error form -->
                    <div class="errorTxt"></div>
                    @if(count($errors)>0)
                        <div class="alert-tb alert alert-danger">
                            @foreach($errors->all() as $err)
                              <i class="fa fa-exclamation-circle"></i> {{ $err }}<br/>
                            @endforeach
                        </div>
                    @endif

                    @if (!empty($user) && !$user->isVerified() && $user->getVerify)
                    <div class="alert alert-warning alert-dismissible" role="alert">
                        <h6 class="alert-heading d-flex align-items-center mb-1">Thông báo!!</h6>
                        <p class="mb-0">Tài khoản đang chờ xác thực</p>
                        <div><a href="{{ route('admin_user.verify_edit', $user->id) }}" target="_blank">Click vào đây để xác thực tài khoản</a></div>
                    </div>
                    @endif
                    
                    @include('admin.users.detail_company')
                    @include('admin.users.detail_user')
                    
                    
                    
                    <div class="p-3" style="background: #f8f9fa;">
                        <h5>Thông tin gói đăng ký</h5>
                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <label>Gói đăng ký: {{ $package_name??'' }}</label>
                            </div> 
                            <div class="col-lg-12">
                                <label>Thời gian đăng ký: {{ $count_endDate??'' }}</label>
                            </div> 
                         </div> 
                    </div>  
                    {{--
                    <hr>
                    <div class="row g-3">
                        <div class="col-md-12">
                          <label class="mb-2">Giới thiệu</label>
                          <textarea name="about_me" class="form-control" rows="5">{!! $content??'' !!}</textarea>
                        </div>
                    </div>

                    
                    <hr>
                    <div class="row">
                        <div class="form-group col-md-6 mb-3">
                          <label class="mb-2">Địa chỉ</label>
                          <input type="text" class="form-control" name="address" value="{{ $address??'' }}">
                        </div>
                        <div class="form-group col-md-6 col-lg-6 required">
                            <label for="state_province" class="mb-2">Tỉnh/thành <span class="required-f">*</span></label>
                            <select name="state" id="state_province" class="form-control">
                                <option value=""> --- Please Select --- </option>
                                @foreach($provinces as $province)
                                <option value="{{ $province->id }}" {{ $province->id == $province_id ? 'selected' : '' }}>{{ $province->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <hr>
                    @isset($user)
                    <div class="form-group">
                        <label for="check_pass">Đổi mật khẩu?</label>
                        <input type="checkbox" name="check_pass" id="check_pass" value="1">
                    </div>
                    @endisset
                    <div class="wrap-pass" {{ !isset($user) ? 'style=display:block' : '' }}>
                        <div class="form-group">
                            <label for="password">Mật khẩu</label>
                            <input type="password" class="form-control" id="password" name="password" autocomplete="off" value="">
                        </div>
                        <div class="form-group">
                            <label for="repassword">Xác nhận mật khẩu</label>
                            <input type="password" class="form-control" id="repassword" name="password_confirmation" autocomplete="off" value="">
                        </div>
                    </div>
                    --}}
                </div> <!-- /.card-body -->
            </div><!-- /.card -->   

            <div class="card">
                <div class="card-body">
                    <h5>Thông tin kích hoạt</h5>
                    @if(!empty($user))
                        @if($user->account_type)
                            <table class="table">
                                <tr>
                                    <td width="200">Logo Công ty</td>
                                    <td>
                                        @if($user_verify)
                                        <img src="{{ asset($user_verify->company_logo) }}" height="200">
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Giấy chứng nhận đăng ký doanh nghiệp</td>
                                    <td>
                                        @if($user_verify)
                                        <a href="{{ asset($user_verify->registration_paper) }}" target="_blank">Xem <i class='bx bx-right-arrow-alt'></i></a>
                                        @endif
                                    </td> 
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </table>
                        @else
                            <table class="table">
                                <tr>
                                    <td width="200">CCCD (mặt trước)</td>
                                    <td>
                                        @if($user_verify)
                                        <img src="{{ asset($user_verify->cccd_front) }}" height="200">
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>CCCD (mặt sau)</td>
                                    <td>
                                        @if($user_verify)
                                        <img src="{{ asset($user_verify->cccd_back) }}" height="200">
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Hình ảnh selfie với CCCD trước ngực</td>
                                    <td>
                                        @if($user_verify)
                                        <img src="{{ asset($user_verify->selfie) }}" height="200">
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        @endif
                    @endif
                </div>
            </div><!-- /.card -->   
        </div>

        <div class="col-3">
            @php
                $status = $status ?? 1;
                $created_at = $created_at??date('Y-m-d H:i');
                $created_at = date('Y-m-d H:i', strtotime($created_at));
            @endphp
            <div class="card">
                <div class="card-body">
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
                            <label class="form-check-label" for="radioDraft"> Ẩn </label>
                        </div>
                        <div class="form-check">
                            <input type="radio" id="radioPublic" name="status" class="form-check-input" value="1" {{ $status == 1 ? 'checked' : ''  }}>
                            <label class="form-check-label" for="radioPublic"> Hiện </label>
                        </div>
                    </div>
                    <div class="form-group text-end">
                        <button type="submit" name="submit" value="save" class="btn btn-info">Lưu</button>
                        <button type="submit" name="submit" value="apply" class="btn btn-success">Lưu và sửa</button>
                    </div>

                </div> <!-- /.card-body -->
            </div><!-- /.card -->
            
            

            <div class="card mb-3">
                <div class="card-body">
                    <h5>Tài khoản</h5>
                    <select name="account_type" class="form-select">
                        <option value="0">Tài khoản cá nhân</option>
                        <option value="1" {{ $account_type == 1 ? 'selected' : '' }}>Tài khoản tổ chức</option>
                    </select>
                </div>
            </div>

            @php
                $user_types = (new \App\Models\UserType)->getListActive();
            @endphp
            @if($user_roles->count())
            <div class="card mb-3">
                <div class="card-body">
                    <h5>Vai trò</h5>
                    <select name="type" class="form-select">
                        @foreach($user_types as $item)
                        <option value="{{ $item->id }}" {{ $type == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @endif

            @php
                $user_roles = \App\Models\UserRole::get();
            @endphp
            @if($user_roles->count())
            <div class="card mb-3">
                <div class="card-body">
                    <h5>Loại tài khoản</h5>
                    <select name="role" class="form-select">
                        <option value="0">Thành viên thường</option>
                        @foreach($user_roles as $item)
                        <option value="{{ $item->id }}" {{ $role == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @endif

            @include('admin.partials.image', ['title'=>'Avatar', 'id'=>'img', 'name'=>'avatar', 'image'=> ($avatar ?? '')])

       </div> <!-- /.col-9 -->

    </div>
    
</form>
    
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

@push('scripts')
<script type="text/javascript">
    jQuery(document).ready(function ($){
        $('select[name="account_type"]').on('change', function(){
            var val = $(this).val();
            console.log(val);
            $('.account_type').hide();
            $('.account_type').find('.input_value').attr('disabled', true);
            $('.account_type-'+ val).show();
            $('.account_type-'+ val).find('.input_value').attr('disabled', false);
        });

        //check change pass
        $('input[name="check_pass"]').click(function() {
            $('.wrap-pass').toggleClass('avtive-wpap-pass');
        });
    });
    editorQuote('about_me');
</script>
@endpush