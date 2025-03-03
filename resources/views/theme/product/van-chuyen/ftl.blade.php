@php
    if(empty($products))
    {
        $category_id = $category_sub->id??$category->id;
        
        $products = $modelProduct->setCategory($category_id)->getList([
            'post_type' => $post_type,
        ]);
    }
@endphp


@if(!empty($products) && $products->count())
<div class="table-responsive text-center">
    <table class="table table-bordered mb-0 tablefilter">
        <thead class="table-light align-middle">
            <tr>
                <th class="nosort">Loại xe</th>
                <th class="nosort">Trọng tải</th>
                <th>Thùng xe Dài</th>
                <th>Thùng xe Rộng</th>
                <th>Thùng xe Cao</th>
                <th>Giá 10km đầu</th>
                <th>Giá 11km - 44km</th>
                <th>Giá từ km 45</th>
                <th>Thời gian chờ</th>

                <th>Hiệu lực giá</th>
                <th class="nosort">Lựa chọn xe</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $index => $product)
                @php
                    $options = $product->getOptions();
                    
                    $options_unit = (new \App\Models\ShopOption)->whereIn('id', array_keys($options))->get()->pluck('unit', 'id')->toArray();
                    
                    $product_categories = $product->getCategories();
                    if(count($product_categories))
                    {
                        $category_end = end($product_categories);
                        $category_end = $modelCategory->getDetail($category_end['id']);
                    }
                @endphp
                <tr>
                    <td>{{ $options[202]??'' }} - {{ $options[30]??'' }}</td>
                    <td>{{ $options[206]??'' }}{{ $options[136]??'' }}</td>
                    <td>
                        {{ $options[207]??'' }}{{ $options_unit[207]??'' }}
                    </td>
                    <td>
                        {{ $options[208]??'' }}{{ $options_unit[208]??'' }}
                    </td>
                    <td>
                        {{ $options[209]??'' }}{{ $options_unit[209]??'' }}
                    </td>
                    <td>{!! render_price($product->price) !!}</td>
                    <td>{!! !empty($options[211]) ? render_price($options[211]) : '' !!}/km</td>
                    <td>{!! !empty($options[212]) ? render_price($options[212]) : '' !!}/km</td>
                    <td>{!! !empty($options[213]) ? render_price($options[213]) : '' !!}/h</td>
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