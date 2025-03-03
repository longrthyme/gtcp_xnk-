@extends($templatePath .'.layout')

@section('seo')
@include($templatePath .'.layouts.seo', $seo??[])
@endsection

@section('content')
<div class="content_group_offer_view py-5 text-center">
    <p><img src="{{ asset('assets/images/circle-icon.png') }}" width="120" alt=""></p>
    <p>Đăng ký tác giả của bạn đã thành công</p>
    <p>Bạn sẽ được thông báo về tình trạng đăng ký của mình qua e-mail</p>
    <p>Quay về <a href="{{url('/')}}" style="color: rgb(255 153 51);">Trang chủ</a></p>
</div>
@endsection