@php
	$agent = new \Jenssegers\Agent\Agent;
@endphp
<ul class="navbar-nav">
	@foreach($headerMenu as $value)
		@php
			$class_active ='';
		@endphp
		@if(empty($value['child']))
			<li class="nav-item {{$class_active}}"><a href="{{$value['link']}}" class="nav-link">{{$value['label']}}</a></li>
		@else
			<li class="nav-item dropdown {{$class_active}}">
				<a href="{{$value['link']}}" class="nav-link">{{$value['label']}}</a>
				@if($agent->isMobile())
				<div href="{{$value['link']}}" class="nav-toggle dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"></div>
				@endif
				
				@include($templatePath .'.layouts.menu-main-child', ['data' => $value['child']])
			</li>
		@endif
	@endforeach
</ul>