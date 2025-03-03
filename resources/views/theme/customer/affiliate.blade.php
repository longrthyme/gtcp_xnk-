@php
    $states = \App\Models\LocationProvince::get();
    $countries = \App\Models\LocationCountry::get();
@endphp

@extends($templatePath .'.layout')
@section('seo')
@include($templatePath .'.layouts.seo', $seo??[] )
@endsection


@section('content')

    <section class="my-post">
        <div class="container my-lg-4 my-3">
            <div class="row">
                <div class="col-lg-3  col-12 mb-4">
                    @include($templatePath .'.customer.includes.sidebar-customer')
                </div>
                <div class="col-lg-9">
                    <h5 class="text-center">Tiếp thị liên kết</h5>
                    <div class="invite-box mb-3">
                        <div>
                            <span>Mã giới thiệu</span>
                            <span>{{ $user->getCodeInvite() }} <span data="{{ $user->getCodeInvite() }}" class="copy"></span></span>
                        </div>
                        <div class="mb-0">
                            <span>Liên kết giới thiệu</span>
                            <span><span>{{ $user->getUrlInvite() }}</span> <span data="{{ $user->getUrlInvite() }}" class="copy"></span></span>
                        </div>
                        {{--<a href="{{ $user->getUrlInvite() }}" title="">Mời bạn bè</a>--}}
                    </div>

                    <div class="account-invited">
                        <h5 class="text-center">Danh sách thành viên đã mời</h5>
                        <div class="table-responsive">
                            <table class="table table-striped tablefilter">
                                <thead>
                                    <tr>
                                        <th width="100" class="text-center">STT</th>
                                        {{--
                                        <th class="text-nowrap">Họ tên</th>
                                        <th class="text-nowrap">Ngày sinh</th>
                                        <th >CCCD</th>
                                        --}}
                                        <th class="text-nowrap">Tài khoản</th>
                                        <th >Email </th>
                                        <th class="text-nowrap">Số đt</th>
                                        <th>Loại tài khoản</th>
                                        <th>Ngày đăng ký</th>
                                        <th>Ngày kích hoạt</th>
                                        <th>Số tiền</th>
                                        <th>Tiền hoa hồng</th>
                                        <th width="250">Ngày tham gia</th>
                                        <th width="150">Trạng thái</th>
                                    </tr>   
                                </thead>
                                <tbody>
                                    @foreach($user_invited as $key => $account)
                                        @php
                                            $payment = $account->getPackagePayment();
                                            $upgrade = $account->getUpgrade();
                                        @endphp
                                        <tr>
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            {{--
                                            <td>{{ $account->fullname }}</td>
                                            <td>{{ $account->birthday }}</td>

                                            <td>{{ $account->cccd }}</td>
                                            --}}
                                            <td>{{ $account->username }}</td>
                                            <td>{{ $account->email }}</td>
                                            <td>{{ $account->phone }}</td>
                                            <td>{{ $account->getPackage->name??'' }}</td>
                                            <td>
                                                @if($payment)
                                                    {{ date('d/m/Y', strtotime($payment->created_at)) }}
                                                @endif
                                            </td>
                                            <td>
                                                @if($payment && $payment->status == 1)
                                                    {{ date('d/m/Y', strtotime($payment->updated_at)) }}
                                                @endif
                                            </td>
                                            <td>
                                                @if($payment && $payment->status == 1)
                                                    {!! render_price( $payment->amount ) !!}
                                                @endif
                                            </td>
                                            <td>
                                                @if($upgrade && $upgrade->amount_affiliate)
                                                    {!! render_price( $upgrade->amount_affiliate ) !!}
                                                @endif
                                            </td>

                                            <td class="text-nowrap">{{ $account->created_at }}</td>
                                            <td >
                                                @if(is_null($account->email_verified_at))
                                                    <span class="badge bg-danger">Chưa xác thực</span>
                                                @else
                                                    @if($account->status == 0)
                                                    <span class="badge bg-danger">Ngưng hoạt động</span>
                                                    @else
                                                    <span class="badge bg-success">Hoạt động</span>
                                                    @endif
                                                @endif
                                            </td>   
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('head-style')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link type="text/css" rel="stylesheet" href="{{ asset($templateFile .'/plugins/upload-image-js/image-uploader.min.css') }}">
    
    <link rel="stylesheet" type="text/css" href="{{ asset($templateFile .'/css/dangtin.css?ver='. time()) }}">
    <link rel="stylesheet" href="{{ asset($templateFile .'/plugins/crop-image/dropzone.css') }}" />
    <link href="{{ asset($templateFile .'/plugins/crop-image/cropper.css') }}" rel="stylesheet"/>
@endpush

@push('after-footer')
<script src="{{ asset($templateFile .'/plugins/crop-image/cropper.js') }}"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="{{ asset($templateFile .'/plugins/upload-image-js/image-uploader.min.js') }}"></script>
    <script src="{{ asset($templateFile .'/js/jquery.MultiFile.js') }}"></script>
    <script src="{{ asset($templateFile .'/js/dangtin.js?ver='. time()) }}" type="text/javascript"></script>

    <script>

    </script>
@endpush
