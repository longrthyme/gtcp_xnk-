<table class="table table-bordered mb-0">
    @php
        $options = $product->getOptions();
        $options_unit = (new \App\Models\ShopOption)->whereIn('id', array_keys($options))->get()->pluck('unit', 'id')->toArray();
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
        <td>Loại xe</td>
        <td>{{ $options[202]??'' }}</td>
    </tr>
    <tr>
        <td>Nhóm hàng</td>
        <td>{{ $options[30]??'' }}</td>
    </tr>

    @if(!empty($options[104]))
    <tr>
        <td>Hình thức vận chuyển</td>
        <td>{{ $options[104]??'' }}</td>
    </tr>
    @endif

    <tr>
        <td>Trọng tải</td>
        <td>
            @if(!empty($options[206]))
            {{ $options[206]??'' }}{{ $options[136]??'' }}
            @endif
        </td>
    </tr>

    <tr>
        <td>Thùng xe dài</td>
        <td>{{ $options[207]??'' }}{{ $options_unit[207]??'' }}</td>
    </tr>

    <tr>
        <td>Thùng xe rộng</td>
        <td>{{ $options[208]??'' }}{{ $options_unit[208]??'' }}</td>
    </tr>
    <tr>
        <td>Thùng xe cao</td>
        <td>{{ $options[209]??'' }}{{ $options_unit[209]??'' }}</td>
    </tr>
    <tr>
        <td>Giá 10km đầu</td>
        <td>{!! render_price($product->price) !!}</td>
    </tr>
    <tr>
        <td>Giá từ 11km - 44km</td>
        <td>{!! !empty($options[211]) ? render_price($options[211]) : '' !!}/km</td>
    </tr>
    <tr>
        <td>Giá từ km 45</td>
        <td>{!! !empty($options[212]) ? render_price($options[212]) : '' !!}/km</td>
    </tr>
    <tr>
        <td>Thời gian chờ</td>
        <td>{!! !empty($options[213]) ? render_price($options[213]) : '' !!}/h</td>
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