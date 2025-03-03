@php
    if(empty($products))
    {
        $category_id = $category_sub->id??$category->id;
        
        $products = $modelProduct->setCategory($category_id)->getList([
            'post_type' => $post_type,
            'transportation' => request('transportation')??''
        ]);
    }
@endphp


@if(!empty($products) && $products->count())
<div class="table-responsive text-center">
    <table class="table table-bordered mb-0 tablefilter">
        <thead class="table-light align-middle">
            <tr>
                <th class="nosort">Phương thức vận chuyển</th>
                <th class="nosort">Loại container</th>
                <th>Nơi đi</th>
                <th>Nơi đến</th>
                <th>Lịch khởi hành</th>
                <th>Thời gian vận chuyển</th>
                <th>Giá vận chuyển</th>
                <th>Phụ phí</th>
                <th>Tổng giá vận chuyển</th>
                <th>Hiệu lực giá</th>
                <th class="nosort">Lựa chọn báo giá</th>
            </tr>
        </thead>
        <tbody class="align-middle">
            @foreach($products as $index => $product)
            @php
                $options = $product->getOptions();
                //dd($options);
                $product_categories = $product->getCategories();
                if(count($product_categories))
                {
                    $category_end = end($product_categories);
                    $category_end = $modelCategory->getDetail($category_end['id']);
                }
            @endphp
            <tr>
                <td>{{ $options[104]??'' }}</td>
                <td>{{ $options[13]??'' }}</td>
                <td>{{ $product->getAddressFullRender() }}</td>
                <td>{{ $product->address_end }}</td>
                <td>{{ $options[35]??'' }}</td>
                <td>{{ $options[36]??'' }}</td>
                <td>
                    {!! render_price($product->price??0) !!}
                     {{-- !empty($options[159]) ? '/ '. $options[159] : '' --}}
                </td>
                <td>
                    {!! render_price($product->cost??0) !!}
                </td>
                <td>
                    {{--{!! render_price($options[39]??0) !!}--}}
                    {!! render_price($product->price+$product->cost) !!}
                </td>
                <td>{{ $product->getDateAvailable() }}</td>
                <td><a href="{{ $product->getUrl() }}" class="btn btn-contacts">Liên hệ ngay >> </a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
    <p>Rất tiếc, thông tin bạn tìm kiếm chưa có sẵn, Vui lòng gửi yêu cầu chào giá để nhận được báo giá sớm nhất</p>
@endif