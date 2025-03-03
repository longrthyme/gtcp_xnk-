@php
	$menus = Menu::getByName($menu);
@endphp
@if($menus)
	@foreach($menus as $menu)
	<div class="block-keyword py-5">
	    <div class="container">
	        <div class="section-title">
	            <h4>{{ $menu['label'] }}</h4>
	        </div>
	        @if($menu['child'])
		        @php
		        	$menu_child = array_chunk($menu['child'], 6);
		        @endphp
		        <div class="list-keyword">
		        @foreach($menu_child as $child)
		            <div class="nav-item-keyword">
		                <ul>
		                	@foreach($child as $item)
		                    <li>
		                        <a href="{{ url($item['link']??'#') }}">{{ $item['label'] }}</a>
		                    </li>
		                    @endforeach
		                </ul>
		            </div>
		        @endforeach
		        </div>
	        @endif
	    </div>
	</div>
	@endforeach
@endif