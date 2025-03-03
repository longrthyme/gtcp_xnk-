<div class="mb-2 d-flex align-items-center group_item_theme">
	<div class="icon_change_postion me-3"><i class="fa fa-sort"></i></div>
	<input type="text" value="{{ $code_name ?? '' }}" class="form-control me-3" placeholder="Please enter Name Field"  name="header_option[img][name][]" style="width: 300px;" />

	<div class="input-group me-3">
		<div class="input-group">
			<input type="text" class="form-control input_image {{ $id ?? 'img' }}_view" name="header_option[img][value][]" id="{{ $name ?? 'image' }}" value="{{ $image ?? '' }}" autocomplete="off">
			<button class="btn btn-outline-secondary ckfinder-popup" type="button" id="{{ $id ?? 'img' }}"  data-show="{{ $id ?? 'img' }}_view" data="{{ $name ?? 'image' }}">Upload</button>
		</div>
	</div>
	<input type="button" class="btn btn-danger tbl_button_delete_clean" value="Delete" name="delete_tbl">
</div>