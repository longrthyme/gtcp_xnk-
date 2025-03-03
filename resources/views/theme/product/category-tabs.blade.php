@php
	$menus = Menu::getByName('Category-tabs');
@endphp
@foreach($menus as $menu)
	@if($menu['link'] == $category->slug)
		<div class="nav-scroll">
		    <ul class="nav nav-pills nav-product-tabs" id="pills-tab" role="tablist">
		        @foreach($menu['child'] as $index => $item)
			        @php
					    $menu_active = '';
					    if (url()->current() == url($item['link']??'#'))
					       $menu_active = ' active';
					@endphp
			        <li class="nav-item">
			            <a class="nav-link {{ $menu_active }}" href="{{ url($item['link']??'#') }}"><span>{{ $item['label'] }}</span></a>
			        </li>
		        @endforeach
		    </ul>
		</div>
	@endif
@endforeach