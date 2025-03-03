@php
    $states = \App\Model\Province::get();
@endphp

@extends($templatePath .'.layout')
@section('seo')
@include($templatePath .'.layouts.seo', $seo??[] )
@endsection


@section('content')
<section class="space-ptb mb-4">
  <div class="bg-white py-3 mb-3 ">
      <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
         <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb flex-lg-nowrap justify-content-center justify-content-lg-start">
                  <li class="breadcrumb-item"><a class="text-nowrap" href="index.html"><i class="ci-home"></i>Home</a></li>
                  <li class="breadcrumb-item text-nowrap"><a href="{{ route('research') }}">Tác giả</a></li>
               </ol>
            </nav>
         </div>
         <div class="order-lg-1 pe-lg-4 text-center text-lg-start">
            <h1 class="h3 mb-0">Tác giả</h1>
         </div>
      </div>
  </div>
   @if(!empty($page->description))
   <div class="container">
      {!! htmlspecialchars_decode($page->description) !!}
   </div>
   @endif
   <div class="container">
      <div class="row">
         <div class="col-lg-8 col-md-8 col-sm-12">
            <div class="row">
              @if(count($users)>0)
                  @foreach($users as $author)
                  <div class="col-lg-4 col-md-2 mb-4">
                     @include($templatePath .'.author.author-item')
                  </div>
                  @endforeach
                  <div class="col-12">
                     {!! $users->links() !!}
                  </div>
              @endif
            </div>
         </div>
         <div class="col-lg-4 col-md-4 col-sm-12">
            @include($templatePath . '.block.sidebar-home')
         </div>
      </div>
   </div>
</section>

@endsection

@push('after-footer')
<script src="{{ asset('theme/js/customer.js') }}"></script>
@endpush
