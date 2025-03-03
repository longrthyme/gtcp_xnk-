var form_checkout = '';
jQuery(document).ready(function($) {
  $(document).ready(function() {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
  });

  // console.log(strip_key);
	form_checkout = $("#form-checkout");
	form_checkout.validate({
          onfocusout: false,
          onkeyup: false,
          onclick: false,
          rules: {
              firstname: "required",
              lastname: "required",
              phone: "required",
              email: "required",
              state_province: "required",
              postal_code: "required",
              city_locality: "required",
              address_line1: "required",
          },
          messages: {
        	firstname: "Enter First name",
        	lastname: "Enter Last name",
              phone: "Enter Phone",
              email: "Enter Email",
              state_province: "Choise State",
              postal_code: "Enter postal code",
              city_locality: "Enter City",
              address_line1: "Enter address",
          },
          errorElement : 'div',
          errorLabelContainer: '.errorTxt',
          invalidHandler: function(event, validator) {
              $('html, body').animate({
                  scrollTop: 0
              }, 500);
          }
    });

    $(document).on('click', '.submit-confirm', function(event) {
    	if(form_checkout.valid()){
        form_checkout.submit();
    	}
    });

    $(document).on('click', '.submit-checkout', function(event) {
      if(form_checkout.valid()){
        var check_payment = $('input[name="payment_method"]:checked').val();
        if(check_payment == 'credit_cart'){
          var shipping_cost = $('input[name="shipping_cost"]').val(),
            cart_total = $('input[name="cart_total"]').val(),
            amount = shipping_cost + cart_total;
          
          var handler = StripeCheckout.configure({
              key: strip_key, // your publisher key id
              locale: 'auto',
              token: function(token) {
                  // You can access the token ID with `token.id`.
                  // Get the token ID to your server-side code for use.
                  // $('#res_token').html(JSON.stringify(token));
                  $('#res_token').val(token.id);
                  var form = document.getElementById('form-checkout');
                  var formData = new FormData(form);
                  axios({
                    method: 'post',
                    url: '/payment/stripe',
                    data: formData
                  }).then(res => {
                    window.location.href = '/payment-success/'+ res.data.order_id;
                  })
                  .catch(function (error) {
                    console.log(error);
                  });
                  /*$.ajax({
                      url: '/payment/stripe',
                      method: 'post',
                      data: {
                          tokenId: token.id,
                          amount: amount
                      },
                      success: (response) => {
                          $(".img_loading").show();
                          if(response){
                              window.location.href = '/paymentsuccess';
                          }
                      },
                      error: (error) => {
                          console.log(error);
                          alert('Oops! Something went wrong')
                      }
                  })*/
              }
          });
          handler.open({
              name: 'Payment Visa or Master card',
              description: 'Payment order',
              amount: amount * 100
          });
        }
        else
          form_checkout.submit();
      }
    });
    
    $(document).on('click', '.get_shipping_cost', function(event) {
      var this_ = $(this);
      if(form_checkout.valid()){
        this_.text('Loadding...');
        var form = document.getElementById('form-checkout');
        var formData = new FormData(form);

        axios({
          method: 'post',
          url: 'ajax/get-shipping-cost',
          data: formData
        }).then(res => {
            $(this).text(this_.attr('title'));
            if(res.data.error ==0)
            {
              $('.shipping_cost').text(res.data.shipment_amount);
              $('input[name="shipping_cost"]').val(res.data.shipping_cost);
              $('.cart_total').text(res.data.cart_total);
              // $('.cart-btn').html('<button class="btn submit-checkout" value="Place order" type="button">Place order</button>');
              $('.msg-error').hide();
              $('.get_shipping_cost').hide();
                $('.submit-checkout').show();
            }else{
              $('.msg-error').html(res.data.msg).show();
              $('.get_shipping_cost').show();
              // $('.cart-btn').html('<button type="button" class="btn btn-info get_shipping_cost">Continue to shipping</button>');
            }
        })
        .catch(function (error) {
          this_.text(this_.attr('title'));
          if (error.response) {
            $('.get_shipping_cost').show();
                $('.submit-checkout').hide();
            $('.msg-error').html(error.response.data.message).show();
            // Request made and server responded
            /*console.log(error.response.data);
            console.log(error.response.status);
            console.log(error.response.headers);*/
          } else if (error.request) {
            // The request was made but no response was received
            // console.log(error.request);
          } else {
            // Something happened in setting up the request that triggered an Error
            // console.log('Error', error.message);
          }

        });
      }
    });
});

