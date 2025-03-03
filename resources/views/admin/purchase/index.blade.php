@extends('admin.layouts.index')
@section('seo')
    @include('admin.layouts.seo')
@endsection

@section('content')

<h6 class="fw-bold py-3 mb-0"><span class="text-muted fw-light">Dashboard /</span> {{ $title }}</h6>

<div class="card">
  	<div class="card-body" id="pjax-container">
        <div class="row g-4">
            <div class="col-lg-5">
            </div>
            <div class="col-lg-7">
                <form method="GET" action="" id="frm-filter-post" class="form-inline">
                    <div class="row g-2">
                        <div class="col-sm-10 col-8">
                            <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Từ khoá">
                        </div>
                        <div class="col-sm-2 col-4 d-grid">
                            <button type="submit" class="btn btn-primary text-nowrap">Tìm kiếm</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-bordered" id="table_index">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th>Đơn hàng</th>
                                <th class="text-center">Tên Gói</th>
                                <th>User</th>
                                <th>Số tiền</th>
                                <th>Ngày nạp</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($posts as $item)
                                <tr>
                                    <td class="text-center">{{ $item->id }}</td>
                                    
                                    <td>
                                        <a href="{{ route('admin_purchase.edit', $item->id) }}">{{ $item->payment_code }}</a>
                                    </td>
                                    <td class="text-center">{{ $item->package['name'] }}</td>
                                    <td class="text-primary">
                                        <a href="{{ route('admin_user.edit',  $item->getUser->id??0) }}">
                                            {{ $item->getUser->fullname??'' }}
                                        </a>
                                    </td>
                                    
                                    <td class="text-primary">{{ number_format($item->amount) }} đ</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>
                                        @if($item->status == 1)
                                            <span class="badge bg-success">Thành công</span>
                                        @elseif($item->status == 2)
                                            <span class="badge bg-danger">GD không thành công</span>
                                        @else
                                            @php
                                              $created_at = str_replace('/', '-', $item->created_at);
                                              $created_at = \Carbon\Carbon::parse($created_at);
                                              $duration = $created_at->diffInDays(now(), true);
                                            @endphp
                                            @if($duration > 2 && $created_at < now())
                                            <span class="badge bg-danger">Hết hạn</span>
                                            @elseif($item->status == 0)
                                            <span class="badge bg-info">Đơn mới</span>
                                            @elseif($item->status == 3)
                                            <span class="badge bg-danger">Đã hủy</span>
                                            @else
                                            <span class="badge bg-warning">Đang xử lý</span>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                      </tbody>
                    </table>
                </div>
                <div>
                    {!! $posts->links() !!}
                </div>
            </div>
        </div>
	</div> <!-- /.card-body -->
</div><!-- /.card -->
<script type="text/javascript">
    jQuery(document).ready(function ($){
        $('.btn_deletes').click(function() {
            if(confirm('Bạn có chắc muốn xóa tài khoản này?')){
                return true;
            }
            return false;
        });
    });
</script>
@endsection