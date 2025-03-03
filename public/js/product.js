jQuery(document).ready(function($) {
	$('.filter-set').click(function(){
		var name = $(this).data('name');
		$(this).closest('.list-filter-item').find('.filter-set').removeClass('active');
		$(this).addClass('active');

		if($('#form-search [name="'+name+'"]').length)
			$('#form-search [name="'+name+'"]').val($(this).attr('title')??$(this).text());
		else
		{
			$("<input type='hidden' />")
	     .attr("name", name)
	     .attr("value", $(this).attr('title')??$(this).text())
	     .appendTo("#form-search");
		}
		
		

		$('html, body').animate({
          scrollTop: $("#form-search").offset().top - 120
      }, 500);
		submitSearch();
	});

	$('.option-change').on('change', function(){
		var name = $(this).data('name');

		if($('#form-search [name="'+name+'"]').length)
			$('#form-search [name="'+name+'"]').remove();

		$("<input type='hidden' />")
	     .attr("name", name)
	     .attr("value", $(this).val())
	     .appendTo("#form-search");
		

		$('html, body').animate({
          scrollTop: $("#form-search").offset().top - 120
      }, 500);
		submitSearch();
	});

	$('.productSearch-btn').click(function(){
		submitSearch();
		return false;
	});

	function submitSearch() {
		$('.product-list').addClass('loading');
		var form = document.getElementById("form-search");
		var fdnew = new FormData(form);
		axios({
         method: 'post',
         url: $('.form-search').prop("action"),
         data: fdnew,
      }).then(res => {
         if(res.data.view != '')
         {
         	$('.product-list').html(res.data.view);

         	if($('.product-list .tablefilter').length)
			   {
			      $('.tablefilter').DataTable({
			         'aoColumnDefs': [{
			             'bSortable': false,
			             'aTargets': ['action', 'nosort']
			         }],
			         "order": [], 
			         "aaSorting": [], 
			         'searching': false, 
			         'lengthChange': false, 
			         "paging": false, 
			         "info": false, 
			         "decimal": ",", 
			         "thousands": ".",
			   	});
			   }

         	window.history.replaceState("","", res.data.url);
         }
         $('.product-list').removeClass('loading');
      })
      .catch(function (error) {
			if (error.response) {
		      if(error.response.status == 419)
		      	location.reload();
	    	} 
	 	});
	}
});