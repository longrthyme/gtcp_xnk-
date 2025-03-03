@php
    if(!empty($product))
    {
        $address = implodeAddress($product->getAddressFull()??'');
        $address_end = $product->address_end;
        
        $product_options = $product->getOptions($json_decode_text=false);
        if($product->date_available)
        $date_available = date('d/m/Y', strtotime($product->date_available));
    }


    $post_type = request('post_type')??$product->post_type??'';

@endphp

@extends($templatePath .'.layout')

@section('body_class', 'user-page')

@section('content')


{{--
<!--=================================
header -->

<!--=================================
breadcrumb -->
<div class="bg-light py-3">
   <div class="container">
      <div class="row">
         <div class="col-12">
            <ol class="breadcrumb mb-0">
               <li class="breadcrumb-item"><a href="{{ url('/') }}"> <i class="fas fa-home"></i> </a></li>
               <li class="breadcrumb-item active"><span>Đăng tin</span></li>
            </ol>
         </div>
      </div>
   </div>
</div>
<!--=================================
breadcrumb -->
--}}

<!--=================================
Submit Property -->
<section class="py-3 page-dangtin bg-light">
   <div class="container">
        <div class="block-item bg-white mb-3 p-3 rounded shadow-sm">
        @if(session()->has('category_selected'))
            @php
                $category_session = session('category_selected');

                $category_parents = $modelCategory->getParentList($category->parent);
                
                if($category_parents)
                {
                    $category_parents = array_reverse($category_parents);
                    $category_first = current($category_parents);
                }
                else
                {
                    $category_first = $category;   
                }
                $content = $content??'';

            @endphp

            <form class="position-relative" id="dangtinForm" method="POST" action="" enctype="multipart/form-data">
                <input type="hidden" name="category_first" value="{{ $category_first->id }}">
                <input type="hidden" name="category" value="{{ $category->id }}">
                <input type="hidden" name="id" value="{{ $product->id??0 }}">
                <div class="list-content-loading">
                   <div class="half-circle-spinner">
                       <div class="circle circle-1"></div>
                       <div class="circle circle-2"></div>
                   </div>
               </div>

                
                <div class="row g-3">
                    <div class="col-lg-4">
                        @include($templatePath .'.dangtin.upload_image')
                    </div>
                    <div class="col-lg-8 order-0 group-category">
                        <div class="form-group optionItem">
                            <div class="input-boder active" data-bs-toggle="modal" data-bs-target="#changeCategory">
                                <label>Danh mục tin đăng <span>*</span></label>
                                <div class="category-breadcrumb">
                                    <ul class="category_session" >
                                        @if($category_parents && count($category_parents))
                                            @foreach($category_parents as $item)
                                                <li>{{ $item->name??'' }}</li>
                                            @endforeach
                                        @endif
                                        <li>{{ $category->name }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        @if($category_first)
                            @php
                                $templatePath_1 = $templatePath .'.dangtin.category.' . $category_first->slug . '.' . $category->slug;
                                $templatePath_2 = $templatePath .'.dangtin.category.' . $category_first->slug;

                            @endphp

                            @if(\View::exists($templatePath_1))
                                @include($templatePath_1)
                            @elseif(\View::exists($templatePath_2))
                                @include($templatePath_2)
                            @endif

                            {{--
                            @if($category_first->id == 13)
                                @include($templatePath .'.dangtin.category.hang-hoa-xnk')
                            @elseif($category_first->id == 18)
                                @include($templatePath .'.dangtin.category.van-chuyen')
                            @elseif($category_first->id == 22)
                                @include($templatePath .'.dangtin.category.dich-vu-khac')
                            @elseif($category_first->id == 23)
                                @include($templatePath .'.dangtin.category.kho-bai')
                            @elseif($category_first->id == 38)
                                @include($templatePath .'.dangtin.category.thiet-bi')
                            @elseif($category_first->id == 7)
                                @include($templatePath .'.dangtin.category.tuyen-dung')
                            @endif
                            --}}
                        @endif

                        <div class="col-12 text-center dangtin-btn-action mt-3">
                            <div class="error-message"></div>
                            <button type="button" class="btn dangtin-process"><i class="fas fa-plus-circle"></i> Đăng tin</button>
                        </div>
                    </div>
                </div>

                
            </form>
        @else

            
            <div class="text-center">
                <h2 class="text-center my-4 text-uppercase">@lang('Đăng tin')</h2>
                <img data-testid="test-image" src="{{ asset('images/empty-category.svg') }}" alt="Đăng tin cho tặng">
                    <h4 class="test-title">Đăng tin</h4>
                    <p data-testid="test-description">Chọn “danh mục tin đăng” để đăng tin</p>
            </div>
        @endif
        </div>


      <div class="dangtin_status"></div>
      
   </div>
</section>
    
    <div class="modal fade" id="changeCategory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="category-back" style="display: none;"><i class="fa fa-long-arrow-left"></i></span>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <h5 class="modal-title" id="exampleModalLabel">Chọn danh mục tin đăng</h5>
                </div>
                <div class="modal-body">
                    @include($templatePath .'.dangtin.includes.category')
                </div>
            </div>
        </div>
    </div>
<!--=================================
Submit Property -->
@endsection

@push('head-style')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link type="text/css" rel="stylesheet" href="{{ asset($templateFile .'/plugins/upload-image-js/image-uploader.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset($templateFile .'/css/dangtin.css?ver='. time()) }}">
@endpush
@push('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="{{ asset($templateFile .'/plugins/upload-image-js/image-uploader.min.js') }}"></script>
    <script src="{{ asset($templateFile .'/js/jquery.MultiFile.js') }}"></script>
    <script src="{{ asset($templateFile .'/js/dangtin.js?ver='. time()) }}" type="text/javascript"></script>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            @if(!session()->has('category_selected'))
               $('#changeCategory').modal('show');
            @endif
            
            var preloaded = '';
            @if(!empty($product) && $product->gallery)
            preloaded = [
                @if($product->getGallery())
                    @foreach($product->getGallery() as $index => $gallery)
                        {id: '{{ $index }}', src: '{{ $gallery }}'},
                    @endforeach
                @endif
            ];
            @endif

            $('.upload-images').imageUploader({
                label:'',
                preloaded:preloaded,
                imagesInputName: 'gallery',
                preloadedInputName: 'gallery_old'
            });

            if($('.post_type').length)
            {
                $('.form-content').addClass('d-none');
                $('.dangtin-btn-action').addClass('d-none');
                @if($post_type != '')
                    $('.form-content').removeClass('d-none');
                    $('.dangtin-btn-action').removeClass('d-none');
                @endif

                $('.post_type').on('change', function(){
                    window.location.href = '{{ url()->current() }}?post_type='+ $(this).val();
                });
            }

            $(document).on('click', '.file-remove', function(){
              var title = $(this).parent().find('.file-title').text(),
                index = $(this).attr('data');
              $(this).closest('.file-item').remove();
              $('.file-list').append('<input type="hidden" name="gallery_remove['+ index +']" class="form-control" value="'+ title +'">')

              return false;
            });
        });
   </script>
@endpush