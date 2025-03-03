@php
   $product_count = $user->posts()->count();
   $options = $user->getOptions();
   //dd($options);
   
@endphp
<div class="bg-white rounded-3 shadow-lg pt-1 mb-5 mb-lg-0">
   <div class="d-md-flex justify-content-between align-items-center text-center text-md-start p-4">
      <div class="d-md-flex align-items-center">
         <div>
            <h3 class="fs-5 mb-3">{{ $user->company }}</h3>
            <div class="author-vote">
               @include($templatePath .'.author.author-vote')
            </div>
            @if($user->getOption(100))
            <p>Người liên hệ: {{ $options[100] }}</p>
            <p>Chức vụ: {{ $options[101] }}</p>
            @endif
            {{--<span class="text-accent text-inline fs-sm">{{ $user->email }}</span>--}}


         </div>
      </div>
      <!-- <a class="btn btn-primary d-lg-none mb-2 mt-3 mt-md-0" href="#account-menu" data-bs-toggle="collapse" aria-expanded="false"><i class="ci-menu me-2"></i>Account menu</a> -->

   </div>
   <div class="d-lg-block collapse" id="account-menu">
      <div class="border-top border-bottom p-3">
         <ul class="user-profile mb-3">
            <li class="d-flex">
               <div class=""><i class="fa fa-home"></i></div>
               <div class="ms-2">{{ $user->address }}</div>
            </li>
            <li class="d-flex">
               <div class=""><i class="fa fa-globe"></i></div>
               <div class="ms-2">{{ $user->email }}</div>
            </li>
            <li class="d-flex">
               <div class=""><i class="fa-solid fa-phone"></i></div>
               <div class="ms-2">{{ $user->phone }}</div>
            </li>
         </ul>

         <h3 class="fs-sm mb-2 text-muted">Giới thiệu</h3>
         <ul class="user-profile mb-3">
            @if(!empty($options[88]))
               <li>Sản phẩm/dịch vụ chính: <b>{{ $options[88] }}</b></li>
            @endif
            @if(!empty($options[89]))
               <li>Thị trường chính: <b>{{ $options[89] }}</b></li>
            @endif
            @if(!empty($options[66]))
               <li>Lĩnh vực kinh doanh chính: <b>{{ $options[66] }}</b></li>
            @endif
            @if(!empty($options[104]))
               <li>Các tuyến vận chuyển chính: <b>{{ $options[104] }}</b></li>
            @endif
            @if(!empty($options[74]))
               <li>Quy mô nhân sự: <b>{{ $options[74] }} người</b></li>
            @endif
            @if(!empty($options[75]))
               <li>Chứng chỉ/Chứng nhận: <b>{{ $options[75] }}</b></li>
            @endif
         </ul>
         
         <div class="fs-sm mb-3">
            {!! htmlspecialchars_decode($user->about_me) !!}
         </div>
         
      </div>
      
   
   </div>
</div>