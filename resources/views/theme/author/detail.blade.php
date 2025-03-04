
@extends($templatePath .'.layout')
@section('seo')
@include($templatePath .'.layouts.seo', $seo??[] )
@endsection


@section('content')

<!-- Page Title-->
<div class="page-title-overlap bg-gray pt-1" style="background: #d9d9d9;">
   <div class="container d-lg-flex justify-content-between py-2 py-lg-3">

   </div>
</div>
<!-- Page content-->
<section class="container mb-4">
   <div class="row mb-3">
      <div class="col-lg-3">
         <div class="mt-lg-2">
            <div class="vendor-img m-auto">
               <img class="m-auto rounded-circle border border-3 d-lg-block d-none" src="{{ $user->avatar??'/images/user-none.jpg' }}" width="140" alt="Avatar">
            </div>
         </div>
      </div>
   </div>
   <div class="row g-3">
      <!-- Sidebar-->
      <aside class="col-lg-3">
         @include($templatePath .'.author.sidebar')
      </aside>
      <!-- Content-->
      <div class="col-lg-9">
         @if(!empty($page->description))
            {!! htmlspecialchars_decode($page->description) !!}
         @endif

         @include('shortcode.product', ['category_id' => 13, 'product_home' => '', 'author' => $user->id, 'col'=>'4'])
         @include('shortcode.van-chuyen', ['author' => $user->id])

         {{--
         @if($posts->count())
            <div class="row mx-n2">
               @foreach($posts as $product)
                  @if(!empty($product->post_type) && $product->post_type != 'xnk')
                  <div class="col-lg-3 col-md-4 col-6 px-2 mb-3">
                        @include($templatePath .'.product.product_item')
                  </div>
                  @endif
               @endforeach
            </div>
            
            @php
                $category_child = $modelCategory->getList(['parent' => 18, 'post_type' => ['van-chuyen'], 'user_id' => $user->id]);
                $category = $modelCategory->getDetail(18);
            @endphp

            <div class="block-service">
            <div class="img_bg"></div>
                <div class="container">
                    <div class="freight-services">
                        @foreach($category_child as $item)
                            @php
                                $products = $modelProduct->setCategory($item->id)->getList(['limit' => 10]);
                            @endphp
                            @if($products->count())
                                <div class="title-freight">
                                    <h4>Chào giá vận chuyển {{ $item->name }}</h4>
                                </div>
                                @if(\View::exists($templatePath .".product.". $category->slug .".". $item->slug))
                                    @include($templatePath .".product.". $category->slug .".". $item->slug)
                                @elseif(\View::exists($templatePath .".product.". $category->slug .".product-list"))
                                    @include($templatePath .".product.". $category->slug .".product-list")
                                @endif
                            @endif
                        @endforeach
                    </div>
                    
                </div>
            </div>
         @else
            <p class="text-center">Cửa hàng chưa có sản phẩm được đăng</p>
         @endif
         --}}
      </div>
   </div>
</section>
@endsection

@push('styles')
   <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
@endpush
@push('scripts')
   <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
   <script src="https//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
   <script>
      jQuery(document).ready(function($) {
         $('.tablefilter').DataTable({
           'aoColumnDefs': [{
               'bSortable': false,
               'aTargets': ['action', 'nosort']
           }],
           "order": [], 
           "aaSorting": [], 
           'searching': false, 
           'lengthChange': false, 
           "paging": false, 
           "info": false, 
           "decimal": ",", 
           "thousands": ".",
       });
      });
   </script>   
@endpush
