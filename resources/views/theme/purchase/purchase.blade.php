@extends($templatePath .'.layout')

@section('seo')
   @include($templatePath .'.layouts.seo', $seo??[] )
@endsection

@section('content')
   <section class="package-page">
      <div class="package-top pb-4">
         <div class="package-content py-3">
            <div class="container">
               <div class="package-list">
                  @foreach($packages as $package)
                     <div class="package-item {{ $package->code }}">
                        <div class="img text-center">
                           <img src="{{ $package->cover }}" >
                        </div>
                        <div class="package-body">
                           <div class="item-head text-center mb-lg-4 mb-2"></div>
                           <div class="item-body">
                              <div class="package-title text-center">
                                 <span>{{ $package->name }}</span>
                              </div>
                              <div class="package-price">
                                 @if($package->promotion)
                                 <div class="text-big">{{ $package->promotion/1000 }}</div>
                                 @else
                                 <div class="text-big">{{ $package->price/1000 }}</div>
                                 @endif
                                 <div>
                                    <span>.000</span>
                                    <span>VNĐ</span>
                                 </div>
                              </div>
                              <div class="d-flex justify-content-center mt-lg-5 mt-3 package-info">
                                 <div>
                                    <div>Thời gian: <b>{{ $package->max_day }}</b> ngày</div>
                                    <div>Download: <b>{{ $package->download }}</b> lượt</div>
                                 </div>
                              </div>
                              <div class="package-action">
                                 <a href="{{ route('purchase.process', $package->id) }}" class="btn-main select-package" data="{{ $package->id }}">Mua ngay</a>
                              </div>
                           </div>
                        </div>
                     </div>
                  @endforeach
               </div>
            </div>
         </div>
      </div>
   </section>

@endsection

@push('after-footer')
@endpush