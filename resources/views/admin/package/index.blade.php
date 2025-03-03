@extends('admin.layouts.index')
@section('seo')
    @include('admin.layouts.seo')
@endsection
@section('content')

<h6 class="fw-bold py-3 mb-0"><span class="text-muted fw-light">Dashboard /</span> {{ $title }}</h6>

<div class="card">
  	<div class="card-body" id="pjax-container">
        <ul class="nav mb-3">
            <li class="nav-item">
                <a class="btn btn-primary" href="{{route('admin.package.create')}}" style="margin-left: 6px;"><i class="fas fa-plus"></i> Add New</a>
            </li>
        </ul>
        <div class="table-responsive">
            <table class="table table-bordered" id="table_index">
                <thead>
                    <tr>
                        <th width="100">STT</th>
                        <th>Title</th>
                        <th>Thông tin</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($packages as $data)
                    <tr>
                        <td>
                            <input type="number" name="priority" class="form-control priority text-center" value="{{ $data->sort }}" data-id="{{ $data->id }}" value="{{ $data->priority }}">
                        </td>
                        <td class="text-center">
                            <a class="row-title" href="{{ route('admin.package.edit', $data->id) }}">
                                <b>{{$data->name}}</b>
                                <br>
                            </a>
                            <div>
                                Code:<b style="color:#c76805;"> {{$data->code}}</b>
                            </div>
                        </td>
                        <td>
                            <div>Giá: {{ number_format($data->price) }}</div>
                            @if(!empty($data->promotion) && $data->promotion != 0)
                            <div style="color: #c76805;">KM: {{ number_format($data->promotion) }}</div>
                            @endif
                            <!-- <div>Lượt xem: {{ $data->view }}</div> -->
                            <!-- <div>Max day: {{ $data->max_day }}</div> -->
                        </td>
                        <td class="text-center">
                            {{$data->updated_at}}
                            <br>
                            @if($data->status == 1)
                                <span class="badge badge-primary">Public</span>
                            @else
                                <span class="badge badge-secondary">Draft</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="fr">
            {!! $packages->links() !!}
        </div>
	</div> <!-- /.card-body -->
	</div><!-- /.card -->
@endsection

@push('scripts')
<script>
    jQuery(document).ready(function($) {
        $('[data-toggle="tooltip"]').tooltip();

        $('.priority').on('change', function(){
            axios({
              method: 'post',
              url: '{{ route("admin.package.priority") }}',
              data: {priority:$(this).val(), id:$(this).data('id')}
            }).then(res => {
                alertMsg(res.data.error ? 'success' : 'Error', res.data.msg);
            }).catch(e => console.log(e));
        })

        $('.show_home').on('change', function(){
            axios({
              method: 'post',
              url: '{{ route("admin.package.show_home") }}',
              data: {id:$(this).val()}
            }).then(res => {
                alertMsg(res.data.error ? 'success' : 'Error', res.data.msg);
            }).catch(e => console.log(e));
        })
    });
</script>
@endpush