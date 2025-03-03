@extends('admin.layouts.index')
@section('seo')
@include('admin.layouts.seo')
@endsection
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">List Slider</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
          <li class="breadcrumb-item active">List Slider</li>
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
		            	<h3 class="card-title">List Slider</h3>
		          	</div> <!-- /.card-header -->
		          	<div class="card-body">
                        <ul class="nav">
                            <li class="nav-item">
                                <a class="btn btn-danger" onclick="delete_id('slider')" href="javascript:void(0)"><i class="fas fa-trash"></i> Delete</a>
                            </li>
                            <li class="nav-item">
                                <a class="btn btn-primary" href="{{ $url_action }}" style="margin-left: 6px;"><i class="fas fa-plus"></i> Add New</a>
                            </li>
                        </ul>
                        <br/>

                        <div class="table-responsive">
                            <table class="table table-bordered" id="table_index">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="selectall" onclick="select_all()"></th>
                                        <th width="30%">Shortcode</th>
                                        <th>Title</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($posts as $data)
                                    <tr>
                                        <td class="text-center"><input type="checkbox" id="{{ $data->id }}" name="seq_list[]" value="{{$data->id}}"></td>
                                        <td>
                                            <div class="mb-1">Kiểu Slider: <span class="border border-primary p-1 d-inline-block">[slider id="{{ $data->id }}"]</span></div>
                                            <div>
                                                Tùy chọn: type="banner", type="partner"
                                            </div>
                                        </td>
                                        <td class="">
                                            <a class="row-title" href="{{route('admin_slider.edit', array($data->id))}}">
                                                <b>{{$data->name}}</b>                              
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            {{$data->created_at}}
                                            <br>
                                            {{ $data->status == 0 ? 'Draft' : 'Public' }}
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