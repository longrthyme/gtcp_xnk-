<div class="modal fade" id="dangtinWarningModal" tabindex="-1" role="dialog" aria-labelledby="dangtinModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="dangtinModalLabel">CHÚ Ý</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn đã hiểu rõ và xác nhận thông tin của bạn tuân thủ tất cả quy định của sàn GTCplatform.com</p>
                <div class="text-center btn-group w-100 mt-4">
                    <a class="btn btn-custom" href="javascript:;" data-bs-toggle="modal" data-bs-target="#dangtinsuccessModal" data-bs-dismiss="modal">Xác nhận</a>
                    <a class="btn btn-custom btn-custom-secondary" href="javascript:;" data-bs-dismiss="modal" aria-label="Close">Hủy</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="dangtinsuccessModal" tabindex="-1" role="dialog" aria-labelledby="dangtinModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="dangtinModalLabel">Thành Công</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="content_group_offer_view pb-3 text-center">
                    @if(auth()->user()->isVerified() && auth()->user()->countEndDate())
                        <div class="mb-3"><img src="{{ asset('assets/images/circle-icon.png') }}" width="150" alt=""></div>
                        <div class="mb-3 text-center">Bạn đã đăng tin thành công.</div>
                        <div class="mb-3 text-center">Vui lòng chờ kiểm duyệt trong vòng 24h</div>
                    @else
                        <div class="mb-3"><img src="{{ asset('assets/images/warning-icons.png') }}" width="150" alt=""></div>
                        <p>Tin của bạn đã được gửi đến bộ phận quản lý để duyệt nội dung, tuy nhiên tin của bạn không được hiển thị trên trang chủ và bạn không được hưởng các tiện ích nâng cao của sàn do tài khoản của bạn chưa được nâng cấp.</p>
                        <p>Bạn có muốn nâng cấp tài khoản ngay bây giờ ?</p>
                        <div class="text-center btn-group w-100 mt-4 mb-3">
                            <a class="btn btn-custom" href="{{ sc_route('account_upgrade') }}">NÂNG CẤP NGAY</a>
                            <a class="btn btn-custom btn-custom-secondary" href="javascript:;" data-bs-dismiss="modal" aria-label="Close">TÔI SẼ NÂNG CẤP SAU</a>
                        </div>
                    @endif
                    <div class="border mb-3 p-3">
                        <div class="d-flex justify-content-between">
                            <span>Mã tin</span>
                            <span>{{ $product->sku??'' }}</span>
                        </div>
                    </div>
                    <div class="text-center">
                        <a class="btn border" href="{{ sc_route('customer.post') }}" title="">Quản lý tin đăng</a>
                        <a class="btn border" href="{{ sc_route('dangtin') }}" title="">Đăng tin khác</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
