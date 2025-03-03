<div class="content-detail">
    <h2>{{ $product->getAuth->company }}</h2>
    <div class="bottom-info mb-3">
        <div class="item icon-clock">
            <i class="fa-regular fa-clock"></i>
            {{ date('H:i d/m/Y', strtotime($product->created_at)) }}
        </div>
        {{--
        <!-- <div class="item icon-eye">
            69,656 người xem
        </div> -->
        --}}
        <div class="item icon-location">
            @if(count($product->getAddressFull()))
            <div><i class="fa-solid fa-location-dot"></i> {{ implode(', ', $product->getAddressFull()) }}</div>
            @endif
        </div>
    </div>


    <div class="product-detail_description">
        <h5>Mô tả chi tiết</h5>
        <div>
            @if(!empty($category_main) && \View::exists($templatePath .".product.". $category_main->slug .".". $category->slug ."-single"))
                @include($templatePath .".product.". $category_main->slug .".". $category->slug ."-single")
            @else

            <table class="table table-bordered mb-0">
                @php
                    $options = $product->getOptions();
                @endphp

                <tr>
                    <td width="200">Tên công ty: </td>
                    <td>{{ $product->getAuth->company }}</td>
                </tr>
                <tr>
                    <td width="200">Phương thức vận chuyển: </td>
                    <td>{{ !empty($category) ? $category->name : '' }}</td>
                </tr>

                <tr>
                    <td>Loại container</td>
                    <td>{{ $options[13]??'' }}</td>
                </tr>

                @if(!empty($options[104]))
                <tr>
                    <td>Hình thức vận chuyển</td>
                    <td>{{ $options[104]??'' }}</td>
                </tr>
                @endif

                <tr>
                    <td>Nơi đi</td>
                    <td>{{ implode(', ', $product->getAddressFull()) }}</td>
                </tr>

                <tr>
                    <td>Nơi đến</td>
                    <td>{{ $product->address_end }}</td>
                </tr>

                <tr>
                    <td>Lịch khởi hành</td>
                    <td>{{ $options[35]??'' }}</td>
                </tr>

                <tr>
                    <td>Thời gian vận chuyển</td>
                    <td>{{ $options[36]??'' }}</td>
                </tr>

                <tr>
                    <td>Cước vận chuyển</td>
                    <td>
                        <b>{!! render_price($product->price??0) !!}</b>
                    </td>
                </tr>

                <tr>
                    <td>Phụ phí</td>
                    <td>{!! render_price($product->cost) !!}</td>
                </tr>

                <tr>
                    <td>Tổng cước</td>
                    <td>
                        {!! render_price($product->price+$product->cost) !!}

                        {{--
                        @if(!empty($options[39]))
                            <b>{!! render_price($options[39]??0) !!}</b>
                        @else
                            <b>{!! render_price($product->price??0) !!}</b>
                        @endif
                        --}}
                    </td>
                </tr>
                
                <tr>
                    <td>Hiệu lực giá</td>
                    <td>{{ $product->getDateAvailable() }}</td>
                </tr>
                <tr>
                    <td>Ghi chú</td>
                    <td>{{ $options[217]??'' }}</td>
                </tr>
            </table>  
            @endif  
        </div>
    </div>

</div>
