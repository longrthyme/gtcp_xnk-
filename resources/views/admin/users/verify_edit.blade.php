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
    }

    $id = $id??0;
    $type = $type??0;
    $province_id = $province_id??0;
    $role = $role??0;

?>
<form action="{{ $url_action }}" method="post" accept-charset="utf-8"  enctype="multipart/form-data" id="formSubmit" class="position-relative">
    @csrf
    <input type="hidden" name="id" value="{{ $user->id ?? 0 }}">

    <div class="row">
        <div class="col-9">
            <div class="card">
                <div class="card-body">
                    <h4>{{ $title }}</h4>
                    <!-- show error form -->
                    <div class="errorTxt"></div>
                    @if(count($errors)>0)
                        <div class="alert-tb alert alert-danger">
                            @foreach($errors->all() as $err)
                              <i class="fa fa-exclamation-circle"></i> {{ $err }}<br/>
                            @endforeach
                        </div>
                    @endif
                    
                    <table class="table">
                        @if($user->account_type)
                        <tr><td width="200">Tài khoản:</td><td><b>{{ $user->account_type ? 'TÀI KHOẢN TỔ CHỨC' : 'TÀI KHOẢN CÁ NHÂN' }}</b></td></tr>
                        <tr><td>Tên Công ty:</td><td>{{ $company??'' }}</td></tr>
                        <tr><td>Địa chỉ Công ty:</td><td>{{ $address??'' }}</td></tr>
                        <tr><td>Số điện thoại công ty:</td><td>{{ $phone??'' }}</td></tr>
                        <tr><td>Địa chỉ email công ty:</td><td>{{ $email??'' }}</td></tr>
                        <tr><td>Website:</td><td>{{ $website??'' }}</td></tr>
                        <tr><td>Mã số thuế:</td><td>{{ $mst??'' }}</td></tr>
                        <tr><td>Người liên hệ:</td><td>{{ $fullname??'' }}</td></tr>
                        <tr><td>Chức vụ:</td><td>{{ $job??'' }}</td></tr>
                        <tr><td>Tên đăng nhập:</td><td>{{ $username??'' }}</td></tr>
                        @else
                        <tr><td width="200">Tài khoản:</td><td><b>{{ $user->account_type ? 'TÀI KHOẢN TỔ CHỨC' : 'TÀI KHOẢN CÁ NHÂN' }}</b></td></tr>
                        <tr><td>Họ và tên:</td><td>{{ $fullname??'' }}</td></tr>
                        <tr><td>Ngày tháng năm sinh:</td><td>{{ !empty($birthday)? date('d/m/Y', strtotime($birthday)) : '' }}</td></tr>
                        <tr><td>Số CCCD:</td><td>{{ $cccd??'' }}</td></tr>
                        <tr><td>Ngày cấp:</td><td>{{ !empty($cccd_date)? date('d/m/Y', strtotime($cccd_date)) : '' }}</td></tr>
                        <tr><td>Nơi cấp:</td><td>{{ $cccd_place??'' }}</td></tr>
                        <tr><td>Nghề nghiệp:</td><td>{{ $job??'' }}</td></tr>
                        <tr><td>Email:</td><td>{{ $email??'' }}</td></tr>
                        <tr><td>Điện thoại:</td><td>{{ $phone??'' }}</td></tr>
                        <tr><td>Tên đăng nhập:</td><td><b>{{ $username??'' }}</b></td></tr>
                        @endif
                    </table>

                    <hr>
                    <h3>Thông tin xác thực</h3>
                    
                    @if($user->account_type)
                        <table class="table">
                            <tr>
                                <td width="200">Logo Công ty</td>
                                <td><img src="{{ asset($user_verify->company_logo) }}" height="200"></td>
                            </tr>
                            <tr>
                                <td>Giấy chứng nhận đăng ký doanh nghiệp</td>
                                <td><img src="{{ asset($user_verify->registration_paper) }}" height="200"></td>
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
                                <td><img src="{{ asset($user_verify->cccd_front) }}" height="200"></td>
                            </tr>
                            <tr>
                                <td>CCCD (mặt sau)</td>
                                <td><img src="{{ asset($user_verify->cccd_back) }}" height="200"></td>
                            </tr>
                            <tr>
                                <td>Hình ảnh selfie với CCCD trước ngực</td>
                                <td><img src="{{ asset($user_verify->selfie) }}" height="200"></td>
                            </tr>
                        </table>
                    @endif
                </div> <!-- /.card-body -->
            </div><!-- /.card -->   
        </div>

        <div class="col-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Xác thực tài khoản</h5>
                    <div class="mb-3">
                        <h5 class="mb-2">Lý do:</h5>
                        <textarea name="note" class="form-control w-100" rows="3">{{ $user_verify->content??'' }}</textarea>
                        
                    </div>
                    <div class="form-group text-end">
                        <button type="submit" name="submit" value="reject" class="btn btn-danger">Từ chối</button>
                        <button type="submit" name="submit" value="save" class="btn btn-info">Xác thực ngay</button>
                    </div>
                </div> <!-- /.card-body -->
            </div>
       </div> <!-- /.col-9 -->

    </div>

    <div class="list-content-loading">
        <div class="half-circle-spinner">
             <div class="circle circle-1"></div>
             <div class="circle circle-2"></div>
        </div>
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
        //check change pass
        $('input[name="check_pass"]').click(function() {
            $('.wrap-pass').toggleClass('avtive-wpap-pass');
        });

        $('#formSubmit').validate({
            onfocusout: false,
            onkeyup: false,
            onclick: false,
            errorElement : 'div',
            errorLabelContainer: '.errorTxtModal',
            invalidHandler: function(event, validator) {
            },
            submitHandler: function(form) {
                $('#formSubmit').find('.list-content-loading').show();
                $('button[type="submit"]').attr('disabled', true);
                form.submit();
            }
        });
    });

    editorQuote('about_me');
</script>
@endpush