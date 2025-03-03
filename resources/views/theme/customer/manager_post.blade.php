@php
    $agent = new  Jenssegers\Agent\Agent();
@endphp

@extends($templatePath .'.layout')

@section('content')

    <section class="py-3 my-post bg-light  position-relative height-500">
        <div class="container">
            <div class="row justify-content-end">
                <div class="col-lg-3  col-12 mb-4">
                    @include($templatePath .'.customer.includes.sidebar-customer')
                </div>
                
                <div class="col-lg-9 col-12">
                    <div class="row">
                      <div class="col-12">
                        <div class="section-title mb-0">
                          <h2>Quản lý tin đăng</h2>
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
                                    {{--
                                    <div class="package_status">
                                        <span class="title">{{ $product->getPackage->title }}</span>

                                        @php
                                            $date_end = str_replace('/', '-', $product->date_end);
                                            
                                            $date_end = \Carbon\Carbon::parse($date_end);

                                            $duration = $date_end->diffInDays(now());
                                        @endphp

                                        @if($date_end > now() && $duration<5)
                                            <span class="status-wait">Sắp hết hạn (còn {{ $duration }} ngày)</span>
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
                                    </div>
                                    --}}
                                    {{ $product->name }}
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row my-3">
                                    <div class="col-5">
                                        <div>Mã tin</div>
                                        <div>{{ $product->code }}</div>
                                    </div>
                                    <div class="col-7">
                                        <div>Ngày hết hạn</div>
                                        <div>{{ date('d/m/Y', strtotime($product->date_end)) }}</div>
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
                            <div class="col-2 p-2">Mã tin</div>
                            <div class="col-6 p-2">Tiêu đề</div>
                            <!-- <div class="col-2 p-2">Ngày hết hạn</div> -->
                            <div class="col-3 p-2">Chức năng</div>
                        </div>
                        @foreach($products as $index => $product)
                        <div class="row mb-2 py-2 bg-white">
                            <div class="col-1 text-center">{{ $index + 1 }}</div>
                            <div class="col-2">
                                <b>{{ $product->sku }}</b>
                            </div>
                            <div class="col-6">
                                <div class="post-categories fs-sm bg-light mb-1">
                                    @if($product->getCategories())
                                    @foreach($product->getCategories() as $item)
                                        <span>{{ $item['name'] }} / </span>
                                    @endforeach
                                    @endif
                                    @if($product->name == '')
                                        <b>{{ $product->getAddressFull()?$product->getAddressFullRender():'' }}</b>
                                        @if($product->address_end)
                                        <b> - {{ $product->address_end??'' }}</b>
                                        @endif
                                    @else
                                        <b>{{ $product->name }}</b>
                                    @endif
                                </div>
                                <div class=" d-flex">
                                    <div class="img position-relative">
                                        <div class="dummy"></div>
                                        <div class="my-dummy"><img src="{{ asset($product->image) }}" alt="" width="100"></div>
                                    </div>
                                    <div class="info px-2">
                                        <div class="package_status">
                                            @php
                                                $date_end = str_replace('/', '-', $product->date_available);
                                                $date_end = \Carbon\Carbon::parse($date_end);
                                                $duration = $date_end->diffInDays(now());
                                            @endphp

                                            @if($date_end > now() && $duration<5)
                                                <span class="status-wait badge bg-warning text-dark">Sắp hết hạn (còn {{ $duration }} ngày)</span>
                                            @elseif($date_end < now())
                                                <span class="badge bg-secondary status-payment-wait">Hết hạn</span>
                                            @else
                                                @if($product->status == 1)
                                                <span class="status-ok badge bg-success">Đã duyệt</span>
                                                @elseif($product->status == 2)
                                                <span class="status-wait badge bg-warning text-dark">Chưa duyệt</span>
                                                
                                                @endif
                                            @endif
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            {{--<div class="col-2">{{ date('d/m/Y', strtotime($product->date_end)) }}</div>--}}
                            <div class="col-3 pt-2">
                                <a href="{{ route('dangtin.edit', $product->id) }}" class="py-2 px-2 btn-primary"><i class="far fa-edit"></i> Sửa tin</a>
                                <a onclick="confirmation(event)" href="{{ route('dangtin.delete', $product->id) }}" class="py-2 px-2 btn-danger white-space-nowrap product-delete"><i class="far fa-trash-alt"></i> Xóa tin</a>
                                
                            </div>
                        </div>
                        @endforeach
                        {!! $products->links() !!}
                    @endif
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script src="{{ asset('/js/customer.js') }}"></script>
    <script>
        @if(Session::has('message'))
            Swal.fire({
                title: "Xóa tin thành công",
                text: "{{ Session::get('message') }}",
                icon: "success"
            });
        @endif
        function confirmation(ev) {
            ev.preventDefault();
            var urlToRedirect = ev.currentTarget.getAttribute('href'); //use currentTarget because the click may be on the nested i tag and not a tag causing the href to be empty
            console.log(urlToRedirect); // verify if this is the right URL
            Swal.fire({
                title: "Xóa tin!",
                text: "Khi thực hiện xóa tin bạn không thể khôi phục lại tin đã xóa!",
                icon: "warning",
                confirmButtonText: "Xóa ngay"
            })
            .then((willDelete) => {
                if (willDelete.isConfirmed) 
                    window.location.href = urlToRedirect;
            });
        }
    </script>   
@endpush
