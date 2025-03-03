jQuery(document).ready(function($) {
	var $window = $(window),
    $document = $(document),
    $body = $('body'),
    $countdownTimer = $('.countdown'),
    $counter = $('.counter');
  //Check if function exists
  $.fn.exists = function () {
    return this.length > 0;
  };

  $('.datepicker').datepicker({
      format: 'dd/mm/yyyy',
      autoclose: true
  });
	/*************************
      select2
  	*************************/
	var select2 = function () {
		if ($('.basic-select').exists()) {
			var select = $(".basic-select");

			if (select.length > 0) {
				select.each(function(index, el) {
					var search = $(this).data('search');
					if(search){
						$(this).select2({
							minimumResultsForSearch: -1
						});
					}
					else{
						$(this).select2();
					}
				});

				$(document).on('select2:open', (e) => {
					document.querySelector('.select2-search__field').focus();
				});
			}
		}
	};
	select2();

	const get_place = function () {
		var province = $('select[name="province"]').val(),
			district = $('select[name="district"]').val(),
			ward = $('select[name="ward"]').val();
	    axios({
	        method: 'post',
	        url: '/ajax/place-select',
	        data: {
	        	province_id:province,
	        	district_id:district,
	        	ward_id:ward,
	        }
	    }).then(res => {
	    	if(res.data.html)
	    	{
	    		$('.place_map').html(res.data.html);
	      		select2();
	    	}
	    	if(res.data.address)
	    		$('#address').val(res.data.address).trigger('change');
	    }).catch(e => console.log(e));

	 }

	//dangtin
	$(document).on('change', 'select[name="province"], select[name="district"], select[name="ward"]', function(){
		get_place();
	})

	var dangtinForm = $('#dangtinForm');
	if(dangtinForm.length>0){
       	$("#dangtinForm").validate({
	        onfocusout: false,
	        onkeyup: false,
	        onclick: false,
	        rules: {
	           category: "required",
	           province: "required",

	           title: "required",
	           price: "required",
	           content: "required",

	           email: "required",
	        },
	        messages: {
	           category: "Chọn danh mục",
	           province: "Chọn tỉnh thành",

	           title: "Nhập tiêu đề bài viết",
	           content: "Nhập nội dung bài viết",

	           email: "Nhập E-mail",
	        },
	        errorElement : 'div',
	        errorLabelContainer: '.errorTxt',
	        invalidHandler: function(event, validator) {
	           var errors = validator.numberOfInvalids();
	           if (errors) {                    
	              validator.errorList[0].element.focus();
	           }

	        }
		});

		dangtinForm.find('.dangtin-process').click(function(){

			$('input[name="galleries[]"]').remove();
			if( dangtinForm.valid() ){
				var form = document.getElementById('dangtinForm');
				var fdnew = new FormData(form);
				$('#dangtinForm').find('.list-content-loading').show();

				const config = { headers: { 'Content-Type': 'multipart/form-data' } };
				axios.post('/dang-tin', fdnew, config).then(res => {
					if(!res.data.error)
					{
						$('.dangtin_status').html(res.data.view);
						$('#dangtinWarningModal').modal('show');
						$('#dangtinsuccessModal').on('hidden.bs.modal', function (e) {
							window.location.href="/";
						});
						$('aria-label="Close"').click(function(){
							$('#dangtinServiceForm').find('.list-content-loading').hide();
						})
					}
					else{
						$('.dangtin_status').html(res.data.view);
						$('#walletnotifyModal').modal('show');
						$('#walletnotifyModal').on('hidden.bs.modal', function (e) {
							window.location.href="/customer/quan-ly-tin-dang";
						})
					}
				}).catch(function (error) {
					$('#dangtinForm').find('.list-content-loading').hide();
			    if (error.response) {
			    	$('.error-message').text(error.response.data.message);
			      console.log(error.response.data);
			      console.log(error.response.status);
			      console.log(error.response.headers);
			    }
			  });
			}
	  });
	}

	var dangtinServiceForm = $('#dangtinServiceForm');
	if(dangtinServiceForm.length>0){
       	$("#dangtinServiceForm").validate({
	        onfocusout: false,
	        onkeyup: false,
	        onclick: false,
	        rules: {
	           category: "required",
	           province: "required",

	           title: "required",
	           price: "required",
	           content: "required",

	           email: "required",
	        },
	        messages: {
	           category: "Chọn danh mục",
	           province: "Chọn tỉnh thành",

	           title: "Nhập tiêu đề bài viết",
	           price: "Nhập giá bán",
	           content: "Nhập nội dung bài viết",

	           email: "Nhập E-mail",
	        },
	        errorElement : 'div',
	        errorLabelContainer: '.errorTxt',
	        invalidHandler: function(event, validator) {
	           var errors = validator.numberOfInvalids();
	           if (errors) {                    
	              validator.errorList[0].element.focus();
	           }

	        }
		});

		dangtinServiceForm.find('.dangtin-process').click(function(){

			$('input[name="galleries[]"]').remove();
			if( dangtinServiceForm.valid() ){
				var form = document.getElementById('dangtinServiceForm');
				var fdnew = new FormData(form);
				$('#dangtinServiceForm').find('.list-content-loading').show();

				const config = { headers: { 'Content-Type': 'multipart/form-data' } };
				axios.post('/dang-tin', fdnew, config).then(res => {
					if(!res.data.error)
					{
						$('.dangtin_status').html(res.data.view);
						$('#dangtinWarningModal').modal('show');
						$('#dangtinsuccessModal').on('hidden.bs.modal', function (e) {
							window.location.href="/";
						});
						$('aria-label="Close"').click(function(){
							$('#dangtinServiceForm').find('.list-content-loading').hide();
						})
					}
					else{
						$('.dangtin_status').html(res.data.view);
						$('#walletnotifyModal').modal('show');
						$('#walletnotifyModal').on('hidden.bs.modal', function (e) {
							window.location.href="/customer/quan-ly-tin-dang";
						})
					}
				}).catch(e => console.log(e));
			}
	  });
	}

	$(document).on('click', '.categoryItem', function(){
		var id = $(this).attr('data');
		// $(this).hide();
		
		if($('.category-child.category-' + id).length)
		{
			$(this).closest('.modal-content').find('.modal-header .btn-close').hide();
			$(this).closest('.modal-content').find('.modal-header .category-back').show();
			$(this).hide().siblings('.list-group-item').hide();
			$('.category-child.category-' + id).addClass('active').show();
		}
		else
		{
			axios({
          method: 'post',
          url: '/dang-tin/category-selected',
          data: {
          	id: id,
          }
      }).then(res => {
      	// this_.parent().find('.categoryItem').removeClass('disabled');
      	location.reload();
      	
      }).catch(e => {
      	// location.reload();
      });
		}
	});
	$(document).on('click', '.category-back', function(){
		var active = $('.category-child.active');
		if(active.last())
		{
			var active_last = active.last();
			active_last.hide().siblings('.list-group-item').show();
			active_last.removeClass('active');

		}
		if(active.length == 1)
		{
			active_last.closest('.modal-content').find('.modal-header .btn-close').show();
			active_last.closest('.modal-content').find('.modal-header .category-back').hide();
		}
	});

	// changeAddress popup
	$(document).on('click', '.addressPopup', function(){
		$('#changeAddress').modal('show');
	});
	$('.btn-changeAddress').click(function(){
		var address_full = [];
		$('#changeAddress select').map(function(){
			if($(this).val())
				return address_full.push($(this).val());
		})
		if($('#changeAddress .address').val())
			address_full.push($('#changeAddress .address').val());
		if($('#changeAddress .street_number').val())
			address_full.push($('#changeAddress .street_number').val());
		address_full = address_full.reverse().join(', ');
		if(address_full != ''){
			$('.addressPopup').val(address_full);
			$('.addressPopup').parent().addClass('active');
		}
		$('#changeAddress').modal('hide');
		// console.log(address_full);
	})
	// changeAddress popup
	//input and label
	$('.input-boder input.input-value').each(function(){
		if($(this).val() != '' || $(this).attr('placeholder'))
		{
			$(this).closest('.input-boder').addClass('active');
		}
		if($(this).is(':disabled') && !$(this).closest('.input-boder').hasClass('active-disabled'))
			$(this).closest('.input-boder').addClass('active-disabled');
	})
  $(document).on('focus', '.input-boder input', function(){
		$(this).parent().addClass('active');
  });
  $(document).on('blur', '.input-boder input', function(){
    var val = $(this).val();
    if(val=='' && !$(this).attr('placeholder'))
			$(this).parent().removeClass('active');
  });
  $(document).on('click', '.input-textarea textarea', function(){
		$(this).parent().addClass('active');
  });
  $(document).on('blur', '.input-textarea textarea', function(){
    var val = $(this).val();
    if(val=='')
			$(this).parent().removeClass('active');
  });
  $(document).on('change', '.input-boder select', function(){
  	var val = $(this).val();
  	if(val=='')
				$(this).parent().removeClass('active');
		else
			$(this).closest('.input-boder').addClass('active');
  });
//input and label

  function number_format(nStr){
		nStr += '';
		x = nStr.split('.');
		x1 = x[0];
		x2 = x.length > 1 ? '.' + x[1] : '';
		var rgx = /(\d+)(\d{3})/;
		while (rgx.test(x1)) {
			x1 = x1.replace(rgx, '$1' + ',' + '$2');
		}
		return x1 + x2;
	}
	//**************number_format*************/	
	$(document).on('keyup', 'input.number_format', function(event) {
		// skip for arrow keys
		if(event.which >= 37 && event.which <= 40) return;
		
		// format number
		$(this).val(function(index, value) {
			return value
			.replace(/\D/g, "")
			.replace(/\B(?=(\d{3})+(?!\d))/g, ",")
			;
		});
		
		var val_ = $(this).val();
		$(this).parent('.input-group').find('.price_output').val(val_.replace(/\,/gi, ""));
		//$(".price_output").val(val_.replace(/\,/gi, ""));

		var input_price = $('input[name="price"]'),
      input_cost = $('input[name="cost"]'),
      input_tongcuoc = $('.tongcuoc');

      if(input_tongcuoc.length)
      {
      	var price = 0,
      		cost=0,
      		this_val = $(this).val();
      	
      	this_val = parseInt(this_val.replaceAll(',', ''));
      	if($(this).attr('name') == 'price')
      	{
      		if(input_cost.val())
      			cost = input_cost.val();
      	}
      	else if($(this).attr('name') == 'cost')
      	{
      		if(input_price.val())
      			cost = input_price.val();
      	}
      	if(cost)
      		cost = parseInt(cost.replaceAll(',', ''));
      	price = parseFloat(this_val)+parseFloat(cost);


      	input_tongcuoc.parent().addClass('active');
      	input_tongcuoc.val(number_format(price));
      }
	});
	//**************end number_format*************/	
});	

