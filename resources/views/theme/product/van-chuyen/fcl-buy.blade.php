@php
    if(empty($products))
    {
        $category_id = $category_sub->id??$category->id;
        
        $products = $modelProduct->setCategory($category_id)->getList([
            'post_type' => $post_type
        ]);
    }

@endphp


@if(!empty($products) && $products->count())
<div class="table-responsive text-center">
    <table class="table table-bordered mb-0 tablefilter">
        <thead class="table-light align-middle">
            <tr>
                <th>Nhóm hàng hoá</th>
                <th>Loại hàng hoá</th>
                <th>Loại container</th>
                <th>Số lượng</th>
                <th>Phương thức vận chuyển</th>
                <th>Nơi đi</th>
                <th>Nơi đến</th>
                <th>Ngày bốc hàng dự kiến</th>
                <th>Thời hạn báo giá</th>
                <th class="nosort">Liên hệ báo giá</th>
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
                <td>{{ $options[30]??'' }}</td>
                <td>{{ $category_item->name??'' }}</td>
                <td>{{ $options[13]??'' }}</td>
                <td>{{ $options[168]??'' }}</td>
                <td>{{ $options[104]??'' }}</td>
                <td>{{ implode(', ', $product->getAddressFull()) }}</td>
                <td>{{ implode(', ', $product->getAddressEnd()) }}</td>
                <td>{{ $options[35]??'' }}</td>
                <td>{{ $product->getDateAvailable() }}</td>
                <td><a href="{{ $product->getUrlBaoGia() }}" class="btn btn-contacts">Báo giá ngay >> </a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
    <p>Rất tiếc, thông tin bạn tìm kiếm chưa có sẵn, Vui lòng gửi yêu cầu chào giá để nhận được báo giá sớm nhất</p>
@endif