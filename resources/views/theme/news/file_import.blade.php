@if(!empty($data))
    <div class="table-responsive table-xnk" style="max-height: 700px;">
        <table class="table table-striped mb-0 tablefilter">
            <thead class="table-light align-middle sticky-top">
                <tr>
                    <th class="text-nowrap">Ngày thông quan</th>
                    <th class="text-nowrap">HS Code</th>
                    <th class="text-nowrap">Mô tả hàng hóa</th>
                    <th class="text-nowrap">Tên Cty xuất khẩu</th>
                    <th class="text-nowrap">Địa chỉ Cty xuất khẩu</th>
                    <th class="text-nowrap">Điện thoại Cty xuất khẩu</th>
                    <th class="text-nowrap">Tên Cty nhập khẩu</th>
                    <th class="text-nowrap">Địa chỉ Cty nhập khẩu</th>
                    <th class="text-nowrap">Điện thoại cty nhập khẩu</th>
                    <th class="text-nowrap">Tên nước xuất khẩu</th>
                    <th class="text-nowrap">Tên nước nhập khẩu</th>
                    <th class="text-nowrap">Điều kiện giá</th>
                    <th class="text-nowrap">Số lượng</th>
                    <th class="text-nowrap">Mã đơn vị tính giá</th>
                </tr>
            </thead>
            <tbody class="align-middle">
                @foreach($data as $index => $item)
                    @php
                        if(!empty($item['ngay_thong_quan']) && $item['ngay_thong_quan'] !='')
                        {
                            $unix_date = ($item['ngay_thong_quan'] - 25569) * 86400;
                            $ngay_thong_quan = date('d/m/Y', $unix_date);
                        }
                    @endphp
                    <tr>
                        <td class="text-end">{{ $ngay_thong_quan??'' }}</td>
                        <td>{{ $item['hs_code']??'' }}</td>
                        <td>{!! $item['mo_ta_hang_hoa']??'' !!}</td>
                        <td>{{ $item['ten_cty_xuat_khau']??'' }}</td>
                        <td>{{ $item['dia_chi_cty_xuat_khau']??'' }}</td>
                        <td class="text-end">{{ $item['dien_thoai_cty_xuat_khau']??'' }}</td>
                        <td>{{ $item['ten_cty_nhap_khau']??'' }}</td>
                        <td>{{ $item['dia_chi_cty_nhap_khau']??'' }}</td>
                        <td class="text-center">{{ $item['dien_thoai_cty_nhap_khau']??'' }}</td>
                        <td class="text-center">{{ $item['ten_nuoc_xuat_khau']??'' }}</td>
                        <td class="text-center">{{ $item['ten_nuoc_nhap_khau']??'' }}</td>
                        <td class="text-center">{{ $item['dieu_kien_gia']??'' }}</td>
                        <td class="text-center">{{ $item['so_luong']??'' }}</td>
                        <td class="text-center">{{ $item['ma_don_vi_tinh_gia']??'' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif