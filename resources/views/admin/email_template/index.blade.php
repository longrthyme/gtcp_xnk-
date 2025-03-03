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
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
          <li class="breadcrumb-item active">{{ $title_head }}</li>
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
		            	<h3 class="card-title">{{ $title_head }}</h3>
		          	</div> <!-- /.card-header -->
		          	<div class="card-body" id="pjax-container">
                        <div class="row g-4">
                            <div class="col-lg-5">
                                <a class="btn btn-danger grid-trash" href="javascript:void(0)"><i class="fas fa-trash"></i> Delete</a>
                                <a class="btn btn-primary" href="{{ $url_create }}"><i class="fas fa-plus"></i> Add New</a>
                            </div>
                            <div class="col-lg-7">
                            </div>
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="table_index">
                                        <thead>
                                            <tr>
                                                <th class="text-center"><input type="checkbox" id="selectall" onclick="select_all()"></th>
                                                <th>Tên</th>
                                                <th>Subject</th>
                                                <th>Mã</th>
                                                <th>Trạng thái</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($datas as $data)
                                            <tr>
                                                <td class="text-center"><input type="checkbox" id="{{ $data->id }}" class="grid-row-checkbox" data-id="{{ $data->id }}"></td>
                                                <td>
                                                    <a class="row-title" href="{{route('admin.email_template.edit', array($data->id))}}">
                                                        <b>{{$data->name}}</b>                      
                                                    </a>
                                                </td>
                                                <td>{{ $data->subject }}</td>
                                                <td>
                                                    <span class="text-info">{{$data->group}}</span>
                                                </td>
                                                <td class="text-center">
                                                    @if($data->status == 1)
                                                        <span class="badge bg-success">Public</span>
                                                    @else
                                                        <span class="badge bg-secondary">Draft</span>
                                                    @endif
                                                    <div>
                                                        {{ $data->created_at }}
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="fr">
                                    {!! $datas->links() !!}
                                </div>
                            </div>
                        </div>
		        	</div> <!-- /.card-body -->
	      		</div><!-- /.card -->
	    	</div> <!-- /.col -->
	  	</div> <!-- /.row -->
  	</div> <!-- /.container-fluid -->
</section>
@endsection

@push('scripts')
    <script src="{{ sc_file('assets/plugins/jquery.pjax.js')}}"></script>

    @include('admin.component.script_remove_list')
@endpush