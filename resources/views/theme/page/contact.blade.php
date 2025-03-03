@extends($templatePath.'.layout')

@section('content')
@php
    $cover = $page->cover;
@endphp
   <div class="page-archive py-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center py-5">
            <h3 class="text-white animated slideInDown">{{ $page->name }}</h3>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a class="text-white" href="/">Trang chủ</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">{{ $page->name }}</li>
                </ol>
            </nav>
        </div>
    </div>


   <div class="container-xxl py-lg-5 py-4 page-contact">
      <div class="container">
         <div class="row g-4">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s" style="min-height: 450px">
               <div class="ratio ratio-1x1">
                  {!! htmlspecialchars_decode($page->content) !!}
               </div>
            </div>
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
               
               <h4>Nếu bạn có bất kỳ câu hỏi nào cho chúng tôi, vui lòng gửi cho chúng tôi bằng cách điền các thông tin bên dưới. </h4>
               <div class="mb-4">{!! htmlspecialchars_decode($page->description) !!}</div>
               <form method="POST" action="{{ route('contact.submit') }}" id="contact_form" class="position-relative">
                  @csrf()

                  <input type="hidden" name="url_back" value="{{ url()->current() }}">

                  @if(Session::has('message'))
                     <div class="mb-3 text-success">{{ Session::get('message') }}</div>
                  @endif
                  <div class="row g-3">
                     <div class="col-12">
                        <div class="form-floating">
                           <input type="text" class="form-control" id="name" name="contact[name]" placeholder="@lang('Your name')" required />
                           <label for="name">@lang('Your name') <span class="text-danger">*</span></label>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="form-floating">
                           <input type="email" class="form-control" id="email" name="contact[email]" placeholder="@lang('Email')" required />
                           <label for="email">@lang('Email') <span class="text-danger">*</span></label>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="form-floating">
                           <input type="text" class="form-control" id="phone" name="contact[phone]" placeholder="@lang('Phone')" required />
                           <label for="phone">@lang('Phone') <span class="text-danger">*</span></label>
                        </div>
                     </div>
                     
                     <div class="col-12">
                        <div class="form-floating">
                           <textarea class="form-control" placeholder="@lang('Message')" id="content" name="contact[message]" style="height: 150px"></textarea>
                           <label for="message">@lang('Message') <span class="text-danger">*</span></label>
                        </div>
                     </div>

                     <div class="col-12 mt-4">
                        <button class="btn btn-primary btn-custom py-3 px-5" type="submit"> @lang('Send message') </button>
                     </div>
                  </div>
                  <div class="list-content-loading">
                     <div class="half-circle-spinner">
                         <div class="circle circle-1"></div>
                         <div class="circle circle-2"></div>
                     </div>
                   </div>
               </form>
            </div>
         </div>
      </div>
   </div>

   @include('shortcode.keyword', ['menu'=>"Keyword-hot"])
    @include('shortcode.contact')
@endsection