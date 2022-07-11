(function ($) {
  'use strict';
  $(function () {
    var body = $('body');
    var contentWrapper = $('.content-wrapper');
    var scroller = $('.container-scroller');
    var footer = $('.footer');
    var sidebar = $('.sidebar');
    var navbar = $('.navbar').not('.top-navbar');


    //Add active class to nav-link based on url dynamically
    //Active class can be hard coded directly in html file also as required

    function addActiveClass(element) {
      if (current === "") {
        //for root url
        if (element.attr('href').indexOf("index.html") !== -1) {
          element.parents('.nav-item').last().addClass('active');
          if (element.parents('.sub-menu').length) {
            element.closest('.collapse').addClass('show');
            element.addClass('active');
          }
        }
      } else {
        //for other url
        if (element.attr('href').indexOf(current) !== -1) {
          element.parents('.nav-item').last().addClass('active');
          if (element.parents('.sub-menu').length) {
            element.closest('.collapse').addClass('show');
            element.addClass('active');
          }
          if (element.parents('.submenu-item').length) {
            element.addClass('active');
          }
        }
      }
    }

    var current = location.pathname.split("/").slice(-1)[0].replace(/^\/|\/$/g, '');
    $('.nav li a', sidebar).each(function () {
      var $this = $(this);
      addActiveClass($this);
    })

    //Close other submenu in sidebar on opening any

    sidebar.on('show.bs.collapse', '.collapse', function () {
      sidebar.find('.collapse.show').collapse('hide');
    });


    //Change sidebar and content-wrapper height
    applyStyles();

    function applyStyles() {
      //Applying perfect scrollbar
    }

    $('[data-toggle="minimize"]').on("click", function () {
      if (body.hasClass('sidebar-toggle-display')) {
        body.toggleClass('sidebar-hidden');
      } else {
        body.toggleClass('sidebar-icon-only');
      }
    });

    //checkbox and radios
    $(".form-check label,.form-radio label").append('<i class="input-helper"></i>');


    // fixed navbar on scroll
    $(window).scroll(function () {
      if (window.matchMedia('(min-width: 991px)').matches) {
        if ($(window).scrollTop() >= 197) {
          $(navbar).addClass('navbar-mini fixed-top');
          $(body).addClass('navbar-fixed-top');
        } else {
          $(navbar).removeClass('navbar-mini fixed-top');
          $(body).removeClass('navbar-fixed-top');
        }
      }
      if (window.matchMedia('(max-width: 991px)').matches) {
        $(navbar).addClass('navbar-mini fixed-top');
        $(body).addClass('navbar-fixed-top');
      }
    });
    //if ($.cookie('spica-free-banner')!="true") {
    //document.querySelector('#proBanner').classList.add('d-flex');
    //}
    //else {
    //document.querySelector('#proBanner').classList.add('d-none');
    //}
    //document.querySelector('#bannerClose').addEventListener('click',function() {
    //document.querySelector('#proBanner').classList.add('d-none');
    //document.querySelector('#proBanner').classList.remove('d-flex');
    //var date = new Date();
    //date.setTime(date.getTime() + 24 * 60 * 60 * 1000); 
    //$.cookie('spica-free-banner', "true", { expires: date });
    //});
  });

  /*==================================================================
    [ Validate ]*/
  var input = $('.validate-input .form-control');

  $('.needs-validation').on('submit', function () {
    var check = true;

    for (var i = 0; i < input.length; i++) {
      if (validate(input[i]) == false) {
        showValidate(input[i]);
        check = false;
      }
    }

    return check;
  });


  $('.needs-validation .form-control').each(function () {
    $(this).focus(function () {
      hideValidate(this);
    });
  });

  function validate(input) {
    if ($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {
      if ($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
        return false;
      }
    }
    else {
      if ($(input).val().trim() == '') {
        return false;
      }
    }
  }

  function showValidate(input) {
    //var thisAlert = $(input).parent();
    //$(thisAlert).addClass('alert-validate');
    $('.needs-validation').addClass('was-validated');
  }

  function hideValidate(input) {
    //var thisAlert = $(input).parent();
    //$(thisAlert).removeClass('alert-validate');
    $('.needs-validation').removeClass('was-validated');

  }
})(jQuery);