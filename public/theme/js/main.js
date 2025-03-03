$(function (){
    var star = '.star',
        selected = '.selected';
  
    $(document).on('click', star, function(){
        if($(this).closest('ul').hasClass('disabled'))
            return false;

        $(selected).each(function(){
          $(this).removeClass('selected');
        });
        $(this).addClass('selected');

        var user_vote = $(this).closest('ul').data('id'),
            vote = $(this).attr('title');
        axios({
            method: 'post',
            url: '/ajax/author-vote',
            data: {
               user_vote:user_vote,
               vote:vote,
            }
        }).then(res => {
            if(res.data.view !='')
            {
                $('.author-vote').html(res.data.view);
            }
        }).catch(e => console.log(e));

    });

    if(!$('.ratings').hasClass('disabled'))
    {
        $('.ratings li').on("mouseover", function(event){
            var myindex =  $(this).index();
            console.log(myindex);
            $('.ratings li').each(function(index){
                if(index < myindex)
                    $(this).addClass('uncheck');
                else
                    $(this).removeClass('uncheck');
            });
        }).on("mouseout", function(event){
            $('.ratings li').removeClass('uncheck');
        })
    }
});

(function () {
    for (var r = document.querySelectorAll(".password-toggle"), e = 0; e < r.length; e++)
        !(function (e) {
            var t = r[e].querySelector(".form-control");
            r[e].querySelector(".password-toggle-btn").addEventListener(
                "click",
                function (e) {
                    "checkbox" === e.target.type && (e.target.checked ? (t.type = "text") : (t.type = "password"));
                    "checkbox" === e.target.type && (e.target.checked ? $(this).find('.fa-regular').removeClass('fa-eye').addClass('fa-eye-slash') : $(this).find('.fa-regular').removeClass('fa-eye-slash').addClass('fa-eye'));
                },
                !1
            );
        })(e);
})();

(function ($) {
    "use strict";

    document.addEventListener('contextmenu', event => event.preventDefault());
    $('body').bind('cut copy', function(e) {
       e.preventDefault();
    });
      
    if($('.tablefilter').length)
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
    $('.select2').select2();
    
    // Initiate the wowjs
    // new WOW().init();


    // Sticky Navbar
    $(window).scroll(function () {
        /*if ($(this).scrollTop() > 300) {
            $('.sticky-top').addClass('shadow-sm').css('top', '0px');
        } else {
            $('.sticky-top').removeClass('shadow-sm').css('top', '-100px');
        }*/
        if ($(this).scrollTop() > 58) {
            $('.header').addClass('sticky-top');
        } else {
            $('.header').removeClass('sticky-top');
        }
    });

    $('.btn-close').click(function() {
        $('.offcanvas-nav').removeClass('collapse show');
    });

    
    
    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });

    // if ($('.xzoom').length)
     // You can try out different effects here
      $(".xzoom, .xzoom-gallery").xzoom({
        // zoomWidth: 400,
        title: false,
        tint: "#333",
        Xoffset: 15
      });
      $(".xzoom2, .xzoom-gallery2").xzoom({
        position: "#xzoom2-id",
        tint: "#ffa200"
      });
      $(".xzoom3, .xzoom-gallery3").xzoom({
        position: "lens",
        lensShape: "circle",
        sourceClass: "xzoom-hidden"
      });
      $(".xzoom4, .xzoom-gallery4").xzoom({ tint: "#006699", Xoffset: 15 });
      $(".xzoom5, .xzoom-gallery5").xzoom({ tint: "#006699", Xoffset: 15 });

      //Integration with hammer.js
      var isTouchSupported = "ontouchstart" in window;

      if (isTouchSupported) {
        //If touch device
        $(".xzoom, .xzoom2, .xzoom3, .xzoom4, .xzoom5").each(function() {
          var xzoom = $(this).data("xzoom");
          xzoom.eventunbind();
        });

        $(".xzoom, .xzoom2, .xzoom3").each(function() {
          var xzoom = $(this).data("xzoom");
          $(this)
            .hammer()
            .on("tap", function(event) {
              event.pageX = event.gesture.center.pageX;
              event.pageY = event.gesture.center.pageY;
              var s = 1,
                ls;

              xzoom.eventmove = function(element) {
                element.hammer().on("drag", function(event) {
                  event.pageX = event.gesture.center.pageX;
                  event.pageY = event.gesture.center.pageY;
                  xzoom.movezoom(event);
                  event.gesture.preventDefault();
                });
              };

              xzoom.eventleave = function(element) {
                element.hammer().on("tap", function(event) {
                  xzoom.closezoom();
                });
              };
              xzoom.openzoom(event);
            });
        });

        $(".xzoom4").each(function() {
          var xzoom = $(this).data("xzoom");
          $(this)
            .hammer()
            .on("tap", function(event) {
              event.pageX = event.gesture.center.pageX;
              event.pageY = event.gesture.center.pageY;
              var s = 1,
                ls;

              xzoom.eventmove = function(element) {
                element.hammer().on("drag", function(event) {
                  event.pageX = event.gesture.center.pageX;
                  event.pageY = event.gesture.center.pageY;
                  xzoom.movezoom(event);
                  event.gesture.preventDefault();
                });
              };

              var counter = 0;
              xzoom.eventclick = function(element) {
                element.hammer().on("tap", function() {
                  counter++;
                  if (counter == 1) setTimeout(openfancy, 300);
                  event.gesture.preventDefault();
                });
              };

              function openfancy() {
                if (counter == 2) {
                  xzoom.closezoom();
                  $.fancybox.open(xzoom.gallery().cgallery);
                } else {
                  xzoom.closezoom();
                }
                counter = 0;
              }
              xzoom.openzoom(event);
            });
        });

        $(".xzoom5").each(function() {
          var xzoom = $(this).data("xzoom");
          $(this)
            .hammer()
            .on("tap", function(event) {
              event.pageX = event.gesture.center.pageX;
              event.pageY = event.gesture.center.pageY;
              var s = 1,
                ls;

              xzoom.eventmove = function(element) {
                element.hammer().on("drag", function(event) {
                  event.pageX = event.gesture.center.pageX;
                  event.pageY = event.gesture.center.pageY;
                  xzoom.movezoom(event);
                  event.gesture.preventDefault();
                });
              };

              var counter = 0;
              xzoom.eventclick = function(element) {
                element.hammer().on("tap", function() {
                  counter++;
                  if (counter == 1) setTimeout(openmagnific, 300);
                  event.gesture.preventDefault();
                });
              };

              function openmagnific() {
                if (counter == 2) {
                  xzoom.closezoom();
                  var gallery = xzoom.gallery().cgallery;
                  var i,
                    images = new Array();
                  for (i in gallery) {
                    images[i] = { src: gallery[i] };
                  }
                  $.magnificPopup.open({
                    items: images,
                    type: "image",
                    gallery: { enabled: true }
                  });
                } else {
                  xzoom.closezoom();
                }
                counter = 0;
              }
              xzoom.openzoom(event);
            });
        });
      } else {
        //If not touch device

        //Integration with fancybox plugin
        $("#xzoom-fancy").bind("click", function(event) {
          var xzoom = $(this).data("xzoom");
          xzoom.closezoom();
          $.fancybox.open(xzoom.gallery().cgallery, {
            padding: 0,
            helpers: { overlay: { locked: false } }
          });
          event.preventDefault();
        });

        //Integration with magnific popup plugin
        $("#xzoom-magnific").bind("click", function(event) {
          var xzoom = $(this).data("xzoom");
          xzoom.closezoom();
          var gallery = xzoom.gallery().cgallery;
          var i,
            images = new Array();
          for (i in gallery) {
            images[i] = { src: gallery[i] };
          }
          $.magnificPopup.open({
            items: images,
            type: "image",
            gallery: { enabled: true }
          });
          event.preventDefault();
        });
      }

      // Fancybox
      $('[data-fancybox="gallery"]').fancybox({
        // Options will go here
      });

      $('.search-keyword li').click(function() {

      $(this).parent().children().each(function(key, item) {
            $(item).removeClass('active');
        });
        $(this).addClass('active');
    });


    // Date and time picker
    if($('.date').length)
        $('.date').datetimepicker({
            format: 'L'
        });
    if($('.time').length)
        $('.time').datetimepicker({
            format: 'LT'
        });


    // Header carousel
    if($(".banner-carousel").length)
    {
      // var $owl = $(element).owlCarousel(options);
      var autoplayDelay = 2000;

      $(".banner-carousel").each(function(){
        var this_ = $(this),
          data = $(this).attr('data'),
          myArray = JSON.parse(data);
        console.log(myArray);
        var item = myArray.item??4,
          tablet_item = myArray.tablet??4,
          mobile_item = myArray.mobile??4,
          dot_ = myArray.dot??false;
        var $owl = $(this).owlCarousel({
          autoplay: true,
          smartSpeed: 1500,
          loop: true,
          nav: false,
          margin:10,
          dots: dot_,
          items: item,
          responsive: {
            0: {
              items: mobile_item
            },
            600: {
              items: tablet_item
            },
            1000: {
              items: item
            }
          }
        });

        if (autoplayDelay) {
         $owl.trigger('stop.owl.autoplay');
         setTimeout(function() {
          $owl.trigger('play.owl.autoplay');
         }, autoplayDelay);
        }

      });
    }
    $(".header-carousel").owlCarousel({
        autoplay: false,
        smartSpeed: 1500,
        loop: true,
        nav: false,
        dots: true,
        items: 1,
        // dotsData: true,
    });


    //Archive carousel
    var archive_slider = $(".archive-slider").owlCarousel({
        autoplay: true,
        smartSpeed: 1500,
        loop: true,
        nav: true,
        nav : true,
        navText : [
            '<i class="bi bi-chevron-left"></i>',
            '<i class="bi bi-chevron-right"></i>'
        ],
        dots: false,
        responsive: {
          0: {
            items: 2
          },
          600: {
            items: 4
          },
          1000: {
            items: 7
          }
        }
    });
    var autoplayDelay = 2000;

    if (autoplayDelay) {
       archive_slider.trigger('stop.owl.autoplay');
       setTimeout(function() {
            archive_slider.trigger('play.owl.autoplay');
            $(".archive-slider").css({opacity:1})
       }, autoplayDelay);
    }


    // Testimonials carousel
    $('.testimonial-carousel').owlCarousel({
        autoplay: true,
        smartSpeed: 1000,
        loop: true,
        nav: false,
        dots: true,
        items: 1,
        dotsData: true,
    });

    var swiper = new Swiper(".partner-slider", {
      slidesPerView: 7,
      loop: false,
      slidesPerGroup: 1,
      loopFillGroupWithBlank: true,
      autoplay: {
        delay: 3000,
      },
      grid: {
        rows: 3,
        fill: "row",
      },
      pagination: {
        el: ".block-partner .swiper-pagination",
        clickable: true,
      },
      breakpoints: {
        280: {
          slidesPerView: 2,
          grid: {
            rows: 2,
            fill: "row",
          },
          
        },
        320: {
          slidesPerView: 2,
          grid: {
            rows: 2,
            fill: "row",
          },
          
        },
        768: {
          slidesPerView: 7,
          grid: {
            rows: 3,
            fill: "row",
          },
          
        },
        1024: {
          slidesPerView: 7,
          grid: {
            rows: 3,
            fill: "row",
          },
          
        },
      }, 
    });
        

      $('.show-more-product').hide();

        $('.load-more').click(function(){
            $('.show-more-product').show(300);
            $('.load-less').show();
            $('.load-more').hide();
        });

        $('.load-less').click(function(){
            $('.show-more-product').hide(150);
            $('.load-more').show();
            $(this).hide();
        });

        if($('#newletter-form').length) {
            $("#newletter-form").validate({
                rules: {
                  name : {
                    required: true,
                    minlength: 3
                  },
                  tel: {
                    required: true,
                    number: true,
                  },
                  email: {
                    required: true,
                    email: true
                  }
                },
                messages : {
                  name: {
                    minlength: "Tên phải có ít nhất 3 ký tự",
                    required: "Vui lòng nhập họ tên của bạn",
                  },
                  tel: {
                    required: "Vui lòng nhập số điện thoại",
                    number: "Vui lòng nhập số điện thoại của bạn dưới dạng giá trị số",
                  },
                  email: {
                    email: "Vui lòng nhập email của bạn theo dạng: abc@domain.tld",
                    required: "Vui lòng nhập email của bạn",
                  },
                }
            });
        }
    
    $(document).on('click', '.save-post', function(){
      var id = $(this).attr('data');
      $(this).parent().find('.save-post').tooltip('hide');
      axios({
          method: 'post',
          url: '/ajax/save-post',
          data: {
             id:id
          }
       }).then(res => {
          if(res.data.view !='' && res.data.status =='success'){
            $(this).parent().html(res.data.view);
            $('.sub_number').show().text(res.data.count_wishlist);
          }
       }).catch(e => console.log(e));
       return false;
    });
    $(document).on('click', '.remove-wishlist', function(){
      var id = $(this).attr('data');
      axios({
          method: 'post',
          url: '/ajax/save-post',
          data: {
             id:id
          }
       }).then(res => {
          if(res.data.view !='' && res.data.status =='success'){
            $('.sub_number').show().text(res.data.count_wishlist);
            $(this).parent().remove();
          }
       }).catch(e => console.log(e));
       return false;
    });
    $(document).on('click', '.show-phone', function(){
      var id = $(this).data('id'),
        this_ = $(this);
      axios({
          method: 'post',
          url: '/ajax/show-phone',
          data: {
             id:id
          }
       }).then(res => {
          if(res.data)
          {
            this_.parent().find('.show-phone-text').text(res.data);
            this_.removeClass('show-phone');
            this_.addClass('copy-phone').attr('title', res.data).text('Sao chép');
            this_.attr('data-phone', res.data);
          }
       }).catch(e => console.log(e));
       return false;
    });
    $(document).on('click', '.copy-phone', function(){
      var phone = $(this).attr('data-phone');
      console.log(phone);
      copyToClipboard(phone);
    })
    function copyToClipboard(text_) {
      var $temp = $("<input>");
      $("body").append($temp);
      $temp.val(text_).select();
      document.execCommand("copy");
      $temp.remove();
    }

    $('.seaport').select2({
          minimumInputLength: 2,
          tags: [],
          ajax: {
              url: '/location/search-place',
              dataType: 'json',
              type: "Post",
              quietMillis: 500,
              data: function (term) {
                  return {
                      _token: $('meta[name="csrf-token"]').attr('content'),
                      keyword: term.term
                  };
              },
              processResults: function (data) {
                  return {
                      results: $.map(data, function (item) {
                          return {
                              text: item.label,
                              id: item.label
                          }
                      })
                  };
              }
          }
      
      });

    $('.copy').click(function(){
      // var value = $(this).attr('data');
      copyToClipboard($(this));
    });
    function copyToClipboard(element) {
      var $temp = $("<input>");
      $("body").append($temp);
      $temp.val(element.attr('data')).select();
      document.execCommand("copy");
      $temp.remove();
      element.addClass('active');
    }
})(jQuery);

/*** Search form ***/

window.onload = function() {
    cat_select();
}

var Navegador_ = (window.navigator.userAgent || window.navigator.vendor || window.opera),
    Firfx = /Firefox/i.test(Navegador_),
    Mobile_ = /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(Navegador_),
    FirfoxMobile = (Firfx && Mobile_);

var li = new Array();

function cat_select() {
    var div_cont_select = document.querySelectorAll("[data-mate-select='active']");
    var select_ = '';
    for (var e = 0; e < div_cont_select.length; e++) {
        div_cont_select[e].setAttribute('data-indx-select', e);
        div_cont_select[e].setAttribute('data-selec-open', 'false');
        var ul_cont = document.querySelectorAll("[data-indx-select='" + e + "'] > .cont_list_select_mate > ul");
        select_ = document.querySelectorAll("[data-indx-select='" + e + "'] >select")[0];
        if (Mobile_ || FirfoxMobile) {
            select_.addEventListener('change', function() {
                _select_option(select_.selectedIndex, e);
            });
        }
        var select_optiones = select_.options;
        document.querySelectorAll("[data-indx-select='" + e + "']  > .selection_option ")[0].setAttribute('data-n-select', e);
        document.querySelectorAll("[data-indx-select='" + e + "']  > .icon_select_mate ")[0].setAttribute('data-n-select', e);
        for (var i = 0; i < select_optiones.length; i++) {
            li[i] = document.createElement('li');
            if (select_optiones[i].selected == true || select_.value == select_optiones[i].innerHTML) {
                li[i].className = 'active';
                document.querySelector("[data-indx-select='" + e + "']  > .selection_option ").innerHTML = select_optiones[i].innerHTML;
            };
            li[i].setAttribute('data-index', i);
            li[i].setAttribute('data-selec-index', e);
            // funcion click al selecionar 
            li[i].addEventListener('click', function() { _select_option(this.getAttribute('data-index'), this.getAttribute('data-selec-index')); });

            li[i].innerHTML = select_optiones[i].innerHTML;
            ul_cont[0].appendChild(li[i]);

        }; // Fin For select_optiones
    }; // fin for divs_cont_select
} // Fin Function 



var cont_slc = 0;

function open_select(idx) {
    var idx1 = idx.getAttribute('data-n-select');
    var ul_cont_li = document.querySelectorAll("[data-indx-select='" + idx1 + "'] .cont_select_int > li");
    var hg = 0;
    var slect_open = document.querySelectorAll("[data-indx-select='" + idx1 + "']")[0].getAttribute('data-selec-open');
    var slect_element_open = document.querySelectorAll("[data-indx-select='" + idx1 + "'] select")[0];
    if (Mobile_ || FirfoxMobile) {
        if (window.document.createEvent) { // All
            var evt = window.document.createEvent("MouseEvents");
            evt.initMouseEvent("mousedown", false, true, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
            slect_element_open.dispatchEvent(evt);
        } else if (slect_element_open.fireEvent) { // IE
            slect_element_open.fireEvent("onmousedown");
        }
    } else {


        for (var i = 0; i < ul_cont_li.length; i++) {
            hg += ul_cont_li[i].offsetHeight;
        };
        if (slect_open == 'false') {
            document.querySelectorAll("[data-indx-select='" + idx1 + "']")[0].setAttribute('data-selec-open', 'true');
            document.querySelectorAll("[data-indx-select='" + idx1 + "'] > .cont_list_select_mate > ul")[0].style.height = hg + "px";
          document.querySelectorAll("[data-indx-select='" + idx1 + "'] > .cont_list_select_mate > ul")[0].style.border = "1px solid #d9d9d9";
            // document.querySelectorAll("[data-indx-select='"+idx1+"'] > .icon_select_mate")[0].style.transform = 'rotate(180deg)';
        } else {
            document.querySelectorAll("[data-indx-select='" + idx1 + "']")[0].setAttribute('data-selec-open', 'false');
            // document.querySelectorAll("[data-indx-select='"+idx1+"'] > .icon_select_mate")[0].style.transform = 'rotate(0deg)';
            document.querySelectorAll("[data-indx-select='" + idx1 + "'] > .cont_list_select_mate > ul")[0].style.height = "0px";
          document.querySelectorAll("[data-indx-select='" + idx1 + "'] > .cont_list_select_mate > ul")[0].style.border = "1px solid transparent";
        }
    }

} // fin function open_select

function salir_select(indx) {
    var select_ = document.querySelectorAll("[data-indx-select='" + indx + "'] > select")[0];
    document.querySelectorAll("[data-indx-select='" + indx + "'] > .cont_list_select_mate > ul")[0].style.height = "0px";
    document.querySelector("[data-indx-select='" + indx + "'] > .icon_select_mate").style.transform = 'rotate(0deg)';
    document.querySelectorAll("[data-indx-select='" + indx + "']")[0].setAttribute('data-selec-open', 'false');
   document.querySelectorAll("[data-indx-select='" + indx + "'] > .cont_list_select_mate > ul")[0].style.border = "1px solid transparent";
}


function _select_option(indx, selc) {
    if (Mobile_ || FirfoxMobile) {
        selc = selc - 1;
    }
    var select_ = document.querySelectorAll("[data-indx-select='" + selc + "'] > select")[0];

    var li_s = document.querySelectorAll("[data-indx-select='" + selc + "'] .cont_select_int > li");
    var p_act = document.querySelectorAll("[data-indx-select='" + selc + "'] > .selection_option")[0].innerHTML = li_s[indx].innerHTML;
    var select_optiones = document.querySelectorAll("[data-indx-select='" + selc + "'] > select > option");
    for (var i = 0; i < li_s.length; i++) {
        if (li_s[i].className == 'active') {
            li_s[i].className = '';
        };
        li_s[indx].className = 'active';

    };
    select_optiones[indx].selected = true;
    select_.selectedIndex = indx;
    select_.onchange();
    salir_select(selc);
  
}