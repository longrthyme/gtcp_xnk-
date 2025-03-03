@if(!empty($paymentMethods) && count($paymentMethods))
<select name="payment-method" class="form-control" id="payment-method">
	<option value="">----- Select method -----</option>}
	option
	@foreach($paymentMethods as $item)
	<option value="{{ $item->type }}">{{ $item->name }}</option>
	@endforeach
</select>
@else
<input type="text" disabled value="Not support" class="form-control">
@endif