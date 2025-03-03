@php
	$type = $data['type']??'';
	$user_type = (new \App\Models\UserType)->where('slug', $type)->first();
@endphp
@if($user_type)
	@if($type == 'logistic')
		
	@endif
@endif