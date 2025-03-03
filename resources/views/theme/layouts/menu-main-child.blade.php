<div class="dropdown-menu">
	@foreach ($data as $menu)
		@php
			$link = url($menu['link']??'#')
		@endphp
	    <div class="{{ count($menu['child'])?'dropdown':'' }}">
	    	<a class="dropdown-item" href="{{ $link }}">{{ $menu['label'] }}</a>

		    @if($menu['child'])
		    	<div href="{{$value['link']}}" class="nav-toggle {{ count($menu['child'])?'dropdown-toggle':'' }}" data-bs-toggle="dropdown" aria-expanded="false"></div>
		    	@include($templatePath .'.layouts.menu-main-child', ['data' => $menu['child']])
		    @endif
	    </div>		
    @endforeach
</div>
