<script type="text/javascript">
	jQuery(document).ready(function($) {
	   var loginModalForm = $('#form-login-page');
	   $("#form-login-page").validate({
	       onfocusout: false,
	       onkeyup: false,
	       onclick: false,
	       rules: {
	           email: "required",
	           password: "required",
	           check_agree: "required",
	       },
	       messages: {
	           email: "@lang('Enter Email')",
	           password : "@lang('Enter Password')",
	           check_agree : "@lang('You have need understood and agree')",
	       },
	       errorElement : 'div',
	       errorLabelContainer: '.errorTxt',
	       invalidHandler: function(event, validator) {
	           $('html, body').animate({
	               scrollTop: 0
	           }, 500);
	       }
	   });

	   $('.btn-login-page').click(function(event) {
	   var this_ = $(this);
	     if(loginModalForm.valid()){
	         var form = document.getElementById('form-login-page');
	        var fdnew = new FormData(form);
	        loginModalForm.parent().find('.list-content-loading').show();
	         axios({
	               method: 'POST',
	               url: $('#form-login-page').prop("action"),
	           data: fdnew,

	         }).then(res => {
	            if (res.data.error == 0) {
	               window.location.href = res.data.redirect_back;
	                // loginModalForm.html(res.data.view);
	            } else{
	                  loginModalForm.parent().find('.list-content-loading').hide();
	                  loginModalForm.find('.error-message').html(res.data.msg);
	            }
	            loginModalForm.parent().find('.list-content-loading').hide();
	         }).catch(e => console.log(e));
	       }
	   });
	});
</script>