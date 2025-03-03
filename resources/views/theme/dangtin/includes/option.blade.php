@if(!empty($id))
	@php
		$option = \App\Models\ShopOption::find($id);
		if($option)
		{
			$options = $option->posts;
			$value = $value??'';

			$required = $multiple = '';
			if($option->required)
				$required = 'required';
			if($option->type_data == 'multiple')
				$multiple = 'multiple';

			$option_name = $option_title??$option->name;
		}
	@endphp

	@if($option)
		@if($option->type == 'select')
			@php
				// loc option thuoc category json
				if(!empty($category))
				{
					$options_ = [];
					$options_ = array_map(function($k) use($category) {
						$unit_decode = json_decode($k['unit'])??[];
						if(is_array($unit_decode) && in_array($category->id, $unit_decode))
							return $k;
					}, $options->toArray());
					$options_ = array_filter($options_);
				}
				else
					$options_ = $options->toArray();
			@endphp
			<div class="optionItem">
	         <div class="input-boder active">
	            <label>{{ $option_name }} {!! $option->required?'<span>*</span>':''!!}</label>
	            <select class="form-select {{ $multiple?'select2' :'' }}" name="option[{{ $option->id }}]{{ $multiple?'[]' :'' }}" {{ $multiple }} 
	            	{{ $required }}
	            	data-msg-required="{{ $required!=''?'Chọn '. $option_name : '' }}"
	            	>
	            	@if(!$required)
	            	<option value="">----- Chọn {{ $option_name }} -----</option>
	            	@endif
	            	@if(count($options_))
	            		@foreach($options_ as $item)
	            			@if($item)
	            			<option value="{{ $item['name'] }}" {{ $value == $item['name'] ? 'selected' : '' }}>{{ $item['name'] }}</option>
	            			@endif
	            		@endforeach
		            @else
		               @foreach($options as $item)
			               @if(is_array($value))
			               	<option value="{{ $item->name }}" {{ in_array($item->name, $value) ? 'selected' : '' }}>{{ $item->name }}</option>
			               @else
			               	<option value="{{ $item->name }}" {{ $value == $item->name ? 'selected' : '' }}>{{ $item->name }}</option>
			               @endif
		               @endforeach
	               @endif
	            </select>
	         </div>
	      </div>
	   @elseif($option->type == 'input')
	   @php
	   	$number_format = '';
	   	if($option->type_data == 'number')
	   		$number_format = 'number_format';
	   @endphp
	   <div class="optionItem">
         <div class="input-boder ">
            <label>{{ $option_name }} {!! $option->required?'<span>*</span>':''!!}</label>
            <input type="text" class="form-control input-value {{ $number_format }}" 
            	name="option[{{ $option->id }}]" 
            	value="{{ $number_format != '' && $value?number_format((int)$value):$value }}" 
            	{{ $required }}
            	data-msg-required="{{ $required!=''?'Nhập '. $option_name : '' }}"
            	>
            @if($option->unit)
            <span class="unit">{{ $option->unit }}</span>
            @endif
         </div>
      </div>
	   @elseif($option->type == 'date')
	   <div class="optionItem">
         <div class="input-boder active">
            <label>{{ $option_name }} {!! $option->required?'<span>*</span>':''!!}</label>
            <input type="text" class="form-control input-value datepicker" name="option[{{ $option->id }}]" value="{{ $value }}" placeholder="dd/mm/yyyy" 
            {{ $required }}
            data-msg-required="{{ $required!=''?'Nhập '. $option_name : '' }}"
            >
         </div>
      </div>
		@endif
	@endif

@endif