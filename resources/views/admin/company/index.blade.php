@extends('admin.layouts.index')
@section('seo')
    <title>{{ $title }}</title>
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
                <div class="table-responsive">
            <table class="table table-bordered" id="table_index">
                <thead>
                    <tr>
                        <th class="text-center"><input type="checkbox" id="selectall" onclick="select_all()"></th>
                        <th class="text-center">Title</th>
                        <th class="text-center">Thumbnail</th>
                        <th class="text-center">Date</th>
                        <th class="text-center"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $item)
                    <tr>
                        <td class="text-center">
                            <input type="checkbox" id="{{ $item->id }}" class="grid-row-checkbox" data-id="{{ $item->id }}">
                        </td>
                        <td>
                            <a href="{{ route('admin_company.edit', $item->id) }}" title=""><b>{{ $item->name }}</b></a>
                            <div>
                                <a class="text-dark" href="{{ route('post.single', ['slug' => $item->slug]) }}" target="_blank">{{ route('post.single', ['slug' => $item->slug]) }}</a>
                            </div>
                        </td>
                        <td class="text-center">
                            @if($item->image)
                            <img src="{{ asset($item->image) }}" width="80">
                            @endif
                        </td>
                        <td>
                            {{ $item->created_at }}
                            @if($item->status)
                            <span class="badge bg-label-primary">Public</span>
                            @else
                            <span class="badge bg-label-dark">Draft</span>
                            @endif
                        </td>
                        <td>
                            <div>
                                <span onclick="deleteItem('{{ $item->id }}');" title="{{ sc_language_render('action.delete') }}" class="btn btn-flat btn-sm btn-danger">
                                    <i class="fas fa-trash-alt"></i>
                                </span>
                            </div>  
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="fr">
            {!! $posts->links() !!}
        </div>
            </div>
        </div>

        
        
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ sc_file('assets/plugins/jquery.pjax.js')}}"></script>

    @include('admin.component.script_remove_list')
@endpush