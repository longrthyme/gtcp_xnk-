@php
   $category_current = '';
   if(isset($product)){
      if($product->getInfo)
         extract($product->getInfo->toArray());
      extract($product->toArray());


      $gallery = (isset($gallery) && $gallery != "") ? unserialize($gallery) : '';

      foreach($product->categories as $category){
         if($category->categoryParent == 0)
            $category_parent = $category->categorySlug;
         else
            $category_current = $category->categorySlug;
      }
   }
@endphp

@extends($templatePath .'.layout')

@section('body_class', 'user-page')

@section('content')


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
               <li class="breadcrumb-item active"><span>Đăng tin dịch vụ</span></li>
            </ol>
         </div>
      </div>
   </div>
</div>
<!--=================================
breadcrumb -->

<!--=================================
Submit Property -->
<section class="py-3 page-dangtin bg-light">
   <div class="container">
      <h2 class="text-center mb-4 text-uppercase">@lang('Đăng tin dịch vụ')</h2>      
         
      <form class="position-relative" id="dangtinServiceForm" method="POST" action="">
         <div class="row justify-content-center">
            <div class="col-lg-9">
               <input type="hidden" name="id" value="{{ $id ?? '' }}">
               <div class="list-content-loading">
                   <div class="half-circle-spinner">
                       <div class="circle circle-1"></div>
                       <div class="circle circle-2"></div>
                   </div>
               </div>
               {{ csrf_field() }}

               <div class="block-item bg-white mb-3 p-3 rounded shadow-sm">
                  <div class="mb-3">
                     <h3>@lang('Tuyến')</h3>
                  </div>

                  <div class="row">
                     <div class="col-lg-6 mb-3">
                        <label class="form-label">Nơi đi (*)</label>
                        <input type="text" class="form-control" name="origin_port" id="origin_port" value="{{ $origin_port ?? '' }}" placeholder="Nhập Nơi đi">
                     </div>
                     <div class="col-lg-6 mb-3">
                        <label class="form-label">Nơi đến (*)</label>
                        <input type="text" class="form-control" name="destination_port" id="destination_port" value="{{ $destination_port ?? '' }}" placeholder="Nhập Nơi đến">
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-lg-6 mb-3 select-border category-select">
                        <label class="form-label">Điều kiện giao hàng (*)</label>
                        <select class="form-control basic-select" id="origin_term" name="origin_term">
                           <option value="">Chọn</option>
                           <option value="20">CY</option><option value="95">Door</option><option value="139">CFS</option>
                        </select>
                     </div>
                     <div class="col-lg-6 mb-3 select-border category-select">
                        <label class="form-label">Điều kiện nhận hàng (*)</label>
                        <select class="form-control basic-select" id="destination_term" name="destination_term">
                           <option value="">Chọn</option>
                           <option value="20">CY</option><option value="95">Door</option><option value="139">CFS</option>
                        </select>
                     </div>

                  </div>

                  <div class="mb-3">
                     <label class="form-label">Thời gian vận chuyển (Ngày) (*)</label>
                     <input type="text" class="form-control" name="transit_time" id="transit_time" value="{{ $transit_time ?? '' }}" placeholder="Thời gian vận chuyển (Ngày)">
                  </div>
                  
               </div>

               <div class="block-item bg-white mb-3 p-3 rounded shadow-sm">
                  <div class="mb-3">
                     <label class="form-label">Mức giá ∙ VND *</label>
                     <div class="price-change dropdown ">
                        <input type="text" class="form-control" id="price-main" name="price" value="{{ isset($price) ? number_format($price) : 0 }}" placeholder="Nhập mức giá" autocomplete="off">
                        <div class="form-check">
                           <input class="form-check-input" type="checkbox" value="1" name="price_type" id="price_type" {{ isset($price_type) && $price_type == 1 ? 'checked' : '' }}>
                           <label class="form-check-label" for="price_type">Giá / m²</label>
                        </div>
                     </div>
                  </div>
                  <div class="mb-3">
                     <label class="form-label">Loại container</label>
                     <select class=" form-select" class="container"> 
                        <option value="20'GP">20'GP</option>
                        <option value="40'GP">40'GP</option>
                        <option value="40'HQ">40'HQ</option>
                        <option value="45'HQ">45'HQ</option>
                     </select>
                  </div>
                  <div class="mb-3 select-border category-select">
                     <label class="form-label">Hãng vận chuyển (*)</label>
                     <select id="carrier_transit" name="carrier_transit" class="form-control basic-select">
                        <option value="">Chọn Hãng vận chuyển</option>
                        <option value="79">AMASIS SHIPPING</option>
                        <option value="1">APL</option>
                        <option value="77">ASEAN SEAS LINE (ASL)</option>
                        <option value="69">ATLANTIC</option>
                        <option value="68">BIEN DONG</option>
                        <option value="76">CK LINE</option>
                        <option value="2">CMA-CGM</option>
                        <option value="27">CNC</option>
                        <option value="3">COSCO</option>
                        <option value="31">CSAV</option>
                        <option value="75">CULINES</option>
                        <option value="35">DONGJIN</option>
                        <option value="30">EMIRATES</option>
                        <option value="4">EVERGREEN</option>
                        <option value="64">GEMADEPT</option>
                        <option value="73">GLS</option>
                        <option value="66">HAI AN</option>
                        <option value="28">HAMBURG SUD</option>
                        <option value="5">HAPAG-LLOYD</option>
                        <option value="6">HEUNG-A</option>
                        <option value="26">HUBLINE</option>
                        <option value="7">HYUNDAI</option>
                        <option value="24">INTERASIA</option>
                        <option value="32">IRISL</option>
                        <option value="9">KMTC</option>
                        <option value="10">MAERSK LINE</option>
                        <option value="11">MCC</option>
                        <option value="12">MSC</option>
                        <option value="13">NAMSUNG</option>
                        <option value="8">ONE</option>
                        <option value="14">OOCL</option>
                        <option value="36">Others</option>
                        <option value="74">PACIFIC LINES</option>
                        <option value="78">PAN OCEAN</option>
                        <option value="15">PIL</option>
                        <option value="16">RCL</option>
                        <option value="25">SAFMARINE</option>
                        <option value="17">SAMUDERA</option>
                        <option value="18">SINOKOR</option>
                        <option value="19">SINOTRANS</option>
                        <option value="20">SITC</option>
                        <option value="33">SM LINE</option>
                        <option value="34">SWIRE</option>
                        <option value="70">TAN CANG SHIPPING</option>
                        <option value="21">TS LINE</option>
                        <option value="67">VINAFCO</option>
                        <option value="71">VINALINES</option>
                        <option value="72">VOSCO</option>
                        <option value="65">VSICO</option>
                        <option value="22">WANHAI</option>
                        <option value="29">YANG MING</option>
                        <option value="23">ZIM</option>
                        <option value="80">ZIM HAI AN</option>
                      </select>
                  </div>

                  <div class="row">
                     <div class="col-lg-6 mb-3">
                        <label class="form-label">Ngày bắt đầu (*)</label>
                        <input type="text" class="form-control" name="date_start" id="date_start" value="{{ $date_start ?? '' }}" placeholder="Ngày bắt đầu (*)">
                     </div>
                     <div class="col-lg-6 mb-3">
                        <label class="form-label">Ngày đến (*)</label>
                        <input type="text" class="form-control" name="date_end" id="date_end" value="{{ $date_end ?? '' }}" placeholder="Ngày đến (*)">
                     </div>
                  </div>
               </div>

               <div class="block-item bg-white mb-3 p-3 rounded shadow-sm">
                  <div class="row mt-4">
                     <h4>Thông tin liên hệ</h4>
                     <div class="mb-3 col-lg-6">
                        <label class="form-label">Tên công ty *</label>
                        <input type="text" class="form-control" name="contact[name]" id="contact_name" value="{{ $user_company->name }}" readonly disabled>
                     </div>
                     <div class="mb-3 col-lg-6">
                        <label class="form-label">@lang('Địa chỉ')</label>
                        <input type="text" class="form-control" name="contact[address]" id="contact_address" value="{{ $user_company->address }}" readonly disabled>
                     </div>

                     <div class="mb-3 col-lg-6">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control" name="contact[email]" id="contact_email" value="{{ $user_company->email }}" readonly disabled>
                     </div>
                     <div class="mb-3 col-lg-6">
                        <label class="form-label">Số điện thoại *</label>
                        <input type="text" class="form-control" name="contact[phone]" id="contact_phone" value="{{ $user_company->phone }}" readonly disabled>
                     </div>
                  </div>
               </div>
                     
               <div class="text-center dangtin-btn-action">
                  <button type="button" class="btn btn-primary dangtin-process"><i class="fas fa-plus-circle"></i> Đăng tin</button>
               </div>
            </div>
         </div>
      </form>
      <div class="dangtin_status"></div>
      
   </div>
</section>
<!--=================================
Submit Property -->
@endsection

@push('head-style')
   <link rel="stylesheet" type="text/css" href="{{ asset('/assets/plugins/select2/css/select2.css') }}">
   <link rel="stylesheet" type="text/css" href="{{ asset($templateFile .'/css/dangtin.css') }}">
@endpush
@push('scripts')
   <script src="{{ asset($templateFile .'/js/dangtin.js') }}" type="text/javascript"></script>
@endpush