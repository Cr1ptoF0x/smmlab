(function ($) {
  ("use strict");

  // ============== Header Hide Click On Body Js Start ========
  $(".header-button").on("click", function () {
    $(".body-overlay").toggleClass("show");
  });
  $(".body-overlay").on("click", function () {
    $(".header-button").trigger("click");
    $(this).removeClass("show");
  });
  // =============== Header Hide Click On Body Js End =========

  // ==========================================
  //      Start Document Ready function
  // ==========================================
  $(document).ready(function () {
    // ========================== Header Hide Scroll Bar Js Start =====================
    $(".navbar-toggler.header-button").on("click", function () {
      $("body").toggleClass("scroll-hide-sm");
    });
    $(".body-overlay").on("click", function () {
      $("body").removeClass("scroll-hide-sm");
    });
    // ========================== Header Hide Scroll Bar Js End =====================

    // ========================== Small Device Header Menu On Click Dropdown menu collapse Stop Js Start =====================
    $(".dropdown-item").on("click", function () {
      $(this).closest(".dropdown-menu").addClass("d-block");
    });
    // ========================== Small Device Header Menu On Click Dropdown menu collapse Stop Js End =====================

    // ========================== Add Attribute For Bg Image Js Start =====================
    $(".bg-img").css("background", function () {
      var bg = "url(" + $(this).data("background-image") + ")";
      return bg;
    });
    // ========================== Add Attribute For Bg Image Js End =====================

    // ========================== add active class to ul>li top Active current page Js Start =====================
    function dynamicActiveMenuClass(selector) {
      let fileName = window.location.pathname.split("/").reverse()[0];
      selector.find("li").each(function () {
        let anchor = $(this).find("a");
        if ($(anchor).attr("href") == fileName) {
          $(this).addClass("active");
        }
      });
      // if any li has active element add class
      selector.children("li").each(function () {
        if ($(this).find(".active").length) {
          $(this).addClass("active");
        }
      });
      // if no file name return
      if ("" == fileName) {
        selector.find("li").eq(0).addClass("active");
      }
    }
    if ($("ul.primary-nav").length) {
      dynamicActiveMenuClass($("ul.primary-nav"));
    }
    // ========================== add active class to ul>li top Active current page Js End =====================

    // ================== Password Show Hide Js Start ==========
    $(".toggle-password").on("click", function () {
      $(this).toggleClass(" fa-eye-slash");
      var input = $($(this).attr("id"));
      if (input.attr("type") == "password") {
        input.attr("type", "text");
      } else {
        input.attr("type", "password");
      }
    });
    // =============== Password Show Hide Js End =================


    // Sidebar Icon & Overlay js
    $(".navigation-bar").on("click", function () {
      $(".sidebar-menu").addClass("show-sidebar");
      $(".sidebar-overlay").addClass("show");
    });
    $(".sidebar-menu__close, .sidebar-overlay").on("click", function () {
      $(".sidebar-menu").removeClass("show-sidebar");
      $(".sidebar-overlay").removeClass("show");
    });
    // Sidebar Icon & Overlay js

    // Dashboad Sidebar Icon & Overlay js 
    $(".sidebar_menu_btn").on("click", function () {
      $(".sidebar-menu").addClass('show');
      $(".sidebar-overlay").addClass('show');
    });
    $(".sidebar-menu__close, .sidebar-overlay").on("click", function () {
      $(".sidebar-menu").removeClass('show');
      $(".sidebar-overlay").removeClass('show');
    });
    // ===================== Sidebar Menu Js End =================

    $(".has-dropdown > a").on("click", function () {
      if ($(this).parent().find(".sidebar-submenu").length) {
        if ($(this).parent().find(".sidebar-submenu").first().is(":visible")) {
          $(this).find(".side-menu__sub-icon").removeClass("transform rotate-180");
          $(this).removeClass("side-menu--open");
          $(this)
            .parent()
            .find(".sidebar-submenu")
            .first()
            .slideUp({
              done: function done() {
                $(this).removeClass("sidebar-submenu__open");
              },
            });
        } else {
          $(this).find(".side-menu__sub-icon").addClass("transform rotate-180");
          $(this).addClass("side-menu--open");
          $(this)
            .parent()
            .find(".sidebar-submenu")
            .first()
            .slideDown({
              done: function done() {
                $(this).addClass("sidebar-submenu__open");
              },
            });
        }
      }
    });

    // ========================= Odometer Counter Up Js End ==========
    $(".counterup-item").each(function () {
      $(this).isInViewport(function (status) {
        if (status === "entered") {
          for (
            var i = 0;
            i < document.querySelectorAll(".odometer").length;
            i++
          ) {
            var el = document.querySelectorAll(".odometer")[i];
            el.innerHTML = el.getAttribute("data-odometer-final");
          }
        }
      });
    });
    // ========================= Odometer Up Counter Js End =====================

  });
  // ==========================================
  //      End Document Ready function
  // ==========================================

  // ========================= Preloader Js Start =====================
  $(window).on("load", function () {
    $(".preloader").fadeOut();
  });
  // ========================= Preloader Js End=====================

  // ========================= Header Sticky Js Start ==============
  $(window).on("scroll", function () {
    if ($(window).scrollTop() >= 300) {
      $(".header").addClass("fixed-header");
    } else {
      $(".header").removeClass("fixed-header");
    }
  });
  // ========================= Header Sticky Js End===================

  //============================ Scroll To Top Icon Js Start =========
  var btn = $(".scroll-top");

  $(window).scroll(function () {
    if ($(window).scrollTop() > 300) {
      btn.addClass("show");
    } else {
      btn.removeClass("show");
    }
  });

  btn.on("click", function (e) {
    e.preventDefault();
    $("html, body").animate({ scrollTop: 0 }, "300");
  });

  //========================= Custom select Js Start =====================
  const dropdownMainSelectColor = $("#edit-selected-color");
  const dropdownMainSelectName = $("#edit-selected-name");
  $(".single-color-list").on("click", function () {
    const getElementBg = this.children[0].getAttribute("data-bg-color");
    dropdownMainSelectColor.css("background-color", getElementBg);
    dropdownMainSelectName.text(this.innerText);
  });
  // color section
  $(".option-color").css("background", function () {
    return $(this).data("bg-color");
  });


  let elements = document.querySelectorAll('[s-break]');
  Array.from(elements).forEach(element => {
    let html = element.innerHTML;
    if (typeof html != 'string') {
      return false;
    }
    let breakLength = parseInt(element.getAttribute('s-break'));
    html = html.split(" ");
    var colorText = [];
    if (breakLength < 0) {
      colorText = html.slice(breakLength);
    } else {
      colorText = html.slice(0, breakLength);
    }
    let solidText = [];
    html.filter(ele => {
      if (!colorText.includes(ele)) {
        solidText.push(ele);
      }
    });
    var color = element.getAttribute('pill');
    colorText = `<span class="${color}">${colorText.toString().replaceAll(',', ' ')}</span>`;
    solidText = solidText.toString().replaceAll(',', ' ');
    breakLength < 0 ? element.innerHTML = `${solidText} ${colorText}` : element.innerHTML = `${colorText} ${solidText}`
  });


  //table-data-label
  Array.from(document.querySelectorAll("table")).forEach((table) => {
    let headings = table.querySelectorAll("thead tr th");
    Array.from(table.querySelectorAll("tbody tr")).forEach((row) => {
      Array.from(row.querySelectorAll("td")).forEach((column, i) => {
        if (headings[i]) {
          column.setAttribute("data-label", headings[i].innerText);
        }
      });
    });
  });

  $(".showFilterBtn").on("click", function () {
    $(".responsive-filter-card").slideToggle();
  });

  $.each($('input,select,textarea'), function (i, element) {
    let elementType = $(element);
    if (elementType.attr('type') != 'checkbox') {
      if (element.hasAttribute('required')) {
        $(element).closest('.form-group').find('label').addClass('required');
      }
    }
  })


})(jQuery);
