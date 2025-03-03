@php
    $states = \App\Models\LocationProvince::get();
    $countries = \App\Models\LocationCountry::get();
@endphp

@extends($templatePath .'.layout')
@section('seo')
@include($templatePath .'.layouts.seo', $seo??[] )
@endsection


@section('content')
    <div class="page-archive py-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center py-5">
            <h3 class="text-white animated slideInDown">Profile</h3>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a class="text-white" href="/">Trang chủ</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">Profile</li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="my-post">
        <div class="container my-lg-4 my-3">
            <div class="row">
                <div class="col-lg-3  col-12 mb-4">
                    @include($templatePath .'.customer.includes.sidebar-customer')
                </div>
                <div class="col-lg-9">

                    
                    @include($templatePath . '.customer.includes.form_invite')
                    
                    <form method="POST" action="">
                        @csrf
                        <div class="text-center my-5">
                             <h2 class="animated slideInDown">Thông tin</h2>
                        </div>

                        <div class="row g-3">
                            <div class="col-lg-12 optionItem">
                                <div class="input-boder {{ $user->company!='' ? 'active' : '' }}">
                                    <label>Loại Tài khoản</label>
                                    <input type="text" class="form-control input-value" value="{{ $user->getType->name }}" disabled>
                                </div>
                            </div>
                            @if($user->getRole)
                            <div class="col-lg-12 optionItem">
                                <div class="input-boder {{ $user->company!='' ? 'active' : '' }}">
                                    <label>Vai trò</label>
                                    <input type="text" class="form-control input-value" value="{{ $user->getRole->name }}" disabled>
                                </div>
                            </div>
                            @endif
                            @if($user->getRole)
                                @includeIf($templatePath .'.customer.type.'. $user->getRole->slug??'unknow')
                            @elseif($user->getType)
                                @includeIf($templatePath .'.customer.type.'. $user->getType->slug??'unknow')
                            @endif


                            <div class="col-lg-12">
                              <div class="input-textarea {{ $user->about_me?'active':'' }}">
                                 <label class="mb-1">Giới thiệu công ty</label>
                                 <textarea rows="5" name="about_me" class="form-control content-limit" data-limit="1500">{!! isset($user->about_me) ? str_replace('<br />', "\n", $user->about_me) : '' !!}</textarea>
                              </div>
                              <div class="px-2 check-text check-text-content"><span>0</span>/1500 ký tự</div>

                           </div>

                            {{--Người liên hệ--}}
                            <div class="col-lg-6">
                                @include($templatePath .'.dangtin.includes.option', ['id' => 100, 'value' => $user->getOption(100)])
                            </div>
                            {{--Chức vụ--}}
                            <div class="col-lg-6">
                                @include($templatePath .'.dangtin.includes.option', ['id' => 101, 'value' => $user->getOption(101)])
                            </div>
                            {{--Số điện thoại--}}
                            <div class="col-lg-6">
                                @include($templatePath .'.dangtin.includes.option', ['id' => 102, 'value' => $user->getOption(102)])
                            </div>
                            {{--Email liên hệ--}}
                            <div class="col-lg-6">
                                @include($templatePath .'.dangtin.includes.option', ['id' => 103, 'value' => $user->getOption(103)])
                            </div>


                            {{--
                            <!-- <div class="col-lg-6 optionItem">
                                <div class="input-boder {{ $user->email!='' ? 'active' : '' }}">
                                    <label>Số lượng</label>
                                    <input type="text" class="form-control" name="email" value="{{ $user->email??'' }}">
                                </div>
                            </div> -->
                            --}}

                            <div class="col-12 text-center dangtin-btn-action mt-3">
                                <button type="submit" class="btn dangtin-process">Cập nhật</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cắt ảnh</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="img-container">
                        <div class="row">
                            <div class="col-md-8">
                                <img src="" id="sample_image" />
                            </div>
                            <div class="col-md-4">
                                <div class="preview"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="crop" class="btn btn-primary">Hoàn tất</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                </div>
            </div>
        </div>
    </div> 
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
    <script src="{{ asset('js/customer.js?ver='. time()) }}" type="text/javascript"></script>

    <script>

    $(document).ready(function(){
        

        var $modal = $('#modal');

        var image = document.getElementById('sample_image');

        var cropper;

        $('#upload_image').change(function(event){
            var files = event.target.files;

            var done = function(url){
                image.src = url;
                $modal.modal('show');
            };

            if(files && files.length > 0)
            {
                reader = new FileReader();
                reader.onload = function(event)
                {
                    done(reader.result);
                };
                reader.readAsDataURL(files[0]);
            }
        });

        $modal.on('shown.bs.modal', function() {
            cropper = new Cropper(image, {
                aspectRatio: 1,
                viewMode: 3,
                preview:'.preview'
            });
        }).on('hidden.bs.modal', function(){
            cropper.destroy();
            cropper = null;
        });

        $('#crop').click(function(){
            canvas = cropper.getCroppedCanvas({
                width:400,
                height:400
            });

            canvas.toBlob(function(blob){
                url = URL.createObjectURL(blob);
                var reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function(){
                    var base64data = reader.result;
                    axios({
                        method: 'post',
                        url: '{{ sc_route("customer.edit_avatar") }}',
                        data: {image:base64data}
                    }).then(res => {
                        if(!res.data.error)
                        {
                            $modal.modal('hide');
                            if(res.data.avatar != ''){
                                $('#uploaded_image').attr('src', res.data.avatar);
                                $('.msg').show().text('Thay avatar thành công');
                            }

                        }
                    }).catch(e => console.log(e));

                };
            });
        });
        
    });
    </script>
@endpush
