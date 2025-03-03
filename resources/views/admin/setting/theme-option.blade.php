@extends('admin.layouts.index')

@section('seo')
    @include('admin.layouts.seo')
@endsection

@section('content')
<div class="container">
	<h6 class="fw-bold py-3 mb-0"><span class="text-muted fw-light">Dashboard /</span> {{ $title }}</h6>
	<div class="card">
	   <div class="card-header">
	        <h4 class="card-title mb-0">{{ $title }}</h4>
	   </div> <!-- /.card-header -->
	   <div class="card-body">
	      <form action="{{ $url_post }}" method="POST" id="frm-theme-option" enctype="multipart/form-data"> 
	      	@csrf 
	      		<div class="container_group_setting clear">
	         
				@if($settings->count()) 
					<div class="group_item_theme_sort" id="group_item_theme_sort"> 
						@foreach($settings as $index => $setting) 
							@if($setting->type == "line")
							<div class="mb-2 d-flex align-items-center">
	                     <div class="icon_change_postion me-3">
	                        <i class="fa fa-sort"></i>
	                     </div>
	                     <input type="text" value="{{ $setting->name }}" class="form-control me-3" name="header_option[line][name][]" style="width: 300px;" />
	                     <input type="text" class="form-control me-3" placeholder="Please enter Value Field" name="header_option[line][value][]" value="{{ $setting->content }}" />
	                     <input type="button" class="btn btn-danger tbl_button_delete_clean" value="Delete" name="delete_tbl">
	                  </div> 
	                  @elseif($setting->type == "text") 
	                  <div class="mb-2 d-flex align-items-center">
	                     <div class="icon_change_postion me-3">
	                        <i class="fa fa-sort"></i>
	                     </div>
	                     <input type="text" value="{{ $setting->name }}" class="form-control me-3" name="header_option[text][name][]" style="width: 300px;" />
	                     <textarea id="header_option_text_{{$index}}" class="form-control me-3" name="header_option[text][value][]" cols="5" rows="5">{!! $setting->content !!}</textarea>
	                     <input type="button" class="btn btn-danger tbl_button_delete_clean" value="Delete" name="delete_tbl">
	                  </div> 
	                  @elseif($setting->type == "editor") 
	                  <div class="mb-2 d-flex align-items-center">
	                     <div class="icon_change_postion me-3">
	                        <i class="fa fa-sort"></i>
	                     </div>
	                     <input type="text" value="{{ $setting->name }}" class="form-control me-3" placeholder="Please enter Name Field" name="header_option[editor][name][]"  style="width: 300px;"  />
	                     <textarea class="form-control me-3" id="header_option_text_{{$index}}" name="header_option[editor][value][]" cols="5" rows="5">{!! htmlspecialchars_decode($setting->content) !!}</textarea>
	                     <input type="button" class="btn btn-danger tbl_button_delete_clean" value="Delete" name="delete_tbl">
	                  </div>
	                  <script type="text/javascript">
	                     jQuery(document).ready(function($) {
	                        editorQuote('header_option_text_{{$index}}');
	                     });
	                  </script> 
	                  @elseif($setting->type == "img") 
	                  	@include("admin.partials.image-inline", [ 'code_name' => $setting->name, 'name' => $setting->name, 'image' => $setting->content, 'id' => 'id_'.$setting->name ]) 
	                  @endif 
	               @endforeach
	            </div> 
	         @endif 
	         <hr>
	         <div class="tbl_create_theme_add my-3">
	            <div class="row justify-content-center">
	            	<div class="col-lg-6">
	            		<div class="left_item_theme">
			               <b><i>Choose Field Create</i></b>
			            </div>
		               <div class="input-group">
		               		<select name="option_choise_add" class="select_option_choise form-select">
			                  <option value="line">line</option>
			                  <option value="content_editor">Mutiline with Editor</option>
			                  <option value="content">Mutiline</option>
			                  <option value="img">Image</option>
			               	</select>
			               	<button id="create_option" type="button" class="btn btn-primary create_option_class">Create Option</button>
		               </div>
	            	</div>
	            </div>
	         </div>
	         
	         <div class="posts_tbl_setting clear text-center">
	            <button id="submit_setting" class="btn btn-primary pull-left" name="submit" type="submit">Save Changes</button>
	            <p>
	               <b>Use:</b>
	               <i style="color: #FF0000;">setting_option('name');</i>
	            </p>
	         </div>
	      </form>
	   </div>
	</div>
</div>

<div class="inlcude-image" style="display: none;">
		@include("admin.partials.image-inline")
</div>
@endsection

@push('scripts')
<script src="https://raw.githack.com/SortableJS/Sortable/master/Sortable.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(document).on("click" ,"#create_option" , function(event) {
			// event.preventDefault();
			var choise_option = $(this).parent().find('.select_option_choise').val();
			console.log(choise_option);
			var line_html = '<div class="mb-2 d-flex align-items-center">'+
	                     '<div class="icon_change_postion me-3"><i class="fa fa-sort"></i></div>'+
	                     '<input type="text" value="" class="form-control me-3" name="header_option[line][name][]" style="width: 300px;" />'+
	                     '<input type="text" class="form-control me-3" placeholder="Please enter Value Field" name="header_option[line][value][]" value="" />'+
	                     '<input type="button" class="btn btn-danger tbl_button_delete_clean" value="Delete" name="delete_tbl">'+
	                  '</div> ';

			var content ='<div class="group_item_theme">'+
						'<div class="icon_change_postion"><i class="fa fa-sort"></i></div>' +
               	'<div class="left_item_theme left_genate"><input type="text" value="" placeholder="Please enter Name Field"  name="header_option[text][name][]" /></div>'+
               	'<div class="right_item_theme right_genate"><textarea class="regular-area" name="header_option[text][value][]" cols="5" rows="5" placeholder="Please enter Value Field"></textarea><input type="button" class="button button-secondary tbl_button_delete_clean" value="Delete" name="delete_tbl"></div>'
               	'</div>';
			var content_editor ='<div class="group_item_theme">'+
						'<div class="icon_change_postion"><i class="fa fa-sort"></i></div>' +
               	'<div class="left_item_theme left_genate"><input type="text" value="" placeholder="Please enter Name Field"  name="header_option[editor][name][]" /></div>'+
               	'<div class="right_item_theme right_genate"><textarea class="regular-area" name="header_option[editor][value][]" cols="5" rows="5" placeholder="Please enter Value Field"></textarea><input type="button" class="button button-secondary tbl_button_delete_clean" value="Delete" name="delete_tbl"></div>'
               	'</div>';
			var image_input = $('.inlcude-image').find('.group_item_theme').clone();
			var id = 'image',
              btn_id = image_input.find('button').attr('id'),
              data_input = image_input.find('button').attr('data'),
              data_show = image_input.find('button').attr('data-show'),
              index = $('.group_item_theme').length;
         index = index + 1;
         console.log(index);
         image_input.find('img').attr('src', "{{asset('assets/images/placeholder.png')}}");
         image_input.find('img').attr('class', data_show +''+ index);
         image_input.find('button').attr('data-show', data_show +''+ index);
         image_input.find('.input_image').val('');
         image_input.find('.input_image').addClass(data_show +''+ index);
         image_input.find('.input_image').attr('id', id +''+ index);
         image_input.find('button').attr('id', btn_id +''+ index);
         image_input.find('button').attr('data', data_input +''+ index);

			switch(choise_option){
				case "line":
					$('.container_group_setting .group_item_theme_sort').append(line_html);
				break;
				case "content_editor":
					$('.container_group_setting .group_item_theme_sort').append(content_editor);
				break;
				case "content":
					$('.container_group_setting .group_item_theme_sort').append(content);
				break;
				case "img":
					console.log(image_input);
					$('.container_group_setting .group_item_theme_sort').append(image_input);
					$(document).on('click', '.ckfinder-popup',function(index, el) {
			        	var id = $(this).attr('id'),
			            input = $(this).attr('data'),
			            view_img = $(this).attr('data-show');
			        	selectFileWithCKFinder( input, view_img );
			    	});
				break;
				default:
					alert('Select one option');
			}
		});

		$(document).delegate(".tbl_button_delete_clean","click", function(event) {
			event.preventDefault();
			var elem = $(this).parent().parent();
			$.confirm({
				'title'		: 'Delete Confirmation',
				'message'	: 'You are about to delete this option. <br />It cannot be restored at a later time! Continue?',
				'buttons'	: {
					'Yes'	: {
						'class'	: 'blue',
						'action': function(){
							elem.remove();
						}
					},
					'No'	: {
						'class'	: 'gray',
						'action': function(){}	// Nothing to do in this case. You can as well omit the action property.
					}
				}
			});
		});

		// $(".group_item_theme_sort").sortable();
		new Sortable(group_item_theme_sort, {
		    handle: '.icon_change_postion', // handle's class
		    swap: true, // Enable swap plugin
				swapClass: 'highlight', // The class applied to the hovered swap item
		    animation: 150
		});
	});
</script>
@endpush