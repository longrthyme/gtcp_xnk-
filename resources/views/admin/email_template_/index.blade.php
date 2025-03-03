@extends('admin.layouts.index')
@section('seo')
<?php
$data_seo = array(
    'title' => 'Email template | '.Helpers::get_option_minhnn('seo-title-add')
);
?>
@include('admin.layouts.seo')
@endsection
@section('content')
<h6 class="fw-bold py-3 mb-0"><span class="text-muted fw-light">Dashboard /</span> {{ $title_head }}</h6>

<div class="card">
  	<div class="card-header">
    	<h3 class="card-title">{{ $title_head }}</h3>
  	</div> <!-- /.card-header -->
  	<div class="card-body">
        <div class="clear">
            <ul class="nav fl">
                <li class="nav-item">
                    <a class="btn btn-danger" onclick="delete_id('email_template')" href="javascript:void(0)"><i class="fas fa-trash"></i> Delete</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-primary" href="{{route('admin.email_template.create')}}" style="margin-left: 6px;"><i class="fas fa-plus"></i> Add New</a>
                </li>
            </ul>
        </div>
        <br/>
        <div class="table-responsive">
            <table class="table table-bordered" id="table_index">
                <thead>
                    <tr>
                        <th scope="col"><input type="checkbox" id="selectall" onclick="select_all()"></th>
                        <th scope="col">Tên</th>
                        <th scope="col">Mã</th>
                        <th scope="col">Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($datas as $data)
                    <tr>
                        <td class="text-center"><input type="checkbox" id="{{$data->id}}" name="seq_list[]" value="{{$data->id}}"></td>
                        <td>
                            <a class="row-title" href="{{route('admin.email_template.edit', array($data->id))}}">
                                <b>{{$data->name}}</b>                      
                            </a>
                        </td>
                        <td>
                            {{$data->group}}
                            
                            
                        </td>
                        <td class="text-center">

                            {!! $data->status == 1 ? '<span class="badge badge-success">Public</span>' : '<span class="badge badge-secondary">Draft</span>' !!}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="fr">
            {!! $datas->links() !!}
        </div>
	</div> <!-- /.card-body -->
	</div><!-- /.card -->
@endsection