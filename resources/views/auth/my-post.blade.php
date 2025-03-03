@php
    if($lc == 'en'){ $lk = ''; } else { $lk = $lc; }
    $agent = new  Jenssegers\Agent\Agent();
@endphp

@extends($templatePath .'.layouts.index')


@section('body_class', 'user-page')
@section('content')

    <section class="py-3 my-post bg-light  position-relative height-500">
        <div class="container-fluid">
            <div class="row justify-content-end">
                <div class="col-lg-3  col-12 mb-4">
                    @include($templatePath .'.auth.sidebar-customer')
                </div>
                
                <div class="col-lg-9 col-12">
                    <div class="row">
                      <div class="col-12">
                        <div class="section-title mb-0">
                          <h2>Quản lý tin Bán & Cho thuê</h2>
                        </div>
                      </div>
                    </div>
                    @if($agent->isMobile())
                        @foreach($products as $index => $product)
                        <div class="row mb-2 py-2 bg-white">
                            <div class="col-12 d-flex">
                                <div class="img position-relative">
                                    <div class="dummy"></div>
                                    <div class="my-dummy"><img src="{{ asset($product->image) }}" alt="" width="100"></div>
                                    
                                </div>
                                <div class="info px-2">
                                    <div class="package_status">
                                        @if($product->deposit)
                                            <span class="status-ok ms-0">Hàng ký gửi</span>
                                        @else
                                            <span class="title">{{ $product->getPackage->title }}</span>

                                            @php
                                                $date_end = str_replace('/', '-', $product->date_end);
                                                
                                                $date_end = \Carbon\Carbon::parse($date_end);

                                                $duration = $date_end->diffInDays(now());
                                            @endphp

                                            @if($date_end > now() && $duration<5)
                                                <span class="status-wait">Sắp hết hạn</span> (còn {{ $duration }} ngày)
                                            @elseif($date_end < now())
                                                <span class="status-payment-wait">Hết hạn</span>
                                            @else
                                                @if($product->status == 0)
                                                <span class="status-ok">Đã duyệt</span>
                                                @elseif($product->status == 1)
                                                <span class="status-wait">Chưa duyệt</span>
                                                @else
                                                <span class="status-payment-wait">Chưa thanh toán</span>
                                                @endif
                                            @endif
                                        @endif
                                    </div>
                                    {{ $product->name }}
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row my-3">
                                    <div class="col-5">
                                        <div>Mã tin</div>
                                        <div>{{ $product->sku }}</div>
                                    </div>
                                    <div class="col-7">
                                        <div>Ngày hết hạn</div>
                                        <div>{{ date('d/m/Y', strtotime($product->date_end)) }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex p-2 border">
                                    <div class="px-2">
                                        <div>Xem tin</div>
                                        <div>{{ $product->getThongke->click ?? 0 }}</div>
                                    </div>
                                    <div class="px-1">
                                        <div>Xem số điện thoại</div>
                                        <div>{{ $product->getThongke->phone ?? 0 }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 pt-3 pb-2 text-end ">
                                <a href="{{ route('dangtin.edit', $product->id) }}" class="py-2 px-2 btn-primary"><i class="far fa-edit"></i> Sửa tin</a>
                                <a href="{{ route('dangtin.delete', $product->id) }}" class="py-2 px-2 btn-danger white-space-nowrap product-delete"><i class="far fa-trash-alt"></i> Xóa tin</a>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="row mt-3 border-top border-bottom bg-white header-mypost">
                            <div class="col-1 text-center p-2">STT</div>
                            <div class="col-1 p-2">Mã tin</div>
                            <div class="col-4 p-2">Tiêu đề</div>
                            <div class="col-2 p-2">Ngày hết hạn</div>
                            <div class="col-1 p-2">Thống kê</div>
                            <div class="col-3 p-2"></div>
                        </div>
                        @foreach($products as $index => $product)
                        <div class="row mb-2 py-2 bg-white">
                            <div class="col-1 text-center">{{ $index + 1 }}</div>
                            <div class="col-1">
                                {{ $product->sku }}
                            </div>
                            <div class="col-4 d-flex">
                                <div class="img position-relative">
                                    <div class="dummy"></div>
                                    <div class="my-dummy"><img src="{{ asset($product->image) }}" alt="" width="100"></div>
                                    
                                </div>
                                <div class="info px-2">
                                    <div class="package_status">
                                    @if($product->deposit)
                                        <span class="status-ok ms-0">Hàng ký gửi</span>
                                    @else
                                        <span class="title">{{ $product->getPackage->name }}</span>

                                        @php
                                            $date_end = str_replace('/', '-', $product->package_end);
                                            
                                            $date_end = \Carbon\Carbon::parse($date_end);

                                            $duration = $date_end->diffInDays(now());
                                        @endphp

                                        @if($date_end > now() && $duration<5)
                                            <span class="status-wait">Sắp hết hạn </span> 
                                        @elseif($date_end < now())
                                            <span class="status-payment-wait">Hết hạn</span>
                                        @else
                                            @if($product->status == 0)
                                            <span class="status-ok">Đã duyệt</span>
                                            @elseif($product->status == 1)
                                            <span class="status-wait">Chưa duyệt</span>
                                            @else
                                            <span class="status-payment-wait">Chưa thanh toán</span>
                                            @endif
                                        @endif
                                        
                                    @endif
                                    </div>
                                    {{ $product->name }}
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="text-center">
                                    {{ date('d/m/Y', strtotime($product->package_end)) }}
                                </div>
                                @if(isset($duration))
                                <div class="text-red text-center">
                                    (còn {{ $duration }} ngày)
                                </div>
                                @endif
                            </div>
                            <div class="col-1 thongke">
                                <div>
                                    <span class="me-2">{{ $product->getThongke->view ?? 0 }}</span> 
                                    <span role="img" aria-label="eye" class="anticon" style="margin-top: -5px;">
                                        <img src="{{ asset('images/icon-view.svg') }}" alt="">
                                    </span>
                                </div>
                                {{--
                                <div>
                                    <span class="me-2">{{ $product->getThongke->click ?? 0 }}</span> 
                                    <span role="img" class="anticon" style="margin-top: -5px;"><img src="{{ asset('images/icon-mouse.svg') }}" alt=""></span>
                                </div>
                                --}}
                                <div>
                                    <span class="me-2">{{ $product->getThongke->phone ?? 0 }}</span> 
                                    <span role="img" aria-label="phone" class="anticon" style="margin-top: -5px;">
                                        <img src="{{ asset('images/icon-phone.svg') }}" alt="">
                                    </span>
                                </div>
                            </div>
                            <div class="col-3 pt-2">
                                <a href="{{ route('dangtin.edit', $product->id) }}" class="py-2 px-2 btn-primary"><i class="far fa-edit"></i> Sửa tin</a>
                                <a href="{{ route('dangtin.delete', $product->id) }}" class="py-2 px-2 btn-danger white-space-nowrap product-delete"><i class="far fa-trash-alt"></i> Xóa tin</a>
                                
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </section>    
@endsection

@push('head-style')
<link rel="stylesheet" href="{{ asset($templatePath.'/css/customer.css') }}">
<style>
    .banner_wide{
        display: none !important;
    }
</style>
@endpush
@push('after-footer')
<script src="{{ asset('theme/js/customer.js') }}"></script>
@endpush