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
                <a class="btn btn-danger grid-trash" href="javascript:void(0)"><i class="fas fa-trash"></i> Delete</a>
                <a class="btn btn-primary" href="{{ $url_create }}"><i class="fas fa-plus"></i> Add New</a>
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
                {!! $data_category->links() !!}
                <div class="table-responsive">
                    <table class="table table-bordered" id="table_index">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center"><input type="checkbox" id="selectall" onclick="select_all()"></th>
                                <th scope="col" class="text-center">Title</th>
                                <th scope="col" class="text-center">icon</th>
                                <th scope="col" class="text-center">Thumbnail</th>
                                <th scope="col" class="text-center">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @include('admin.product-category.includes.category_item', ['level'=>0])
                        </tbody>
                    </table>
                </div>
                {!! $data_category->links() !!}
            </div>
        </div>
    </div> <!-- /.card-body -->
	</div><!-- /.card -->
@endsection


@push('scripts')
    <script src="{{ sc_file('assets/plugins/jquery.pjax.js')}}"></script>

    @include('admin.component.script_remove_list')
@endpush