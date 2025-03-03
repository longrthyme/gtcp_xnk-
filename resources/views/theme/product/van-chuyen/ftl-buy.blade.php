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
                <th>Nhóm hàng hóa</th>
                <th>Trọng lượng</th>
                <th>Số lượng</th>

                <th>Dài</th>
                <th>Rộng</th>
                <th>Cao</th>
                
                <th>Nơi nhận hàng</th>
                <th>Nơi giao hàng</th>
                <th>Ngày bốc hàng</th>
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
                <td>
                    @if(!empty($options[206]))
                    {{ $options[206]??'' }}{{ sc_option_unit(206) }}{{ $options[136]??'' }}
                    @endif
                </td>
                <td>{{ $options[168]??'' }}</td>

                <td>
                    @if(!empty($options[207]))
                        {{ $options[207]??'' }}{{ sc_option_unit(207) }}
                    @endif
                </td>
                <td>
                    @if(!empty($options[208]))
                        {{ $options[208]??'' }}{{ sc_option_unit(208) }}
                    @endif
                </td>
                <td>
                    @if(!empty($options[209]))
                        {{ $options[209]??'' }}{{ sc_option_unit(209) }}
                    @endif
                </td>

                
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