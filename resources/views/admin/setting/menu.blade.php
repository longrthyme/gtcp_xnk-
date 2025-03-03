@extends('admin.layouts.index')
@section('seo')
@include('admin.layouts.seo', [
  'title' => 'Setting Menu',
])
@endsection
@section('content')
<div class="container py-3">
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Menu</h3>
  </div> <!-- /.card-header -->
  <div class="card-body">
  {!! Menu::render() !!}
</div> <!-- /.card-body -->
</div><!-- /.card -->
</div>

@endsection

@push('scripts')
@include('vendor.wmenu.scripts')
@endpush
