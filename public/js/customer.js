jQuery(document).ready(function($) {
    //invite
    $('#inviteForm').validate({
        onfocusout: false,
        onkeyup: false,
        onclick: false,
        rules: {
            invite_code: "required",
        },
        messages: {
            invite_code: "Vui lòng nhập mã giới thiệu",
        },
        errorElement : 'div',
        errorLabelContainer: '.errorTxtModal',
        invalidHandler: function(event, validator) {
        },
        submitHandler: function(form) {
            // $('#invite_code').attr('disabled', true);
            $('.btn-accept-invite').attr('disabled', true);

            form.submit();
        }
    });

	//login modal
    var login_popup = $("#loginModalForm");
    login_popup.validate({
        onfocusout: false,
        onkeyup: false,
        onclick: false,
        errorPlacement: function (error, element) {
            var place = element.closest(".form-floating");

            if (!place.get(0)) {
                place = element;
            }
            if (place.get(0).type === "checkbox") {
                place = element.parent();
            }
            if (error.text() !== "") {
                place.after(error);
            }
            // console.log(error, element);
        },
        // errorElement: "div",
        // errorLabelContainer: ".errorTxt",
        rules: {
            email: {
                required: true,
                email: true,
            },
            password: "required",
        },
        messages: {
            email: {
                require: "Enter Email",
                email: "Invalid email address.",
            },
            password: "Enter password",
        },
        invalidHandler: function (event, validator) {
            $("html, body").animate(
                {
                    scrollTop: 0,
                },
                500
            );
        },
    });

    $(".btn-login").on("click", function (event) {
        if (login_popup.valid()) {
            var form = document.getElementById("loginModalForm");
            var fdnew = new FormData(form);
            login_popup.closest('.login').find(".list-content-loading").show();
            axios({
                method: "POST",
                url: "/auth/login",
                data: fdnew,
            })
                .then((res) => {
                    // console.log(res.data);
                    login_popup.find(".error-message").hide();
                    if (res.data.error == 0) {
                        $("#loginModalForm").html(res.data.view);
                        /*setTimeout(function(){
	                        window.location.href = res.data.redirect_back;
	                    }, 500);*/
                        $("#signin-modal").on("hidden.bs.modal", function (e) {
                            window.location.href = res.data.redirect_back;
                        });
                    } else {
                        login_popup.find(".error-message").show().html(res.data.msg);
                    }
                    $(".list-content-loading").hide();
                })
                .catch((e) => console.log(e));
        }
    });

    //login modal
    var form_sigup = $('#customer-register'),
        account_type = $('input[name="account_type"]');
    if(account_type.length && account_type.val() == 'company')
    {
        form_sigup.validate({
            onfocusout: false,
            onkeyup: false,
            onclick: false,
            rules: {
                'fullname' : 'required',
                'company' : 'required',
                'address' : 'required',
                'mst' : 'required',
                'job' : 'required',
                'phone' : 'required',
                'email' : 'required',
                'username' : 'required',
                'password': "required",
                'password_confirmation': "required",
                'check_agree': "required",
            },
            messages: {
                'fullname' : 'Vui lòng nhập họ tên',
                'company' : 'Vui lòng nhập Tên Công ty',
                'address' : 'Vui lòng nhập Địa chỉ Công ty',
                'mst' : 'Vui lòng nhập Mã số thuế',
                'job' : 'Vui lòng nhập Chức vụ',
                'phone': "Vui lòng nhập số điện thoại",
                'email': "Vui lòng nhập địa chỉ E-mail",
                'username' : 'Vui lòng nhập Tên đăng nhập.',
                'password': "Vui lòng nhập mật khẩu",
                'password_confirmation': "Vui lòng nhập lại mật khẩu",
                'check_agree': "Vui lòng xác nhận điều khoản",
            },
            errorElement: 'div',
            errorLabelContainer: '.errorTxt',
            invalidHandler: function(event, validator) {
                $('html, body').animate({
                    scrollTop: 0
                }, 500);
            }
        });
    }
    else
    {
        form_sigup.validate({
            onfocusout: false,
            onkeyup: false,
            onclick: false,
            rules: {
                'fullname': "required",
                'birthday' : 'required',
                'cccd' : 'required',
                'cccd_date' : 'required',
                'cccd_place' : 'required',
                'phone': "required",
                'email': "required",
                'username': "required",
                'password': "required",
                'password_confirmation': "required",
                'check_agree': "required",
            },
            messages: {
                'fullname': "Nhập họ tên",
                'birthday' : 'Vui lòng nhập Ngày sinh',
                'cccd' : 'Vui lòng nhập CCCD',
                'cccd_date' : 'Vui lòng nhập Ngày cấp',
                'cccd_place' : 'Vui lòng nhập nơi cấp',
                'phone': "Vui lòng nhập số điện thoại",
                'email': "Vui lòng nhập địa chỉ E-mail",
                'username' : 'Vui lòng nhập Tên đăng nhập',
                'password': "Vui lòng nhập mật khẩu",
                'password_confirmation': "Vui lòng nhập lại mật khẩu",
                'check_agree': "Vui lòng xác nhận điều khoản",
            },
            errorElement: 'div',
            errorLabelContainer: '.errorTxt',
            invalidHandler: function(event, validator) {
                $('html, body').animate({
                    scrollTop: 0
                }, 500);
            }
        });
    }
   
   $('.btn-register').click(function(event) {
      console.log(form_sigup);
      if (form_sigup.valid()) {
         form_sigup.closest('.login').find(".list-content-loading").show();
         var form = document.getElementById('customer-register');
         var fdnew = new FormData(form);
         axios({
            method: 'POST',
            url: form_sigup.prop("action"),
            data: fdnew,
         }).then(res => {
            var url_back = '';
            if (res.data.error == 0) {
               url_back = res.data.redirect_back;
               form_sigup.html(res.data.view);
               $('#register-modal').on('hidden.bs.modal', function(e) {
                  window.location.href = '/';
               })
            } else {
               form_sigup.find('.error-message').html(res.data.msg);
            }
            form_sigup.closest('.login').find(".list-content-loading").hide();
         }).catch(e => console.log(e));
      }
   });


    //login
    var login_page = $("#form-login-page");
    login_page.validate({
        onfocusout: false,
        onkeyup: false,
        onclick: false,
        rules: {
            email: "required",
            password: "required",
        },
        messages: {
            email: "Nhập địa chỉ E-mail",
            password: "Nhập mật khẩu",
        },
        errorElement: "div",
        errorLabelContainer: ".errorTxt",
        invalidHandler: function (event, validator) {
            $("html, body").animate(
                {
                    scrollTop: 0,
                },
                500
            );
        },
    });

    $(".btn-login-page").on("click", function (event) {
        loginPage($(this));
    });
    $('#email, #password, #username').on('keypress', function (e) {
        if(e.which === 13)
        {
            loginPage($(this));
        }
    });
    function loginPage(this_) {
        if (login_page.valid()) {
            var form = document.getElementById("form-login-page");
            var fdnew = new FormData(form);
            login_page.find(".list-content-loading").show();
            axios({
                method: "POST",
                url: $('#form-login-page').prop("action"),
                data: fdnew,
            })
            .then((res) => {
                console.log(res.data);
                if (res.data.error == 0) {
                    if (this_.closest("#form-login-page").find("#loginModal").length) {
                        $("#loginModal").find(".modal-body").html(res.data.view);
                        $("#loginModal").find(".modal-footer").remove();
                        $("#loginModal").modal("show");

                        $("#loginModal").on("hidden.bs.modal", function (e) {
                            window.location.href = res.data.redirect_back;
                        });
                    } else window.location.href = res.data.redirect_back;
                } else {
                    login_page.find(".list-content-loading").hide();
                    login_page.find(".error-message").html(res.data.msg);
                }
                // login_page.find('.list-content-loading').hide();
            })
            .catch((e) => console.log(e));
        }
    }
    //login

    //contact ajax
    var contact_form = $("#contactForm");
    contact_form.validate({
        onfocusout: false,
        onkeyup: false,
        onclick: false,
        rules: {
            name: "required",
            subject: "required",
        },
        messages: {
            name: "Nhập họ tên của bạn",
            email: "Nhập tiêu đề",
        },
        errorElement: "div",
        errorLabelContainer: ".errorTxt",
        invalidHandler: function (event, validator) {
            $("html, body").animate({ scrollTop: 0 }, 500);
        },
    });

    $(".btn-send-contact").on("click", function (event) {
        if (contact_form.valid()) {
            var form = document.getElementById("contactForm");
            var fdnew = new FormData(form);
            contact_form.find(".list-content-loading").show();
            axios({
                method: "POST",
                url: "/ajax/contact",
                data: fdnew,
            })
                .then((res) => {
                    // console.log(res.data);
                    contact_form.find(".error-message").hide();
                    if (res.data.error == 0) {
                        contact_form.find(".modal-body").html(res.data.view);
                    } else {
                        contact_form.find(".list-content-loading").hide();
                        contact_form.find(".error-message").show().html(res.data.msg);
                    }
                })
                .catch((e) => console.log(e));
        }
    });
    //contact ajax
});