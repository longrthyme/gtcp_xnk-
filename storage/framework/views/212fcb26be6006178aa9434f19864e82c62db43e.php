<?php
	$headerMenu = Menu::getByName('Menu-main'); 
	//$agent = new Jenssegers\Agent\Agent;
	$menu_header_top = Menu::getByName('Menu-Header-Top');
	$menu_langs = Menu::getByName('Menu-lang');
?>
<?php echo $__env->make($templatePath . '.layouts.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/long/Downloads/GTCPLATFORM-main/resources/views/theme/layout.blade.php ENDPATH**/ ?>