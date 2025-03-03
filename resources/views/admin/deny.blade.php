@extends('admin.layouts.index')

@section('content')
  <div class="card">
    <div class="card-body" id="pjax-container">
          <div class="box-body">
            <div class="error-page text-center">
                <h2 class="text-red">403 - {{ __('admin.deny_content') }}</h2>
                @if ($url)
                <span><h4><i class="fa fa-warning text-red" aria-hidden="true"></i> {{ __('admin.deny_msg') }}</h4></span>
                <span><strong>URL:</strong> <code>{{ $url }}</code> - <strong>Method:</strong> <code>{{ $method }}</code></span>
                @endif
            </div>
        </div>
      </div>
  </div>
@endsection


@push('styles')
@endpush

@push('scripts')
@if ($url)
<script>
  window.history.pushState("", "", '{{ $url }}');
</script>
@endif
@endpush
