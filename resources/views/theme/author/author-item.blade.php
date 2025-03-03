@php
	$options = $customer->getOptions();
@endphp
@if($customer->role == 4)
	<div class="customer-item customer-logistic">
		<h3>{{ $customer->company }}</h3>
		<div class="item-content">
			<div class="avatar">
				@if($customer->avatar)
				<img src="{{ asset($customer->avatar) }}" alt="{{ $customer->fullname }}" class="card-img-top">
				@else
				<img src="{{ asset('assets/images/no-image.jpg') }}" alt="{{ $customer->fullname }}" class="card-img-top">
				@endif
			</div>
			<div class="info px-3">
				<ul>
					<li><span>Địa chỉ:</span> {{ $customer->address }}</li>
					<li><span>Điện thoại:</span> <span class="show-phone-text">{{ $customer->getPhone(1) }}</span> <span class="show-phone" data-id="{{ $customer->id }}"  onclick="">Hiện số</span></li>
					<li><span>Dịch vụ chính:</span> {{ $options[66]??'' }}</li>
					<li><span>Các tuyến chính:</span> {{ $options[104]??'' }} </li>
				</ul>
			</div>
		</div>
		<div class="item-share d-flex mt-2">
			<div class="share-box  text-center">
                <a class="" href="javascript:;"><i class="fas fa-share-alt"></i> Chia sẻ</a>
                <ul class="list-unstyled share-box-social">
                	<li>
                        <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" data-event="social share" data-info="Facebook" aria-label="Share on Facebook"><i class="fab fa-facebook-f"></i></a>
                    </li>
                    <li>
                        <a target="_blank" href="http://twitter.com/share?url={{ url()->current() }}&text=How%20to%20Tag%20a%20Link%20on%20Your%20Facebook%20Page"  data-event="social share" data-info="Twitter" aria-label="Share on Twitter"><i class="fab fa-twitter"></i></a>
                    </li>
                    <li>
                        <a target="_blank" href="#"><i class="fab fa-instagram"></i></a>
                    </li>
                </ul>
            </div>
			<a href="tel:{{ $customer->getPhone() }}"><i class="fas fa-phone"></i> Liên hệ</a>
			<a href="{{ $customer->getUrlBaoGia() }}" target="_blank" class="active">Yêu cầu báo giá</a>
		</div>
	</div>
@else
<div class="card author-item">
	<div class="author-img">
		<div class="img">
			@if($author->avatar)
			<img src="{{ asset($author->avatar) }}" alt="{{ $author->fullname }}" class="card-img-top">
			@else
			<img src="{{ asset('assets/images/no-image.jpg') }}" alt="{{ $author->fullname }}" class="card-img-top">
			@endif
		</div>
	</div>
	<div class="details">
		<div class="detail-top">
			<h5 class="card-title title">{{ $author->fullname }}</h5>
			<p class="card-text info">“ {{ $author->slogan }} “</p>
		</div>
		<div class="info-achieve">
			<a href="{{ route('author.detail', $author->id) }}">Xem thêm</a>
		</div>
	</div>
</div>
@endif