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
                <!-- <a class="btn btn-primary" href="{{ $url_create }}"><i class="fas fa-plus"></i> Add New</a> -->
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
                                <th class="text-center">Category</th>
                                <th class="text-center">Tài khoản</th>
                                <th class="text-center">Loại tài khoản</th>
                                <th class="text-center">Trạng thái tài khoản</th>
                                <th class="text-center">Thumbnail</th>
                                <th class="text-center">Duyệt tin</th>
                                <th class="text-center">Date</th>
                                <th class="text-center"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($posts as $item)
                                @php
                                    $author = $item->getAuth;
                                    $options = $item->getOptions();
                                @endphp
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" id="{{ $item->id }}" class="grid-row-checkbox" data-id="{{ $item->id }}">
                                </td>
                                <td>
                                    <div class="mb-1">
                                        <a href="{{ route('admin_product.edit', $item->id) }}" title="">
                                            @if($item->name == '')
                                                @foreach($item->getCategories() as $item_)
                                                    <span>{{ $item_['name'] }} / </span>
                                                @endforeach
                                                <b>{{ $item->getAddressFull()?current($item->getAddressFull()):'' }}</b>
                                                <b>{{ $item->getAddressEnd()?' - ' .current($item->getAddressEnd()):'' }}</b>
                                            @else
                                                <b>{{ $item->name }}</b>
                                            @endif
                                        </a>    
                                    </div>
                                    @if(!empty($options[104]))
                                    <div class="mb-1">
                                        Phương thức vận chuyển: <b>{{ $options[104]??'' }}</b>
                                    </div>
                                    @endif
                                    <div>
                                        <a class="text-dark" href="{{ $item->getUrl() }}" target="_blank">{{ $item->getUrl() }}</a>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $categories = $item->categories;
                                    @endphp
                                    @foreach($categories as $index => $category)
                                        @if($index > 0), @endif
                                        <a href="{{ route('admin_product.category_edit', $category->id) }}" target="_blank">{{ $categoriesTitle[$category->id] }}</a>
                                    @endforeach
                                </td>
                                <td>
                                    @if($author)
                                        <b>{{ $author->username }}</b>
                                    @endif
                                </td>
                                <td class="text-nowrap">
                                    @if($author)
                                        <b>{{ $author->getPackage->name??'Tài khoản thường' }}</b>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($author)
                                        <div>
                                            @if(is_null($author->email_verified_at))
                                                <span class="badge bg-danger">Chưa xác thực</span>
                                            @else
                                                @if($author->status == 1)
                                                <span class="badge bg-success">Hoạt động</span>
                                                @else
                                                <span class="badge bg-danger">Ngưng hoạt động</span>
                                                @endif
                                            @endif
                                        </div>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($item->image)
                                    <img src="{{ asset($item->image) }}" width="80">
                                    @endif
                                </td>
                                <td>
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input process-duyettin" data-id="{{ $item->id }}" type="checkbox" id="duyettin_{{ $item->id }}" value="1" {{ $item->status == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="duyettin_{{ $item->id }}">Duyệt tin</label>
                                    </div>
                                </td>   
                                <td>
                                    {{ $item->created_at }}
                                    @if($item->status==1)
                                    <span class="badge bg-label-primary">Public</span>
                                    @elseif($item->status==2)
                                    <span class="badge bg-label-warning">Pendding</span>
                                    @elseif($item->status==3)
                                    <span class="badge bg-label-danger">Reject</span>
                                    @else
                                    <span class="badge bg-label-dark">Draft</span>
                                    @endif
                                </td>
                                <td>
                                    <div>
                                        <a class="btn btn-info btn-sm" href="{{ route('admin_product.edit', $item->id) }}" title="">
                                            <i class="fas fa-pen-square"></i>
                                        </a>
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
                <div class="my-3">
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

    <script>
        jQuery(document).ready(function($) {
            $('.process-duyettin').on('change', function(){
                var id = $(this).data('id'),
                    value = 0;

                if($(this).is(":checked"))
                    value = 1;
                axios({
                    method: 'post',
                    url: '{{ route("admin_product.duyet-tin") }}',
                    data: {id:id, value:value}
                }).then(res => {
                  alertMsg('success', res.data.message);
                }).catch(e => console.log(e));

            });
        });
    </script>   
@endpush