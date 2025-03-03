<div class="modal login fade" id="walletnotifyModal" tabindex="-1" role="dialog" aria-labelledby="notifyModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="list-content-loading">
                <div class="half-circle-spinner">
                    <div class="circle circle-1"></div>
                    <div class="circle circle-2"></div>
                </div>
            </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            
            <div class="modal-body">
                <div class="p-3">
                    <div class="text-center mb-4">
                        <p><img src="{{ asset('theme/images/icons/cancel.png') }}" alt=""></p>
                        <h2 class="mb-5">Đăng tin không thành công</h2>

                        <div class="">
                            <p>Số tiền trong tài khoản của quý khách không đủ để thanh toán bài đăng này.</p>
                            <p>Quý khách vui lòng nạp thêm tiền và tiến hành thanh toán</p>
                            <p>Tin đăng của quý khách đã được lưu nháp</p>
                            <p><a href="{{ route('customer.post') }}" title="">Quản lý tin đăng</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>