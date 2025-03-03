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
        <ul class="nav mb-3">
        <div class="table-responsive w-100">
            <table class="table table-bordered" id="table_index">
                <thead>
                    <tr>
                        <th scope="col">Tên</th>
                        <th scope="col">Email</th>
                        <th scope="col">Date</th>
                        <th scope="col">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $item)
                    @php
                        $user = $item->getUser;
                    @endphp
                    <tr>
                        <td>
                            <a href="{{ route('admin_user.edit', $user->id) }}" title="">{{ $user->fullname }}</a>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td class="text-center">
                            @if($user->avatar)
                            <img src="{{ asset($user->avatar) }}" alt="" height="70" style="height: 70px;">
                            @endif
                        </td>
                        <td>
                            @if($item->status == 2)
                            <span class="badge bg-danger">Bị từ chối</span>
                            @else
                            <span class="badge bg-warning ">Đang chờ</span>
                            @endif
                            <div>
                                {!! $item->created_at !!}
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('admin_user.verify_edit', $user->id) }}" class="btn btn-outline-primary btn-sm"><i class="fa fa-pen"></i> View</a><a href="" title=""></a>
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