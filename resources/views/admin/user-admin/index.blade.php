@extends('admin.layouts.index')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">List Users</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
          <li class="breadcrumb-item active">List Users</li>
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
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">List Users</h3>
                    </div> <!-- /.card-header -->
                    <div class="card-body">
                        <div class="clear" style="margin-bottom: 10px">
                            <ul class="nav fl">
                                <li class="nav-item">
                                    <a class="btn btn-danger" id="btn_deletes" onclick="delete_id('user_admin')" href="javascript:void(0)"><i class="fas fa-trash"></i> Delete</a>
                                </li>
                                <li class="nav-item">
                                    <a class="btn btn-primary" href="{{ sc_route('admin_user_admin.addUserAdmin') }}" style="margin-left: 6px;"><i class="fas fa-plus"></i> Add New</a>
                                </li>
                            </ul>
                        </div>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="table_index">
                            <thead>
                                <tr>
                                    <th scope="col">Email/Tên đăng nhập</th>
                                    <th scope="col">Họ Tên</th>
                                    <th scope="col">Vai trò</th>
                                    <th scope="col">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data_user as $data)
                                <tr>
                                    <td>
                                        <a href="#" title="">{{ $data->email }}</a>
                                    </td>
                                    <td>{{ $data->name }}</td>
                                    <td>
                                        @if($data->roles->count())
                                            @foreach($data->roles as $role)
                                            <span class="badge bg-success">{{ $role->name }}</span>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ sc_route('admin_user_admin.userAdminDetail', [$data->id]) }}" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i> Edit</a><a href="" title=""></a>
                                        @if($data->id != 1)
                                        <a href="{{ sc_route('admin_user_admin.delete', [$data->id]) }}" class="btn btn-danger btn-sm btn_deletes"><i class="fa fa-trash"></i> Remove</a><a href="" title=""></a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    </div> <!-- /.card-body -->
                </div><!-- /.card -->
            </div> <!-- /.col -->
        </div> <!-- /.row -->
    </div> <!-- /.container-fluid -->
</section>
@endsection
