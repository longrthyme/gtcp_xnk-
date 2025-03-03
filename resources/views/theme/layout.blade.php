@php
	$headerMenu = Menu::getByName('Menu-main'); 
	//$agent = new Jenssegers\Agent\Agent;
	$menu_header_top = Menu::getByName('Menu-Header-Top');
	$menu_langs = Menu::getByName('Menu-lang');
@endphp
@include($templatePath . '.layouts.index')