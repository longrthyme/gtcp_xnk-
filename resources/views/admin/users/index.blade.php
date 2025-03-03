@extends('admin.layouts.index')

@section('seo')
    <title>Thành viên</title>
@endsection

@section('content')
<h6 class="fw-bold py-3 mb-0"><span class="text-muted fw-light">Dashboard /</span> {{ $title }}</h6>

<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">{{ $title }}</h4>
    </div> <!-- /.card-header -->
    <div class="card-body">
        <div class="row g-4 mb-3">
            <div class="col-lg-5">
                <a class="btn btn-primary" href="{{ $url_create }}" style="margin-left: 6px;"><i class="fas fa-plus"></i> Add New</a>
            </div>
            <div class="col-lg-7">
                <form method="GET" action="" id="frm-filter-post" class="form-inline">
                    <div class="row g-2">

                        <div class="col-sm-10 col-8">
                            <input type="text" class="form-control" name="keyword" id="keyword" value="{{ request('keyword')??'' }}" placeholder="Từ khoá">
                        </div>
                        <div class="col-sm-2 col-4 d-grid">
                            <button type="submit" class="btn btn-primary text-nowrap">Tìm kiếm</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered" id="table_index">
                <thead>
                    <tr>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Hình ảnh</th>
                        <th>Thông tin</th>
                        <th>Date</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>
                            <a href="{{ route('admin_user.edit', $user->id) }}" title="">{{ $user->fullname }}</a>
                                @php
                                $label_user = "";
                                if($user->expert>=1 && $user->status_package_doc==1){
                                    $label_user = 'Tác giả, đăng ký gói trả phí';
                                }
                                elseif($user->expert>=1 && $user->status_package_doc==2){
                                    $label_user = 'Tác giả, đăng ký gói trả phí';
                                }
                                elseif($user->expert>=1){
                                  $label_user = 'Tác giả';  
                                }
                                elseif($user->status_package_doc==1 || $user->status_package_doc==2){
                                    $label_user = 'Đăng ký gói trả phí';  
                                }
                                @endphp
                               
                                <span class="badge badge-primary">{{$label_user}}</span>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td class="text-center">
                            @if($user->avatar)
                            <img src="{{ asset($user->avatar) }}" alt="" height="70" style="height: 70px;">
                            @endif
                        </td>
                        <td>
                            <div>{{ implode(' - ',  array_filter([$user->getType->name??'', $user->getRole->name??''])) }}</div>
                            @if(!empty($user->getPackage))
                            <div>Gói thành viên: <b>{{ $user->getPackage->name }}</b></div>
                            <div>Ngày sử dụng: 
                                @if($user->countEndDate())
                                <b>{{ $user->countEndDate() }} ngày</b>
                                @else
                                <b class="text-danger">Hết hạn</b>
                                @endif
                            </div>
                            @endif
                        </td>
                        <td>
                            @if(is_null($user->email_verified_at))
                                <span class="badge bg-danger">Chưa xác thực</span>
                            @else
                                @if($user->status == 1)
                                <span class="badge bg-success">Hoạt động</span>
                                @else
                                <span class="badge bg-danger">Ngưng hoạt động</span>
                                @endif
                            @endif
                            <br>
                            {!! $user->created_at !!}
                        </td>
                        <td>
                            <a href="{{ route('admin_user.edit', $user->id) }}" class="btn btn-outline-primary btn-sm"><i class="fa fa-pen"></i> Edit</a><a href="" title=""></a>
                            <a href="{{ route('admin_user.delete', $user->id) }}" class="btn btn-outline-danger btn-sm btn_deletes"><i class="fa fa-trash"></i> Remove</a><a href="" title=""></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div> <!-- /.card-body -->
</div><!-- /.card -->
<script type="text/javascript">
    jQuery(document).ready(function ($){
        $('#deleteBtn').click(function() {
            if(confirm('Bạn có chắc muốn xóa tài khoản này?')){
                return true;
            }
            return false;
        });
        
    });
</script>
@endsection