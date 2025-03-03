@if(!empty($user))
	@if(Session::has('message_invite'))
		<div class="alert alert-success" role="alert">
		  {{ Session::get('message_invite') }}
		</div>
	@endif
	@if(Session::has('message_invite_error'))
		<div class="alert alert-danger" role="alert">
		  {{ Session::get('message_invite_error') }}
		</div>
	@endif
	@if($user->invited_code == '' && $user->getDayJoin() <= 3) 
	<div class="bg-light p-3 my-2 ">
		<form action="{{ sc_route('customer.accept_invidte') }}" method="post" id="inviteForm">
		    @csrf()
		    <p>Nhập mã giới thiệu:</p>
		    <div class="input-group">
		        <input type="text" class="form-control text-center mx-auto" placeholder="Mã giới thiệu" name="invite_code" id="invite_code">
		        <button class="btn btn-custom btn-accept-invite" type="submit" id="button-addon2">Xác nhận</button>
		    </div>
		</form>
	</div>
	@endif
@endif