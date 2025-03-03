@php
    $states = \App\Model\Province::get();
@endphp

@extends($templatePath .'.layout')
@section('seo')
@include($templatePath .'.layouts.seo', $seo??[] )
@endsection


@section('content')
@php
   $document_count = $user->document()->count();
@endphp
<div class="banner-author">
   @if($user->cover)
      <img src="{{ $user->cover }}" class="w-100" alt="">
   @else
      <img src="{{ asset('images/banner-author-demo.jpg') }}" class="w-100" alt="">
   @endif
</div>
<!-- Dashboard header-->
<div class="container mb-5">
   <div class="header-author">
      <div class="avatar">
         <img src="{{ $user->avatar??'/upload/images/general/author.png' }}" alt="{{ $user->fullname }}">
      </div>
      <div class="header-info">
         <h3 class="text-light mb-4">{{ $user->fullname }}</h3>

         <div class="info-list">
            @if($user->job)
            <div class="info-item mb-3">
               <h5>Nghề Nghiệp</h5>
               <p>{{ $user->job }}</p>
            </div>
            @endif
            @if($user->edu)
            <div class="info-item mb-3">
               <h5>Chuyên môn</h5>
               <p>{{ $user->edu }}</p>
            </div>
            @endif
            @if($document_count)
            <div class="info-item mb-3">
               <h5>Tác phẩm tài liệu</h5>
               <p>{{ $document_count }}</p>
            </div>
            @endif
            @if($user->reward)
            <div class="info-item mb-3">
               <h5>Giải thưởng</h5>
               <p>{{ $user->reward }}</p>
            </div>
            @endif
         </div>
      </div>
   </div>
</div>

<section class="container ">
   <div class="row mb-5">
      <div class="col-lg-5">
         <div class="page-author-title">
            <h3>Giới thiệu thành viên</h3>
         </div>
         <div>
            {!! htmlspecialchars_decode($user->about_me) !!}
         </div>
      </div>
      <div class="col-lg-7">
         <div class="page-author-title">
            <h3>Truyền thông nói về thành viên</h3>
         </div>
         {!! htmlspecialchars_decode($user->content) !!}
      </div>
   </div>

   <div class="author-posts mb-5">
      <div class="page-author-title">
         <h3>Tài liệu</h3>
      </div>
      @if($posts->count())
         <div class="row mx-n2">
            @foreach($posts as $post)
               <div class="col-lg-3 col-md-4 col-6 px-2 mb-3">
                  @if($post->document_type == 'download')
                     @include($templatePath .'.document.document-item')
                  @else
                     @php
                        $category = $post->categories()->where('document_category.category_id', '<>', 0)->latest()->first();
                     @endphp
                     @include($templatePath .'.research.research-item')
                  @endif
               </div>
            @endforeach
         </div>
         <div>
            {!! $posts->links() !!}
         </div>
      @else
         <p>Tác giả chưa có tài liệu được đăng</p>
      @endif
   </div>
</section>
@endsection

@push('after-footer')
<script src="{{ asset('theme/js/customer.js') }}"></script>
@endpush
