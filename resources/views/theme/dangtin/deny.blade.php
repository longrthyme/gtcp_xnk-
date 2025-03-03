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
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="block-item bg-white rounded shadow-sm text-center py-5 my-5">
                    <p>Tài khoản của bạn không thể đăng tin</p>
                    <p>Quay về <a href="/" title=""><i class="fa-solid fa-house"></i> Trang chủ</a></p>
                </div>
            </div>
        </div>
   </div>
</section>
<!--=================================
Submit Property -->
@endsection

@push('head-style')
@endpush
@push('scripts')
    
@endpush