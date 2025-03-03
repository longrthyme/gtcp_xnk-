@extends('admin.layouts.index')
@section('seo')
    <title>{{ $title }}</title>
@endsection
@section('content')

<h6 class="fw-bold py-3 mb-0"><span class="text-muted fw-light">Dashboard /</span> {{ $title }}</h6>

<div class="card">
    <div class="card-body" id="pjax-container">
        <ul class="nav mb-3">
            <li class="nav-item">
                <a class="btn btn-danger grid-trash" href="javascript:void(0)"><i class="fas fa-trash"></i> Delete</a>
            </li>
            <li class="nav-item">
                <a class="btn btn-primary" href="{{ $url_create }}" style="margin-left: 6px;"><i class="fas fa-plus"></i> Add New</a>
            </li>
        </ul>

        <div class="table-responsive">
            <table class="table table-bordered" id="table_index">
                <thead>
                    <tr>
                        <th class="text-center"><input type="checkbox" id="selectall" onclick="select_all()"></th>
                        <th class="text-center">Title</th>
                        <th class="text-center">Danh mục</th>
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
                            <a href="{{ route('admin_logistic.category_edit', $item->id) }}" title=""><b>{{ $item->name }}</b></a>
                        </td>
                        <td>
                            @if($item->getCategory)
                            {{ $item->getCategory->getText()->name??'' }}
                            @endif
                        </td>
                        <td class="text-center">
                            @if($item->image)
                            <img src="{{ asset($item->image) }}" height="80">
                            @endif
                        </td>
                        <td>
                            {{ $item->created_at }}
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
@endsection

@push('scripts')
    <script src="{{ sc_file('assets/plugins/jquery.pjax.js')}}"></script>

    @include('admin.component.script_remove_list')
@endpush