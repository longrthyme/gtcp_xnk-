@extends('admin.layouts.index')
@section('seo')
  @include('admin.layouts.seo')
@endsection

@section('content')

<h6 class="fw-bold py-3 mb-0"><span class="text-muted fw-light">Dashboard /</span> {{ $title }}</h6>

<form action="{{ $url_action }}" method="POST" id="frm-order-detail">
    @csrf
    <input type="hidden" name="id" value="{{ $history->id??0 }}">
    <div class="card">
        <div class="card-body">
            <div class="row g-4">
                <div class="col-lg-6">
                    <h3 class="card-title">Thông tin khách hàng</h3>
                </div>
                <div class="col-lg-6 text-end">
                    <a href="{{ route('admin_purchase') }}" title="" class="ml-3"><i class="fa fa-bars"></i> Trở về danh sách</a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <tr>
                      <td style="width: 200px;">Mã đơn hàng:</td>
                      <td>{{ $history->payment_code }}</td>
                    </tr>
                    <tr>
                      <td>Name:</td>
                      <td>{{ $user->fullname }}</td>
                    </tr>
                    <tr>
                      <td>Phone:</td>
                      <td>{{ $user->phone }}</td>
                    </tr>

                    <tr>
                      <td>Email:</td>
                      <td>{{ $user->email }}</td>
                    </tr>

                    <tr>
                      <td>Thời gian:</td>
                      <td>{{ date('H:i d-m-Y', strtotime($history->created_at)) }}</td>
                    </tr>

                    <tr>
                    	<td>Trạng thái: </td>
                      <td>
                        @if($history->status == 1)
                          <span class="badge bg-success">Thành công</span>
                        @else
                          <select name="status" class="form-control">
                            <option value="0" {{ $history->status == 0 ? 'selected' : '' }}>Mới đặt</option>
                            <option value="1" {{ $history->status == 1 ? 'selected' : '' }}>Thành công</option>
                            <option value="2" {{ $history->status == 2 ? 'selected' : '' }}>Đợi xử lý</option>
                            <option value="3" {{ $history->status == 3 ? 'selected' : '' }}>Đã hủy</option>
                          </select>
                        @endif
                    </td>
                    </tr>
                    @if($history->status != 1)
                    <tr>
                    	<td colspan="2" class="text-center">
                    		<button type="submit" class="btn btn-primary">Cập nhật</button>
                    	</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div> <!-- /.card-body -->
    </div><!-- /.card -->
</form>

<script>
  $(function () {
    // Summernote
    $('#admin_note').summernote({
        placeholder: 'Enter your note',
        tabsize: 2,
        focus: true,
        height: 200,
        codemirror: { // codemirror options
            theme: 'monokai'
        }
    });
  })
</script>
@endsection