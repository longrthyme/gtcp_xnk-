@extends($templatePath .'.layouts.index')

@section('content')
<section class="space-ptb bg-holder my-5">
  <div class="container">
    <div class="row justify-content-center align-items-center">
      <div class="col-md-6">
        <div class="error-404 text-center">
          <h1>404</h1>
          <strong>Trang bạn tìm kiếm không tồn tại</strong>
          <span>Quay về <a href="{{ url('/') }}"> Trang chủ </a></span>
        </div>
      </div>
    </div>
  </div>
</section>
<!--=================================
error -->
@endsection
