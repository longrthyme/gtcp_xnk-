@extends('admin.layouts.index')

@section('seo')
@include('admin.layouts.seo')
@endsection

@section('content')
@php
    $id = empty($id) ? 0 : $id;
@endphp
<h6 class="fw-bold py-3 mb-0"><span class="text-muted fw-light">Dashboard /</span> {{ $title }}</h6>

<div class="row g-3">

  <div class="col-md-6">

    <div class="card">

<div class="card-body">
  <h5>
      <a class="btn btn-warning btn-flat menu-sort-save" title="Save"><i class="fa fa-save"></i><span class="hidden-xs">&nbsp;Save</span></a>
  </h5>
  <div class="box-body table-responsive">
  <div class="dd" id="menu-sort">
      <ol class="dd-list">

{{-- Level 0 --}}
        @foreach ($menus[0] as $level0)
          @if ($level0->type ==1)
            <li class="dd-item " data-id="{{ $level0->id }}">
                <div class="dd-handle header-fix  {{ ($level0->id == $id)? 'active-item' : '' }}">
                  {!! __($level0->title) !!}
                  <span class="float-right dd-nodrag">
                      <a href="{{ route('admin_menu.edit',['id'=>$level0->id]) }}"><i class="fa fa-edit"></i></a>
                      &nbsp; 
                      <a data-id="{{ $level0->id }}" class="remove_menu"><i class="fa fa-trash"></i></a>
                  </span>
                </div>
            </li>
          @elseif($level0->uri)
            <li class="dd-item" data-id="{{ $level0->id }}">
                <div class="dd-handle {{ ($level0->id == $id)? 'active-item' : '' }}">
                  <i class="{{ $level0->icon }}"></i> {!! __($level0->title) !!}
                  <span class="float-right dd-nodrag">
                      <a href="{{ route('admin_menu.edit',['id'=>$level0->id]) }}"><i class="fa fa-edit fa-edit"></i></a>
                      &nbsp; 
                      <a data-id="{{ $level0->id }}" class="remove_menu"><i class="fa fa-trash fa-edit"></i></a>
                  </span>
                </div>
            </li>
          @else
            <li class="dd-item " data-id="{{ $level0->id }}">
              <div class="dd-handle {{ ($level0->id == $id)? 'active-item' : '' }}">
                <i class="{{ $level0->icon }}"></i> {!! __($level0->title) !!}
                  <span class="float-right dd-nodrag">
                      <a href="{{ route('admin_menu.edit',['id'=>$level0->id]) }}"><i class="fa fa-edit fa-edit"></i></a>
                      &nbsp; 
                      <a data-id="{{ $level0->id }}" class="remove_menu"><i class="fa fa-trash fa-edit"></i></a>
                  </span>
              </div>
    {{-- Level 1 --}}
            @if (isset($menus[$level0->id]) && count($menus[$level0->id]))
              <ol class="dd-list">
                @foreach ($menus[$level0->id] as $level1)
                  @if($level1->uri)
                    <li class="dd-item" data-id="{{ $level1->id }}">
                        <div class="dd-handle {{ ($level1->id == $id)? 'active-item' : '' }}">
                          <i class="{{ $level1->icon }}"></i> {!! __($level1->title) !!}
                          <span class="float-right dd-nodrag">
                              <a href="{{ route('admin_menu.edit',['id'=>$level1->id]) }}"><i class="fa fa-edit fa-edit"></i></a>
                              &nbsp; 
                              <a data-id="{{ $level1->id }}" class="remove_menu"><i class="fa fa-trash fa-edit"></i></a>
                          </span>
                        </div>
                    </li>
                  @else
                  <li class="dd-item" data-id="{{ $level1->id }}">
                    <div class="dd-handle {{ ($level1->id == $id)? 'active-item' : '' }}">
                      <i class="{{ $level1->icon }}"></i> {!! __($level1->title) !!}
                      <span class="float-right dd-nodrag">
                          <a href="{{ route('admin_menu.edit',['id'=>$level1->id]) }}"><i class="fa fa-edit fa-edit"></i></a>
                          &nbsp; 
                          <a data-id="{{ $level1->id }}" class="remove_menu"><i class="fa fa-trash fa-edit"></i></a>
                      </span>
                    </div>
            {{-- LEvel 2  --}}
                        @if (isset($menus[$level1->id]) && count($menus[$level1->id]))
                          <ol class="dd-list dd-collapsed">
                            @foreach ($menus[$level1->id] as $level2)
                              @if($level2->uri)
                                <li class="dd-item" data-id="{{ $level2->id }}">
                                    <div class="dd-handle {{ ($level2->id == $id)? 'active-item' : '' }}">
                                      <i class="{{ $level2->icon }}"></i> {!! __($level2->title) !!}
                                      <span class="float-right dd-nodrag">
                                          <a href="{{ route('admin_menu.edit',['id'=>$level2->id]) }}"><i class="fa fa-edit fa-edit"></i></a>
                                          &nbsp; 
                                          <a data-id="{{ $level2->id }}" class="remove_menu"><i class="fa fa-trash fa-edit"></i></a>
                                      </span>
                                    </div>
                                </li>
                              @else
                              <li class="dd-item" data-id="{{ $level2->id }}">
                                <div class="dd-handle {{ ($level2->id == $id)? 'active-item' : '' }}">
                                  <i class="{{ $level2->icon }}"></i> {!! __($level2->title) !!}
                                  <span class="float-right dd-nodrag">
                                      <a href="{{ route('admin_menu.edit',['id'=>$level2->id]) }}"><i class="fa fa-edit fa-edit"></i></a>
                                      &nbsp; 
                                      <a data-id="{{ $level2->id }}" class="remove_menu"><i class="fa fa-trash fa-edit"></i></a>
                                  </span>
                                </li>
                              @endif
                            @endforeach
                          </ol>
                        @endif
                        {{--  end level 2 --}}
                    </li>
                  @endif
                 @endforeach
              </ol>
            @endif
              {{-- end level 1 --}}
            </li>
          @endif

        @endforeach
      {{-- end level 0 --}}
      
    </ol>
</div>

      </div>
    </div>
    </div>
  </div>

  <div class="col-md-6">

    <div class="card"> 
                <form action="{{ $url_action }}" method="post" accept-charset="UTF-8" class="form-horizontal" id="form-main"  enctype="multipart/form-data">

                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">{!! $title !!}</h5>
                          @if ($layout == 'edit')
                              <div class="btn-group" style="margin-right: 5px">
                                  <a href="{{ route('admin_menu.index') }}" class="btn  btn-flat btn-default" title="List"><i class="fa fa-list"></i><span class="hidden-xs"> {{ __('admin.back_list') }}</span></a>
                              </div>
                          @endif
                      </div>

                      <div class="form-group row {{ $errors->has('parent_id') ? ' text-red' : '' }}">
                        <label for="parent_id" class="col-sm-2 col-form-label">Parent</label>
                        <div class="col-sm-10 ">
                          <select class="form-control parent mb-3" name="parent_id" >
                            <option value="0" {{ (old('parent_id',$menu['parent_id']??'') ==0) ? 'selected':'' }}>== ROOT ==</option>
                            @foreach ($treeMenu as $k => $v)
                                <option value="{{ $k }}" {{ (old('parent',$menu['parent_id']??'') ==$k) ? 'selected':'' }}>{!! $v !!}</option>
                            @endforeach
                        </select>
            
                          @if ($errors->has('parent_id'))
                          <span class="text-sm">
                            <i class="fa fa-info-circle"></i> {{ $errors->first('parent_id') }}
                          </span>
                          @endif
            
                        </div>
                      </div>

                      <div class="form-group row {{ $errors->has('title') ? ' text-red' : '' }}">
                        <label for="title" class="col-sm-2 col-form-label">Title</label>
                        <div class="col-sm-10 ">

                          <div class="input-group input-group-merge">
                            <span id="basic-icon-default-company2" class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                            <input type="text" id="title" name="title" value="{!! old()?old('title'):$menu['title']??'' !!}" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}">
                          </div>

            
                          @if ($errors->has('title'))
                          <span class="text-sm">
                            <i class="fa fa-info-circle"></i> {{ $errors->first('title') }}
                          </span>
                          @endif
            
                        </div>
                      </div>

                      <div class="form-group row {{ $errors->has('icon') ? ' text-red' : '' }}">
                        <label for="icon" class="col-sm-2 col-form-label">Icon</label>
                        <div class="col-sm-10 ">
                          <div class="input-group input-group-merge">
                              <span class="input-group-text input-group-addon">
                                <i class="{{ $menu['icon']??'fas fa-pencil-alt' }}"></i>
                              </span>
                            <input style="width: 140px" type="text" id="icon" name="icon" value="{!! old()?old('icon'):$menu['icon']??'' !!}" class="form-control icon {{ $errors->has('icon') ? ' is-invalid' : '' }} " placeholder="Input Icon" autocomplete="off">
                          </div>
                          
            
                          @if ($errors->has('icon'))
                          <span class="text-sm">
                            <i class="fa fa-info-circle"></i> {{ $errors->first('icon') }}
                          </span>
                          @endif
            
                        </div>
                      </div>

                      <div class="form-group row {{ $errors->has('uri') ? ' text-red' : '' }}">
                        <label for="uri" class="col-sm-2 col-form-label">Url</label>
                        <div class="col-sm-10 ">
                          <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                            <input type="text" id="uri" name="uri" value="{!! old()?old('uri'):$menu['uri']??'' !!}" class="form-control uri {{ $errors->has('uri') ? ' is-invalid' : '' }}" placeholder="Input uri">
                          </div>
            
                          @if ($errors->has('uri'))
                          <span class="text-sm">
                            <i class="fa fa-info-circle"></i> {{ $errors->first('uri') }}
                          </span>
                          @endif
            
                        </div>
                      </div>

                      <div class="form-group row {{ $errors->has('sort') ? ' text-red' : '' }}">
                        <label for="sort" class="col-sm-2 col-form-label">Sort</label>
                        <div class="col-sm-10 ">
                          <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                            <input type="number" style="width: 100px;" id="sort" name="sort" value="{!! old()?old('sort'):$menu['sort']??'' !!}" class="form-control sort {{ $errors->has('sort') ? ' is-invalid' : '' }}" placeholder="Input sort">
                          </div>
            
                          @if ($errors->has('sort'))
                          <span class="text-sm">
                            <i class="fa fa-info-circle"></i> {{ $errors->first('sort') }}
                          </span>
                          @endif
            
                        </div>
                      </div>

                      <div class="form-group row {{ $errors->has('sort') ? ' text-red' : '' }}">
                        <label for="sort" class="col-sm-2 col-form-label">Ẩn menu</label>
                        <div class="col-sm-10 ">
                          @php
                              $hidden = $menu['hidden'] ?? 0;
                            @endphp
                          <div class="form-check">
                            <input type="checkbox" name="hidden" class="form-check-input" id="customCheck_show" value="1" {{ $hidden == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="customCheck_show">Ẩn menu</label>
                            <div class="invalid-feedback"> You must agree before submitting. </div>
                          </div>

          
            
                        </div>
                      </div>

                    </div>

                    <!-- /.card-body -->

                    <div class="card-footer row">
                            @csrf
                        <div class="col-md-2">
                        </div>

                        <div class="col-md-8 text-center">
                            <div class="btn-group">
                                <button type="reset" class="btn btn-warning">Reset</button>
                            </div>
                            <div class="btn-group">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>

                    <!-- /.card-footer -->

                      </form>

    </div>
  </div>
</div>

@endsection


@push('styles')
<!-- Ediable -->
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/plugins/nestable/jquery.nestable.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/plugins/iconpicker/fontawesome-iconpicker.min.css')}}">
@endpush

@push('scripts')
<!-- Ediable -->
<script src="{{ asset('assets/plugins/nestable/jquery.nestable.min.js')}}"></script>
<script src="{{ asset('assets/plugins/iconpicker/fontawesome-iconpicker.min.js')}}"></script>

<script type="text/javascript">
$('.remove_menu').click(function(event) {
  var id = $(this).data('id');
  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: 'btn btn-success',
      cancelButton: 'btn btn-danger'
    },
    buttonsStyling: true,
  })

  swalWithBootstrapButtons.fire({
    title: '{{ __('action.delete_confirm') }}',
    text: "",
    type: 'warning',
    showCancelButton: true,
    confirmButtonText: '{{ __('action.confirm_yes') }}',
    confirmButtonColor: "#DD6B55",
    cancelButtonText: '{{ __('action.confirm_no') }}',
    reverseButtons: true,

    preConfirm: function() {
        return new Promise(function(resolve) {
            $.ajax({
                method: 'post',
                url: '{{ $urlDeleteItem ?? '' }}',
                data: {
                  id:id,
                    _token: '{{ csrf_token() }}',
                },
                success: function (data) {
                    if(data.error == 1){
                      alertMsg('error', 'Cancelled', data.msg);
                      return;
                    }else{
                      alertMsg('success', 'Success');
                      window.location.replace('{{ route('admin_menu.index') }}');
                    }

                }
            });
        });
    }

  }).then((result) => {
    if (result.value) {
      alertMsg('success', '{{ __('action.delete_confirm_deleted_msg') }}', '{{ __('action.delete_confirm_deleted') }}');
    } else if (
      // Read more about handling dismissals
      result.dismiss === Swal.DismissReason.cancel
    ) {
      // swalWithBootstrapButtons.fire(
      //   'Cancelled',
      //   'Your imaginary file is safe :)',
      //   'error'
      // )
    }
  })

});


$('#menu-sort').nestable();
$('.menu-sort-save').click(function () {
    $('#loading').show();
    var serialize = $('#menu-sort').nestable('serialize');
    var menu = JSON.stringify(serialize);
    $.ajax({
      url: '{{ route('admin_menu.update_sort') }}',
      type: 'POST',
      dataType: 'json',
      data: {
        _token: '{{ csrf_token() }}',
        menu: menu
      },
    })
    .done(function(data) {
      $('#loading').hide();
      if(data.error == 0){
        location.reload();
      }else{
        alertMsg('error', data.msg, 'Cancelled');
      }
      //console.log(data);
    });
});


$(document).ready(function() {
    $('.active-item').parents('li').removeClass('dd-collapsed');
      //icon picker
    $('.icon').iconpicker({placement:'bottomLeft', animation: false});
});

</script>
@endpush