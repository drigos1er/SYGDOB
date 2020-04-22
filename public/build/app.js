(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["app"],{

/***/ "./assets/js/app.js":
/*!**************************!*\
  !*** ./assets/js/app.js ***!
  \**************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! core-js/modules/es.array.find */ "./node_modules/core-js/modules/es.array.find.js");

__webpack_require__(/*! core-js/modules/es.date.to-string */ "./node_modules/core-js/modules/es.date.to-string.js");

// Admin Panel settings
$.fn.AdminSettings = function (settings) {
  var myid = this.attr("id"); // General option for vertical header 

  var defaults = {
    Theme: true,
    // this can be true or false ( true means dark and false means light ),
    Layout: 'vertical',
    // 
    LogoBg: 'skin1',
    // You can change the Value to be skin1/skin2/skin3/skin4/skin5/skin6 
    NavbarBg: 'skin6',
    // You can change the Value to be skin1/skin2/skin3/skin4/skin5/skin6 
    SidebarType: 'full',
    // You can change it full / mini-sidebar
    SidebarColor: 'skin1',
    // You can change the Value to be skin1/skin2/skin3/skin4/skin5/skin6
    SidebarPosition: false,
    // it can be true / false
    HeaderPosition: false,
    // it can be true / false
    BoxedLayout: false // it can be true / false 

  };
  var settings = $.extend({}, defaults, settings); // Attribute functions 

  var AdminSettings = {
    // Settings INIT
    AdminSettingsInit: function AdminSettingsInit() {
      AdminSettings.ManageTheme();
      AdminSettings.ManageThemeLayout();
      AdminSettings.ManageThemeBackground();
      AdminSettings.ManageSidebarType();
      AdminSettings.ManageSidebarColor();
      AdminSettings.ManageSidebarPosition();
      AdminSettings.ManageBoxedLayout();
    },
    //****************************
    // ManageThemeLayout functions
    //****************************
    ManageTheme: function ManageTheme() {
      var themeview = settings.Theme;

      switch (settings.Layout) {
        case 'vertical':
          if (themeview == true) {
            $('body').attr("data-theme", 'dark');
            $("#theme-view").prop("checked", !0);
          } else {
            $('#' + myid).attr("data-theme", 'light');
            $("body").prop("checked", !1);
          }

          break;

        default:
      }
    },
    //****************************
    // ManageThemeLayout functions
    //****************************
    ManageThemeLayout: function ManageThemeLayout() {
      switch (settings.Layout) {
        case 'horizontal':
          $('#' + myid).attr("data-layout", "horizontal");

          var setperfectscrollhorizontal = function setperfectscrollhorizontal() {
            var width = window.innerWidth > 0 ? window.innerWidth : this.screen.width;

            if (width < 768) {
              $('.scroll-sidebar').perfectScrollbar({});
            } else {
              $('.scroll-sidebar').perfectScrollbar('destroy');
            }
          };

          $(window).ready(setperfectscrollhorizontal);
          $(window).on("resize", setperfectscrollhorizontal);
          break;

        case 'vertical':
          $('#' + myid).attr("data-layout", "vertical");
          $('.scroll-sidebar').perfectScrollbar({});
          break;

        default:
      }
    },
    //****************************
    // ManageSidebarType functions 
    //****************************
    ManageThemeBackground: function ManageThemeBackground() {
      // Logo bg attribute
      function setlogobg() {
        var lbg = settings.LogoBg;

        if (lbg != undefined && lbg != "") {
          $('#' + myid + ' .topbar .top-navbar .navbar-header').attr("data-logobg", lbg);
        } else {
          $('#' + myid + ' .topbar .top-navbar .navbar-header').attr("data-logobg", "skin1");
        }
      }

      ;
      setlogobg(); // Navbar bg attribute

      function setnavbarbg() {
        var nbg = settings.NavbarBg;

        if (nbg != undefined && nbg != "") {
          $('#' + myid + ' .topbar .navbar-collapse').attr("data-navbarbg", nbg);
          $('#' + myid + ' .topbar').attr("data-navbarbg", nbg);
          $('#' + myid).attr("data-navbarbg", nbg);
        } else {
          $('#' + myid + ' .topbar .navbar-collapse').attr("data-navbarbg", "skin1");
          $('#' + myid + ' .topbar').attr("data-navbarbg", "skin1");
          $('#' + myid).attr("data-navbarbg", "skin1");
        }
      }

      ;
      setnavbarbg();
    },
    //****************************
    // ManageThemeLayout functions
    //****************************
    ManageSidebarType: function ManageSidebarType() {
      switch (settings.SidebarType) {
        //****************************
        // If the sidebar type has full
        //****************************     
        case 'full':
          $('#' + myid).attr("data-sidebartype", "full"); //****************************

          /* This is for the mini-sidebar if width is less then 1170*/
          //**************************** 

          var setsidebartype = function setsidebartype() {
            var width = window.innerWidth > 0 ? window.innerWidth : this.screen.width;

            if (width < 1170) {
              $("#main-wrapper").attr("data-sidebartype", "mini-sidebar");
              $("#main-wrapper").addClass("mini-sidebar");
            } else {
              $("#main-wrapper").attr("data-sidebartype", "full");
              $("#main-wrapper").removeClass("mini-sidebar");
            }
          };

          $(window).ready(setsidebartype);
          $(window).on("resize", setsidebartype); //****************************

          /* This is for sidebartoggler*/
          //****************************

          $('.sidebartoggler').on("click", function () {
            $("#main-wrapper").toggleClass("mini-sidebar");

            if ($("#main-wrapper").hasClass("mini-sidebar")) {
              $(".sidebartoggler").prop("checked", !0);
              $("#main-wrapper").attr("data-sidebartype", "mini-sidebar");
            } else {
              $(".sidebartoggler").prop("checked", !1);
              $("#main-wrapper").attr("data-sidebartype", "full");
            }
          });
          break;
        //****************************
        // If the sidebar type has mini-sidebar
        //****************************       

        case 'mini-sidebar':
          $('#' + myid).attr("data-sidebartype", "mini-sidebar"); //****************************

          /* This is for sidebartoggler*/
          //****************************

          $('.sidebartoggler').on("click", function () {
            $("#main-wrapper").toggleClass("mini-sidebar");

            if ($("#main-wrapper").hasClass("mini-sidebar")) {
              $(".sidebartoggler").prop("checked", !0);
              $("#main-wrapper").attr("data-sidebartype", "full");
            } else {
              $(".sidebartoggler").prop("checked", !1);
              $("#main-wrapper").attr("data-sidebartype", "mini-sidebar");
            }
          });
          break;
        //****************************
        // If the sidebar type has iconbar
        //****************************       

        case 'iconbar':
          $('#' + myid).attr("data-sidebartype", "iconbar"); //****************************

          /* This is for the mini-sidebar if width is less then 1170*/
          //**************************** 

          var setsidebartype = function setsidebartype() {
            var width = window.innerWidth > 0 ? window.innerWidth : this.screen.width;

            if (width < 1170) {
              $("#main-wrapper").attr("data-sidebartype", "mini-sidebar");
              $("#main-wrapper").addClass("mini-sidebar");
            } else {
              $("#main-wrapper").attr("data-sidebartype", "iconbar");
              $("#main-wrapper").removeClass("mini-sidebar");
            }
          };

          $(window).ready(setsidebartype);
          $(window).on("resize", setsidebartype); //****************************

          /* This is for sidebartoggler*/
          //****************************

          $('.sidebartoggler').on("click", function () {
            $("#main-wrapper").toggleClass("mini-sidebar");

            if ($("#main-wrapper").hasClass("mini-sidebar")) {
              $(".sidebartoggler").prop("checked", !0);
              $("#main-wrapper").attr("data-sidebartype", "mini-sidebar");
            } else {
              $(".sidebartoggler").prop("checked", !1);
              $("#main-wrapper").attr("data-sidebartype", "iconbar");
            }
          });
          break;
        //****************************
        // If the sidebar type has overlay
        //****************************       

        case 'overlay':
          $('#' + myid).attr("data-sidebartype", "overlay");

          var setsidebartype = function setsidebartype() {
            var width = window.innerWidth > 0 ? window.innerWidth : this.screen.width;

            if (width < 767) {
              $("#main-wrapper").attr("data-sidebartype", "mini-sidebar");
              $("#main-wrapper").addClass("mini-sidebar");
            } else {
              $("#main-wrapper").attr("data-sidebartype", "overlay");
              $("#main-wrapper").removeClass("mini-sidebar");
            }
          };

          $(window).ready(setsidebartype);
          $(window).on("resize", setsidebartype); //****************************

          /* This is for sidebartoggler*/
          //****************************

          $('.sidebartoggler').on("click", function () {
            $("#main-wrapper").toggleClass("show-sidebar");

            if ($("#main-wrapper").hasClass("show-sidebar")) {//$(".sidebartoggler").prop("checked", !0);
              //$("#main-wrapper").attr("data-sidebartype","mini-sidebar");
            } else {//$(".sidebartoggler").prop("checked", !1);
                //$("#main-wrapper").attr("data-sidebartype","iconbar");
              }
          });
          break;

        default:
      }
    },
    //****************************
    // ManageSidebarColor functions 
    //****************************
    ManageSidebarColor: function ManageSidebarColor() {
      // Logo bg attribute
      function setsidebarbg() {
        var sbg = settings.SidebarColor;

        if (sbg != undefined && sbg != "") {
          $('#' + myid + ' .left-sidebar').attr("data-sidebarbg", sbg);
        } else {
          $('#' + myid + ' .left-sidebar').attr("data-sidebarbg", "skin1");
        }
      }

      ;
      setsidebarbg();
    },
    //****************************
    // ManageSidebarPosition functions
    //****************************
    ManageSidebarPosition: function ManageSidebarPosition() {
      var sidebarposition = settings.SidebarPosition;
      var headerposition = settings.HeaderPosition;

      switch (settings.Layout) {
        case 'vertical':
          if (sidebarposition == true) {
            $('#' + myid).attr("data-sidebar-position", 'fixed');
            $("#sidebar-position").prop("checked", !0);
          } else {
            $('#' + myid).attr("data-sidebar-position", 'absolute');
            $("#sidebar-position").prop("checked", !1);
          }

          if (headerposition == true) {
            $('#' + myid).attr("data-header-position", 'fixed');
            $("#header-position").prop("checked", !0);
          } else {
            $('#' + myid).attr("data-header-position", 'relative');
            $("#header-position").prop("checked", !1);
          }

          break;

        case 'horizontal':
          if (sidebarposition == true) {
            $('#' + myid).attr("data-sidebar-position", 'fixed');
            $("#sidebar-position").prop("checked", !0);
          } else {
            $('#' + myid).attr("data-sidebar-position", 'absolute');
            $("#sidebar-position").prop("checked", !1);
          }

          if (headerposition == true) {
            $('#' + myid).attr("data-header-position", 'fixed');
            $("#header-position").prop("checked", !0);
          } else {
            $('#' + myid).attr("data-header-position", 'relative');
            $("#header-position").prop("checked", !1);
          }

          break;

        default:
      }
    },
    //****************************
    // ManageBoxedLayout functions
    //****************************
    ManageBoxedLayout: function ManageBoxedLayout() {
      var boxedlayout = settings.BoxedLayout;

      switch (settings.Layout) {
        case 'vertical':
          if (boxedlayout == true) {
            $('#' + myid).attr("data-boxed-layout", 'boxed');
            $("#boxed-layout").prop("checked", !0);
          } else {
            $('#' + myid).attr("data-boxed-layout", 'full');
            $("#boxed-layout").prop("checked", !1);
          }

          break;

        case 'horizontal':
          if (boxedlayout == true) {
            $('#' + myid).attr("data-boxed-layout", 'boxed');
            $("#boxed-layout").prop("checked", !0);
          } else {
            $('#' + myid).attr("data-boxed-layout", 'full');
            $("#boxed-layout").prop("checked", !1);
          }

          break;

        default:
      }
    }
  };
  AdminSettings.AdminSettingsInit();
}; //****************************
// This is for the chat customizer setting
//****************************


$(function () {
  var chatarea = $("#chat");
  $('#chat .message-center a').on('click', function () {
    var name = $(this).find(".mail-contnet h5").text();
    var img = $(this).find(".user-img img").attr("src");
    var id = $(this).attr("data-user-id");
    var status = $(this).find(".profile-status").attr("data-status");

    if ($(this).hasClass("active")) {
      $(this).toggleClass("active");
      $(".chat-windows #user-chat" + id).hide();
    } else {
      $(this).toggleClass("active");

      if ($(".chat-windows #user-chat" + id).length) {
        $(".chat-windows #user-chat" + id).removeClass("mini-chat").show();
      } else {
        var msg = msg_receive('I watched the storm, so beautiful yet terrific.');
        msg += msg_sent('That is very deep indeed!');
        var html = "<div class='user-chat' id='user-chat" + id + "' data-user-id='" + id + "'>";
        html += "<div class='chat-head'><img src='" + img + "' data-user-id='" + id + "'><span class='status " + status + "'></span><span class='name'>" + name + "</span><span class='opts'><i class='ti-close closeit' data-user-id='" + id + "'></i><i class='ti-minus mini-chat' data-user-id='" + id + "'></i></span></div>";
        html += "<div class='chat-body'><ul class='chat-list'>" + msg + "</ul></div>";
        html += "<div class='chat-footer'><input type='text' data-user-id='" + id + "' placeholder='Type & Enter' class='form-control'></div>";
        html += "</div>";
        $(".chat-windows").append(html);
      }
    }
  });
  $(document).on('click', ".chat-windows .user-chat .chat-head .closeit", function (e) {
    var id = $(this).attr("data-user-id");
    $(".chat-windows #user-chat" + id).hide();
    $("#chat .message-center .user-info#chat_user_" + id).removeClass("active");
  });
  $(document).on('click', ".chat-windows .user-chat .chat-head img, .chat-windows .user-chat .chat-head .mini-chat", function (e) {
    var id = $(this).attr("data-user-id");

    if (!$(".chat-windows #user-chat" + id).hasClass("mini-chat")) {
      $(".chat-windows #user-chat" + id).addClass("mini-chat");
    } else {
      $(".chat-windows #user-chat" + id).removeClass("mini-chat");
    }
  });
  $(document).on('keypress', ".chat-windows .user-chat .chat-footer input", function (e) {
    if (e.keyCode == 13) {
      var id = $(this).attr("data-user-id");
      var msg = $(this).val();
      msg = msg_sent(msg);
      $(".chat-windows #user-chat" + id + " .chat-body .chat-list").append(msg);
      $(this).val("");
      $(this).focus();
    }

    $(".chat-windows #user-chat" + id + " .chat-body").perfectScrollbar({
      suppressScrollX: true
    });
  });
  $(".page-wrapper").on('click', function (e) {
    $('.chat-windows').addClass('hide-chat');
    $('.chat-windows').removeClass('show-chat');
  });
  $(".service-panel-toggle").on('click', function (e) {
    $('.chat-windows').addClass('show-chat');
    $('.chat-windows').removeClass('hide-chat');
  });
});

function msg_receive(msg) {
  var d = new Date();
  var h = d.getHours();
  var m = d.getMinutes();
  return "<li class='msg_receive'><div class='chat-content'><div class='box bg-light-info'>" + msg + "</div></div><div class='chat-time'>" + h + ":" + m + "</div></li>";
}

function msg_sent(msg) {
  var d = new Date();
  var h = d.getHours();
  var m = d.getMinutes();
  return "<li class='odd msg_sent'><div class='chat-content'><div class='box bg-light-info'>" + msg + "</div><br></div><div class='chat-time'>" + h + ":" + m + "</div></li>";
}

/***/ })

},[["./assets/js/app.js","runtime","vendors~app"]]]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvanMvYXBwLmpzIl0sIm5hbWVzIjpbIiQiLCJmbiIsIkFkbWluU2V0dGluZ3MiLCJzZXR0aW5ncyIsIm15aWQiLCJhdHRyIiwiZGVmYXVsdHMiLCJUaGVtZSIsIkxheW91dCIsIkxvZ29CZyIsIk5hdmJhckJnIiwiU2lkZWJhclR5cGUiLCJTaWRlYmFyQ29sb3IiLCJTaWRlYmFyUG9zaXRpb24iLCJIZWFkZXJQb3NpdGlvbiIsIkJveGVkTGF5b3V0IiwiZXh0ZW5kIiwiQWRtaW5TZXR0aW5nc0luaXQiLCJNYW5hZ2VUaGVtZSIsIk1hbmFnZVRoZW1lTGF5b3V0IiwiTWFuYWdlVGhlbWVCYWNrZ3JvdW5kIiwiTWFuYWdlU2lkZWJhclR5cGUiLCJNYW5hZ2VTaWRlYmFyQ29sb3IiLCJNYW5hZ2VTaWRlYmFyUG9zaXRpb24iLCJNYW5hZ2VCb3hlZExheW91dCIsInRoZW1ldmlldyIsInByb3AiLCJzZXRwZXJmZWN0c2Nyb2xsaG9yaXpvbnRhbCIsIndpZHRoIiwid2luZG93IiwiaW5uZXJXaWR0aCIsInNjcmVlbiIsInBlcmZlY3RTY3JvbGxiYXIiLCJyZWFkeSIsIm9uIiwic2V0bG9nb2JnIiwibGJnIiwidW5kZWZpbmVkIiwic2V0bmF2YmFyYmciLCJuYmciLCJzZXRzaWRlYmFydHlwZSIsImFkZENsYXNzIiwicmVtb3ZlQ2xhc3MiLCJ0b2dnbGVDbGFzcyIsImhhc0NsYXNzIiwic2V0c2lkZWJhcmJnIiwic2JnIiwic2lkZWJhcnBvc2l0aW9uIiwiaGVhZGVycG9zaXRpb24iLCJib3hlZGxheW91dCIsImNoYXRhcmVhIiwibmFtZSIsImZpbmQiLCJ0ZXh0IiwiaW1nIiwiaWQiLCJzdGF0dXMiLCJoaWRlIiwibGVuZ3RoIiwic2hvdyIsIm1zZyIsIm1zZ19yZWNlaXZlIiwibXNnX3NlbnQiLCJodG1sIiwiYXBwZW5kIiwiZG9jdW1lbnQiLCJlIiwia2V5Q29kZSIsInZhbCIsImZvY3VzIiwic3VwcHJlc3NTY3JvbGxYIiwi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QWRtaW4gUGFuZWwgc2V0dGluZ3NcclxuJC5mbi5BZG1pblNldHRpbmdzID0gZnVuY3Rpb24gKHNldHRpbmdzKSB7XHJcbiAgICB2YXIgbXlpZCA9IHRoaXMuYXR0cihcImlkXCIpO1xyXG4gICAgLy8gR2VuZXJhbCBvcHRpb24gZm9yIHZlcnRpY2FsIGhlYWRlciBcclxuICAgIHZhciBkZWZhdWx0cyA9IHtcclxuICAgICAgICBUaGVtZTogdHJ1ZSwgLy8gdGhpcyBjYW4gYmUgdHJ1ZSBvciBmYWxzZSAoIHRydWUgbWVhbnMgZGFyayBhbmQgZmFsc2UgbWVhbnMgbGlnaHQgKSxcclxuICAgICAgICBMYXlvdXQ6ICd2ZXJ0aWNhbCcsIC8vIFxyXG4gICAgICAgIExvZ29CZzogJ3NraW4xJywgLy8gWW91IGNhbiBjaGFuZ2UgdGhlIFZhbHVlIHRvIGJlIHNraW4xL3NraW4yL3NraW4zL3NraW40L3NraW41L3NraW42IFxyXG4gICAgICAgIE5hdmJhckJnOiAnc2tpbjYnLCAvLyBZb3UgY2FuIGNoYW5nZSB0aGUgVmFsdWUgdG8gYmUgc2tpbjEvc2tpbjIvc2tpbjMvc2tpbjQvc2tpbjUvc2tpbjYgXHJcbiAgICAgICAgU2lkZWJhclR5cGU6ICdmdWxsJywgLy8gWW91IGNhbiBjaGFuZ2UgaXQgZnVsbCAvIG1pbmktc2lkZWJhclxyXG4gICAgICAgIFNpZGViYXJDb2xvcjogJ3NraW4xJywgLy8gWW91IGNhbiBjaGFuZ2UgdGhlIFZhbHVlIHRvIGJlIHNraW4xL3NraW4yL3NraW4zL3NraW40L3NraW41L3NraW42XHJcbiAgICAgICAgU2lkZWJhclBvc2l0aW9uOiBmYWxzZSwgLy8gaXQgY2FuIGJlIHRydWUgLyBmYWxzZVxyXG4gICAgICAgIEhlYWRlclBvc2l0aW9uOiBmYWxzZSwgLy8gaXQgY2FuIGJlIHRydWUgLyBmYWxzZVxyXG4gICAgICAgIEJveGVkTGF5b3V0OiBmYWxzZSwgLy8gaXQgY2FuIGJlIHRydWUgLyBmYWxzZSBcclxuICAgIH07XHJcbiAgICB2YXIgc2V0dGluZ3MgPSAkLmV4dGVuZCh7fSwgZGVmYXVsdHMsIHNldHRpbmdzKTtcclxuICAgIC8vIEF0dHJpYnV0ZSBmdW5jdGlvbnMgXHJcbiAgICB2YXIgQWRtaW5TZXR0aW5ncyA9IHtcclxuICAgICAgICAvLyBTZXR0aW5ncyBJTklUXHJcbiAgICAgICAgQWRtaW5TZXR0aW5nc0luaXQ6IGZ1bmN0aW9uICgpIHtcclxuICAgICAgICAgICAgQWRtaW5TZXR0aW5ncy5NYW5hZ2VUaGVtZSgpO1xyXG4gICAgICAgICAgICBBZG1pblNldHRpbmdzLk1hbmFnZVRoZW1lTGF5b3V0KCk7XHJcbiAgICAgICAgICAgIEFkbWluU2V0dGluZ3MuTWFuYWdlVGhlbWVCYWNrZ3JvdW5kKCk7XHJcbiAgICAgICAgICAgIEFkbWluU2V0dGluZ3MuTWFuYWdlU2lkZWJhclR5cGUoKTtcclxuICAgICAgICAgICAgQWRtaW5TZXR0aW5ncy5NYW5hZ2VTaWRlYmFyQ29sb3IoKTtcclxuICAgICAgICAgICAgQWRtaW5TZXR0aW5ncy5NYW5hZ2VTaWRlYmFyUG9zaXRpb24oKTtcclxuICAgICAgICAgICAgQWRtaW5TZXR0aW5ncy5NYW5hZ2VCb3hlZExheW91dCgpO1xyXG4gICAgICAgIH1cclxuICAgICAgICAsIC8vKioqKioqKioqKioqKioqKioqKioqKioqKioqKlxyXG4gICAgICAgIC8vIE1hbmFnZVRoZW1lTGF5b3V0IGZ1bmN0aW9uc1xyXG4gICAgICAgIC8vKioqKioqKioqKioqKioqKioqKioqKioqKioqKlxyXG4gICAgICAgIE1hbmFnZVRoZW1lOiBmdW5jdGlvbiAoKSB7XHJcbiAgICAgICAgICAgIHZhciB0aGVtZXZpZXcgPSBzZXR0aW5ncy5UaGVtZTtcclxuICAgICAgICAgICAgc3dpdGNoIChzZXR0aW5ncy5MYXlvdXQpIHtcclxuICAgICAgICAgICAgY2FzZSAndmVydGljYWwnOlxyXG4gICAgICAgICAgICAgICAgaWYgKHRoZW1ldmlldyA9PSB0cnVlKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgJCgnYm9keScpLmF0dHIoXCJkYXRhLXRoZW1lXCIsICdkYXJrJyk7XHJcbiAgICAgICAgICAgICAgICAgICAgJChcIiN0aGVtZS12aWV3XCIpLnByb3AoXCJjaGVja2VkXCIsICEwKTtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIGVsc2Uge1xyXG4gICAgICAgICAgICAgICAgICAgICQoJyMnICsgbXlpZCkuYXR0cihcImRhdGEtdGhlbWVcIiwgJ2xpZ2h0Jyk7XHJcbiAgICAgICAgICAgICAgICAgICAgJChcImJvZHlcIikucHJvcChcImNoZWNrZWRcIiwgITEpO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgYnJlYWs7XHJcbiAgICAgICAgICAgICAgICAgICBcclxuICAgICAgICAgICAgZGVmYXVsdDpcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH1cclxuICAgICAgICAsIC8vKioqKioqKioqKioqKioqKioqKioqKioqKioqKlxyXG4gICAgICAgIC8vIE1hbmFnZVRoZW1lTGF5b3V0IGZ1bmN0aW9uc1xyXG4gICAgICAgIC8vKioqKioqKioqKioqKioqKioqKioqKioqKioqKlxyXG4gICAgICAgIE1hbmFnZVRoZW1lTGF5b3V0OiBmdW5jdGlvbiAoKSB7XHJcbiAgICAgICAgICAgIHN3aXRjaCAoc2V0dGluZ3MuTGF5b3V0KSB7XHJcbiAgICAgICAgICAgIGNhc2UgJ2hvcml6b250YWwnOlxyXG5cclxuICAgICAgICAgICAgICAgICQoJyMnICsgbXlpZCkuYXR0cihcImRhdGEtbGF5b3V0XCIsIFwiaG9yaXpvbnRhbFwiKTtcclxuICAgICAgICAgICAgICAgIHZhciBzZXRwZXJmZWN0c2Nyb2xsaG9yaXpvbnRhbCA9IGZ1bmN0aW9uICgpIHtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgd2lkdGggPSAod2luZG93LmlubmVyV2lkdGggPiAwKSA/IHdpbmRvdy5pbm5lcldpZHRoIDogdGhpcy5zY3JlZW4ud2lkdGg7XHJcbiAgICAgICAgICAgICAgICAgICAgaWYgKHdpZHRoIDwgNzY4KSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICQoJy5zY3JvbGwtc2lkZWJhcicpLnBlcmZlY3RTY3JvbGxiYXIoeyB9KTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgZWxzZSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICQoJy5zY3JvbGwtc2lkZWJhcicpLnBlcmZlY3RTY3JvbGxiYXIoJ2Rlc3Ryb3knKTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICB9O1xyXG4gICAgICAgICAgICAgICAgJCh3aW5kb3cpLnJlYWR5KHNldHBlcmZlY3RzY3JvbGxob3Jpem9udGFsKTtcclxuICAgICAgICAgICAgICAgICQod2luZG93KS5vbihcInJlc2l6ZVwiLCBzZXRwZXJmZWN0c2Nyb2xsaG9yaXpvbnRhbCk7XHJcbiAgICAgICAgICAgICAgICBicmVhaztcclxuICAgICAgICAgICAgY2FzZSAndmVydGljYWwnOlxyXG4gICAgICAgICAgICAgICAgJCgnIycgKyBteWlkKS5hdHRyKFwiZGF0YS1sYXlvdXRcIiwgXCJ2ZXJ0aWNhbFwiKTtcclxuICAgICAgICAgICAgICAgICQoJy5zY3JvbGwtc2lkZWJhcicpLnBlcmZlY3RTY3JvbGxiYXIoeyB9KTtcclxuICAgICAgICAgICAgICAgIGJyZWFrO1xyXG4gICAgICAgICAgICBkZWZhdWx0OlxyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgfVxyXG4gICAgICAgICwgLy8qKioqKioqKioqKioqKioqKioqKioqKioqKioqXHJcbiAgICAgICAgLy8gTWFuYWdlU2lkZWJhclR5cGUgZnVuY3Rpb25zIFxyXG4gICAgICAgIC8vKioqKioqKioqKioqKioqKioqKioqKioqKioqKlxyXG4gICAgICAgIE1hbmFnZVRoZW1lQmFja2dyb3VuZDogZnVuY3Rpb24gKCkge1xyXG4gICAgICAgICAgICAvLyBMb2dvIGJnIGF0dHJpYnV0ZVxyXG4gICAgICAgICAgICBmdW5jdGlvbiBzZXRsb2dvYmcoKSB7XHJcbiAgICAgICAgICAgICAgICB2YXIgbGJnID0gc2V0dGluZ3MuTG9nb0JnO1xyXG4gICAgICAgICAgICAgICAgaWYgKGxiZyAhPSB1bmRlZmluZWQgJiYgbGJnICE9IFwiXCIpIHtcclxuICAgICAgICAgICAgICAgICAgICAkKCcjJyArIG15aWQgKyAnIC50b3BiYXIgLnRvcC1uYXZiYXIgLm5hdmJhci1oZWFkZXInKS5hdHRyKFwiZGF0YS1sb2dvYmdcIiwgbGJnKTtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIGVsc2Uge1xyXG4gICAgICAgICAgICAgICAgICAgICQoJyMnICsgbXlpZCArICcgLnRvcGJhciAudG9wLW5hdmJhciAubmF2YmFyLWhlYWRlcicpLmF0dHIoXCJkYXRhLWxvZ29iZ1wiLCBcInNraW4xXCIpO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9O1xyXG4gICAgICAgICAgICBzZXRsb2dvYmcoKTtcclxuICAgICAgICAgICAgLy8gTmF2YmFyIGJnIGF0dHJpYnV0ZVxyXG4gICAgICAgICAgICBmdW5jdGlvbiBzZXRuYXZiYXJiZygpIHtcclxuICAgICAgICAgICAgICAgIHZhciBuYmcgPSBzZXR0aW5ncy5OYXZiYXJCZztcclxuICAgICAgICAgICAgICAgIGlmIChuYmcgIT0gdW5kZWZpbmVkICYmIG5iZyAhPSBcIlwiKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgJCgnIycgKyBteWlkICsgJyAudG9wYmFyIC5uYXZiYXItY29sbGFwc2UnKS5hdHRyKFwiZGF0YS1uYXZiYXJiZ1wiLCBuYmcpO1xyXG4gICAgICAgICAgICAgICAgICAgICQoJyMnICsgbXlpZCArICcgLnRvcGJhcicpLmF0dHIoXCJkYXRhLW5hdmJhcmJnXCIsIG5iZyk7XHJcbiAgICAgICAgICAgICAgICAgICAgJCgnIycgKyBteWlkKS5hdHRyKFwiZGF0YS1uYXZiYXJiZ1wiLCBuYmcpO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgZWxzZSB7XHJcbiAgICAgICAgICAgICAgICAgICAgJCgnIycgKyBteWlkICsgJyAudG9wYmFyIC5uYXZiYXItY29sbGFwc2UnKS5hdHRyKFwiZGF0YS1uYXZiYXJiZ1wiLCBcInNraW4xXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgICAkKCcjJyArIG15aWQgKyAnIC50b3BiYXInKS5hdHRyKFwiZGF0YS1uYXZiYXJiZ1wiLCBcInNraW4xXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgICQoJyMnICsgbXlpZCkuYXR0cihcImRhdGEtbmF2YmFyYmdcIiwgXCJza2luMVwiKTtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfTtcclxuICAgICAgICAgICAgc2V0bmF2YmFyYmcoKTtcclxuICAgICAgICB9XHJcbiAgICAgICAgLCAvLyoqKioqKioqKioqKioqKioqKioqKioqKioqKipcclxuICAgICAgICAvLyBNYW5hZ2VUaGVtZUxheW91dCBmdW5jdGlvbnNcclxuICAgICAgICAvLyoqKioqKioqKioqKioqKioqKioqKioqKioqKipcclxuICAgICAgICBNYW5hZ2VTaWRlYmFyVHlwZTogZnVuY3Rpb24gKCkge1xyXG4gICAgICAgICAgICBzd2l0Y2ggKHNldHRpbmdzLlNpZGViYXJUeXBlKSB7XHJcbiAgICAgICAgICAgICAgICAvLyoqKioqKioqKioqKioqKioqKioqKioqKioqKipcclxuICAgICAgICAgICAgICAgIC8vIElmIHRoZSBzaWRlYmFyIHR5cGUgaGFzIGZ1bGxcclxuICAgICAgICAgICAgICAgIC8vKioqKioqKioqKioqKioqKioqKioqKioqKioqKiAgICAgXHJcbiAgICAgICAgICAgIGNhc2UgJ2Z1bGwnOlxyXG4gICAgICAgICAgICAgICAgJCgnIycgKyBteWlkKS5hdHRyKFwiZGF0YS1zaWRlYmFydHlwZVwiLCBcImZ1bGxcIik7XHJcbiAgICAgICAgICAgICAgICAvLyoqKioqKioqKioqKioqKioqKioqKioqKioqKipcclxuICAgICAgICAgICAgICAgIC8qIFRoaXMgaXMgZm9yIHRoZSBtaW5pLXNpZGViYXIgaWYgd2lkdGggaXMgbGVzcyB0aGVuIDExNzAqL1xyXG4gICAgICAgICAgICAgICAgLy8qKioqKioqKioqKioqKioqKioqKioqKioqKioqIFxyXG4gICAgICAgICAgICAgICAgdmFyIHNldHNpZGViYXJ0eXBlID0gZnVuY3Rpb24gKCkge1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciB3aWR0aCA9ICh3aW5kb3cuaW5uZXJXaWR0aCA+IDApID8gd2luZG93LmlubmVyV2lkdGggOiB0aGlzLnNjcmVlbi53aWR0aDtcclxuICAgICAgICAgICAgICAgICAgICBpZiAod2lkdGggPCAxMTcwKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICQoXCIjbWFpbi13cmFwcGVyXCIpLmF0dHIoXCJkYXRhLXNpZGViYXJ0eXBlXCIsIFwibWluaS1zaWRlYmFyXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAkKFwiI21haW4td3JhcHBlclwiKS5hZGRDbGFzcyhcIm1pbmktc2lkZWJhclwiKTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgZWxzZSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICQoXCIjbWFpbi13cmFwcGVyXCIpLmF0dHIoXCJkYXRhLXNpZGViYXJ0eXBlXCIsIFwiZnVsbFwiKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgJChcIiNtYWluLXdyYXBwZXJcIikucmVtb3ZlQ2xhc3MoXCJtaW5pLXNpZGViYXJcIik7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgfTtcclxuICAgICAgICAgICAgICAgICQod2luZG93KS5yZWFkeShzZXRzaWRlYmFydHlwZSk7XHJcbiAgICAgICAgICAgICAgICAkKHdpbmRvdykub24oXCJyZXNpemVcIiwgc2V0c2lkZWJhcnR5cGUpO1xyXG4gICAgICAgICAgICAgICAgLy8qKioqKioqKioqKioqKioqKioqKioqKioqKioqXHJcbiAgICAgICAgICAgICAgICAvKiBUaGlzIGlzIGZvciBzaWRlYmFydG9nZ2xlciovXHJcbiAgICAgICAgICAgICAgICAvLyoqKioqKioqKioqKioqKioqKioqKioqKioqKipcclxuICAgICAgICAgICAgICAgICQoJy5zaWRlYmFydG9nZ2xlcicpLm9uKFwiY2xpY2tcIiwgZnVuY3Rpb24gKCkge1xyXG4gICAgICAgICAgICAgICAgICAgICQoXCIjbWFpbi13cmFwcGVyXCIpLnRvZ2dsZUNsYXNzKFwibWluaS1zaWRlYmFyXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgIGlmICgkKFwiI21haW4td3JhcHBlclwiKS5oYXNDbGFzcyhcIm1pbmktc2lkZWJhclwiKSkge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAkKFwiLnNpZGViYXJ0b2dnbGVyXCIpLnByb3AoXCJjaGVja2VkXCIsICEwKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgJChcIiNtYWluLXdyYXBwZXJcIikuYXR0cihcImRhdGEtc2lkZWJhcnR5cGVcIiwgXCJtaW5pLXNpZGViYXJcIik7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgICAgIGVsc2Uge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAkKFwiLnNpZGViYXJ0b2dnbGVyXCIpLnByb3AoXCJjaGVja2VkXCIsICExKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgJChcIiNtYWluLXdyYXBwZXJcIikuYXR0cihcImRhdGEtc2lkZWJhcnR5cGVcIiwgXCJmdWxsXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIH0pO1xyXG4gICAgICAgICAgICAgICAgYnJlYWs7XHJcbiAgICAgICAgICAgICAgICAvLyoqKioqKioqKioqKioqKioqKioqKioqKioqKipcclxuICAgICAgICAgICAgICAgIC8vIElmIHRoZSBzaWRlYmFyIHR5cGUgaGFzIG1pbmktc2lkZWJhclxyXG4gICAgICAgICAgICAgICAgLy8qKioqKioqKioqKioqKioqKioqKioqKioqKioqICAgICAgIFxyXG4gICAgICAgICAgICBjYXNlICdtaW5pLXNpZGViYXInOlxyXG4gICAgICAgICAgICAgICAgJCgnIycgKyBteWlkKS5hdHRyKFwiZGF0YS1zaWRlYmFydHlwZVwiLCBcIm1pbmktc2lkZWJhclwiKTtcclxuICAgICAgICAgICAgICAgIC8vKioqKioqKioqKioqKioqKioqKioqKioqKioqKlxyXG4gICAgICAgICAgICAgICAgLyogVGhpcyBpcyBmb3Igc2lkZWJhcnRvZ2dsZXIqL1xyXG4gICAgICAgICAgICAgICAgLy8qKioqKioqKioqKioqKioqKioqKioqKioqKioqXHJcbiAgICAgICAgICAgICAgICAkKCcuc2lkZWJhcnRvZ2dsZXInKS5vbihcImNsaWNrXCIsIGZ1bmN0aW9uICgpIHtcclxuICAgICAgICAgICAgICAgICAgICAkKFwiI21haW4td3JhcHBlclwiKS50b2dnbGVDbGFzcyhcIm1pbmktc2lkZWJhclwiKTtcclxuICAgICAgICAgICAgICAgICAgICBpZiAoJChcIiNtYWluLXdyYXBwZXJcIikuaGFzQ2xhc3MoXCJtaW5pLXNpZGViYXJcIikpIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgJChcIi5zaWRlYmFydG9nZ2xlclwiKS5wcm9wKFwiY2hlY2tlZFwiLCAhMCk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICQoXCIjbWFpbi13cmFwcGVyXCIpLmF0dHIoXCJkYXRhLXNpZGViYXJ0eXBlXCIsIFwiZnVsbFwiKTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgZWxzZSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICQoXCIuc2lkZWJhcnRvZ2dsZXJcIikucHJvcChcImNoZWNrZWRcIiwgITEpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAkKFwiI21haW4td3JhcHBlclwiKS5hdHRyKFwiZGF0YS1zaWRlYmFydHlwZVwiLCBcIm1pbmktc2lkZWJhclwiKTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICB9KTtcclxuICAgICAgICAgICAgICAgIGJyZWFrO1xyXG4gICAgICAgICAgICAgICAgLy8qKioqKioqKioqKioqKioqKioqKioqKioqKioqXHJcbiAgICAgICAgICAgICAgICAvLyBJZiB0aGUgc2lkZWJhciB0eXBlIGhhcyBpY29uYmFyXHJcbiAgICAgICAgICAgICAgICAvLyoqKioqKioqKioqKioqKioqKioqKioqKioqKiogICAgICAgXHJcbiAgICAgICAgICAgIGNhc2UgJ2ljb25iYXInOlxyXG4gICAgICAgICAgICAgICAgJCgnIycgKyBteWlkKS5hdHRyKFwiZGF0YS1zaWRlYmFydHlwZVwiLCBcImljb25iYXJcIik7XHJcbiAgICAgICAgICAgICAgICAvLyoqKioqKioqKioqKioqKioqKioqKioqKioqKipcclxuICAgICAgICAgICAgICAgIC8qIFRoaXMgaXMgZm9yIHRoZSBtaW5pLXNpZGViYXIgaWYgd2lkdGggaXMgbGVzcyB0aGVuIDExNzAqL1xyXG4gICAgICAgICAgICAgICAgLy8qKioqKioqKioqKioqKioqKioqKioqKioqKioqIFxyXG4gICAgICAgICAgICAgICAgdmFyIHNldHNpZGViYXJ0eXBlID0gZnVuY3Rpb24gKCkge1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciB3aWR0aCA9ICh3aW5kb3cuaW5uZXJXaWR0aCA+IDApID8gd2luZG93LmlubmVyV2lkdGggOiB0aGlzLnNjcmVlbi53aWR0aDtcclxuICAgICAgICAgICAgICAgICAgICBpZiAod2lkdGggPCAxMTcwKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICQoXCIjbWFpbi13cmFwcGVyXCIpLmF0dHIoXCJkYXRhLXNpZGViYXJ0eXBlXCIsIFwibWluaS1zaWRlYmFyXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAkKFwiI21haW4td3JhcHBlclwiKS5hZGRDbGFzcyhcIm1pbmktc2lkZWJhclwiKTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgZWxzZSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICQoXCIjbWFpbi13cmFwcGVyXCIpLmF0dHIoXCJkYXRhLXNpZGViYXJ0eXBlXCIsIFwiaWNvbmJhclwiKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgJChcIiNtYWluLXdyYXBwZXJcIikucmVtb3ZlQ2xhc3MoXCJtaW5pLXNpZGViYXJcIik7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgfTtcclxuICAgICAgICAgICAgICAgICQod2luZG93KS5yZWFkeShzZXRzaWRlYmFydHlwZSk7XHJcbiAgICAgICAgICAgICAgICAkKHdpbmRvdykub24oXCJyZXNpemVcIiwgc2V0c2lkZWJhcnR5cGUpO1xyXG4gICAgICAgICAgICAgICAgLy8qKioqKioqKioqKioqKioqKioqKioqKioqKioqXHJcbiAgICAgICAgICAgICAgICAvKiBUaGlzIGlzIGZvciBzaWRlYmFydG9nZ2xlciovXHJcbiAgICAgICAgICAgICAgICAvLyoqKioqKioqKioqKioqKioqKioqKioqKioqKipcclxuICAgICAgICAgICAgICAgICQoJy5zaWRlYmFydG9nZ2xlcicpLm9uKFwiY2xpY2tcIiwgZnVuY3Rpb24gKCkge1xyXG4gICAgICAgICAgICAgICAgICAgICQoXCIjbWFpbi13cmFwcGVyXCIpLnRvZ2dsZUNsYXNzKFwibWluaS1zaWRlYmFyXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgIGlmICgkKFwiI21haW4td3JhcHBlclwiKS5oYXNDbGFzcyhcIm1pbmktc2lkZWJhclwiKSkge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAkKFwiLnNpZGViYXJ0b2dnbGVyXCIpLnByb3AoXCJjaGVja2VkXCIsICEwKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgJChcIiNtYWluLXdyYXBwZXJcIikuYXR0cihcImRhdGEtc2lkZWJhcnR5cGVcIiwgXCJtaW5pLXNpZGViYXJcIik7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgICAgIGVsc2Uge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAkKFwiLnNpZGViYXJ0b2dnbGVyXCIpLnByb3AoXCJjaGVja2VkXCIsICExKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgJChcIiNtYWluLXdyYXBwZXJcIikuYXR0cihcImRhdGEtc2lkZWJhcnR5cGVcIiwgXCJpY29uYmFyXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIH0pO1xyXG4gICAgICAgICAgICAgICAgYnJlYWs7XHJcbiAgICAgICAgICAgICAgICAvLyoqKioqKioqKioqKioqKioqKioqKioqKioqKipcclxuICAgICAgICAgICAgICAgIC8vIElmIHRoZSBzaWRlYmFyIHR5cGUgaGFzIG92ZXJsYXlcclxuICAgICAgICAgICAgICAgIC8vKioqKioqKioqKioqKioqKioqKioqKioqKioqKiAgICAgICBcclxuICAgICAgICAgICAgY2FzZSAnb3ZlcmxheSc6XHJcbiAgICAgICAgICAgICAgICAkKCcjJyArIG15aWQpLmF0dHIoXCJkYXRhLXNpZGViYXJ0eXBlXCIsIFwib3ZlcmxheVwiKTtcclxuICAgICAgICAgICAgICAgIHZhciBzZXRzaWRlYmFydHlwZSA9IGZ1bmN0aW9uICgpIHtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgd2lkdGggPSAod2luZG93LmlubmVyV2lkdGggPiAwKSA/IHdpbmRvdy5pbm5lcldpZHRoIDogdGhpcy5zY3JlZW4ud2lkdGg7XHJcbiAgICAgICAgICAgICAgICAgICAgaWYgKHdpZHRoIDwgNzY3KSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICQoXCIjbWFpbi13cmFwcGVyXCIpLmF0dHIoXCJkYXRhLXNpZGViYXJ0eXBlXCIsIFwibWluaS1zaWRlYmFyXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAkKFwiI21haW4td3JhcHBlclwiKS5hZGRDbGFzcyhcIm1pbmktc2lkZWJhclwiKTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgZWxzZSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICQoXCIjbWFpbi13cmFwcGVyXCIpLmF0dHIoXCJkYXRhLXNpZGViYXJ0eXBlXCIsIFwib3ZlcmxheVwiKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgJChcIiNtYWluLXdyYXBwZXJcIikucmVtb3ZlQ2xhc3MoXCJtaW5pLXNpZGViYXJcIik7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgfTtcclxuICAgICAgICAgICAgICAgICQod2luZG93KS5yZWFkeShzZXRzaWRlYmFydHlwZSk7XHJcbiAgICAgICAgICAgICAgICAkKHdpbmRvdykub24oXCJyZXNpemVcIiwgc2V0c2lkZWJhcnR5cGUpO1xyXG4gICAgICAgICAgICAgICAgLy8qKioqKioqKioqKioqKioqKioqKioqKioqKioqXHJcbiAgICAgICAgICAgICAgICAvKiBUaGlzIGlzIGZvciBzaWRlYmFydG9nZ2xlciovXHJcbiAgICAgICAgICAgICAgICAvLyoqKioqKioqKioqKioqKioqKioqKioqKioqKipcclxuICAgICAgICAgICAgICAgICQoJy5zaWRlYmFydG9nZ2xlcicpLm9uKFwiY2xpY2tcIiwgZnVuY3Rpb24gKCkge1xyXG4gICAgICAgICAgICAgICAgICAgICQoXCIjbWFpbi13cmFwcGVyXCIpLnRvZ2dsZUNsYXNzKFwic2hvdy1zaWRlYmFyXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgIGlmICgkKFwiI21haW4td3JhcHBlclwiKS5oYXNDbGFzcyhcInNob3ctc2lkZWJhclwiKSkge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAvLyQoXCIuc2lkZWJhcnRvZ2dsZXJcIikucHJvcChcImNoZWNrZWRcIiwgITApO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAvLyQoXCIjbWFpbi13cmFwcGVyXCIpLmF0dHIoXCJkYXRhLXNpZGViYXJ0eXBlXCIsXCJtaW5pLXNpZGViYXJcIik7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgICAgIGVsc2Uge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAvLyQoXCIuc2lkZWJhcnRvZ2dsZXJcIikucHJvcChcImNoZWNrZWRcIiwgITEpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAvLyQoXCIjbWFpbi13cmFwcGVyXCIpLmF0dHIoXCJkYXRhLXNpZGViYXJ0eXBlXCIsXCJpY29uYmFyXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIH0pO1xyXG4gICAgICAgICAgICAgICAgYnJlYWs7XHJcbiAgICAgICAgICAgIGRlZmF1bHQ6XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9XHJcbiAgICAgICAgLCAvLyoqKioqKioqKioqKioqKioqKioqKioqKioqKipcclxuICAgICAgICAvLyBNYW5hZ2VTaWRlYmFyQ29sb3IgZnVuY3Rpb25zIFxyXG4gICAgICAgIC8vKioqKioqKioqKioqKioqKioqKioqKioqKioqKlxyXG4gICAgICAgIE1hbmFnZVNpZGViYXJDb2xvcjogZnVuY3Rpb24gKCkge1xyXG4gICAgICAgICAgICAvLyBMb2dvIGJnIGF0dHJpYnV0ZVxyXG4gICAgICAgICAgICBmdW5jdGlvbiBzZXRzaWRlYmFyYmcoKSB7XHJcbiAgICAgICAgICAgICAgICB2YXIgc2JnID0gc2V0dGluZ3MuU2lkZWJhckNvbG9yO1xyXG4gICAgICAgICAgICAgICAgaWYgKHNiZyAhPSB1bmRlZmluZWQgJiYgc2JnICE9IFwiXCIpIHtcclxuICAgICAgICAgICAgICAgICAgICAkKCcjJyArIG15aWQgKyAnIC5sZWZ0LXNpZGViYXInKS5hdHRyKFwiZGF0YS1zaWRlYmFyYmdcIiwgc2JnKTtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIGVsc2Uge1xyXG4gICAgICAgICAgICAgICAgICAgICQoJyMnICsgbXlpZCArICcgLmxlZnQtc2lkZWJhcicpLmF0dHIoXCJkYXRhLXNpZGViYXJiZ1wiLCBcInNraW4xXCIpO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9O1xyXG4gICAgICAgICAgICBzZXRzaWRlYmFyYmcoKTtcclxuICAgICAgICB9XHJcbiAgICAgICAgLCAvLyoqKioqKioqKioqKioqKioqKioqKioqKioqKipcclxuICAgICAgICAvLyBNYW5hZ2VTaWRlYmFyUG9zaXRpb24gZnVuY3Rpb25zXHJcbiAgICAgICAgLy8qKioqKioqKioqKioqKioqKioqKioqKioqKioqXHJcbiAgICAgICAgTWFuYWdlU2lkZWJhclBvc2l0aW9uOiBmdW5jdGlvbiAoKSB7XHJcbiAgICAgICAgICAgIHZhciBzaWRlYmFycG9zaXRpb24gPSBzZXR0aW5ncy5TaWRlYmFyUG9zaXRpb247XHJcbiAgICAgICAgICAgIHZhciBoZWFkZXJwb3NpdGlvbiA9IHNldHRpbmdzLkhlYWRlclBvc2l0aW9uO1xyXG4gICAgICAgICAgICBzd2l0Y2ggKHNldHRpbmdzLkxheW91dCkge1xyXG4gICAgICAgICAgICBjYXNlICd2ZXJ0aWNhbCc6XHJcbiAgICAgICAgICAgICAgICBpZiAoc2lkZWJhcnBvc2l0aW9uID09IHRydWUpIHtcclxuICAgICAgICAgICAgICAgICAgICAkKCcjJyArIG15aWQpLmF0dHIoXCJkYXRhLXNpZGViYXItcG9zaXRpb25cIiwgJ2ZpeGVkJyk7XHJcbiAgICAgICAgICAgICAgICAgICAgJChcIiNzaWRlYmFyLXBvc2l0aW9uXCIpLnByb3AoXCJjaGVja2VkXCIsICEwKTtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIGVsc2Uge1xyXG4gICAgICAgICAgICAgICAgICAgICQoJyMnICsgbXlpZCkuYXR0cihcImRhdGEtc2lkZWJhci1wb3NpdGlvblwiLCAnYWJzb2x1dGUnKTtcclxuICAgICAgICAgICAgICAgICAgICAkKFwiI3NpZGViYXItcG9zaXRpb25cIikucHJvcChcImNoZWNrZWRcIiwgITEpO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgaWYgKGhlYWRlcnBvc2l0aW9uID09IHRydWUpIHtcclxuICAgICAgICAgICAgICAgICAgICAkKCcjJyArIG15aWQpLmF0dHIoXCJkYXRhLWhlYWRlci1wb3NpdGlvblwiLCAnZml4ZWQnKTtcclxuICAgICAgICAgICAgICAgICAgICAkKFwiI2hlYWRlci1wb3NpdGlvblwiKS5wcm9wKFwiY2hlY2tlZFwiLCAhMCk7XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICBlbHNlIHtcclxuICAgICAgICAgICAgICAgICAgICAkKCcjJyArIG15aWQpLmF0dHIoXCJkYXRhLWhlYWRlci1wb3NpdGlvblwiLCAncmVsYXRpdmUnKTtcclxuICAgICAgICAgICAgICAgICAgICAkKFwiI2hlYWRlci1wb3NpdGlvblwiKS5wcm9wKFwiY2hlY2tlZFwiLCAhMSk7XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICBicmVhaztcclxuICAgICAgICAgICAgY2FzZSAnaG9yaXpvbnRhbCc6XHJcbiAgICAgICAgICAgICAgICBpZiAoc2lkZWJhcnBvc2l0aW9uID09IHRydWUpIHtcclxuICAgICAgICAgICAgICAgICAgICAkKCcjJyArIG15aWQpLmF0dHIoXCJkYXRhLXNpZGViYXItcG9zaXRpb25cIiwgJ2ZpeGVkJyk7XHJcbiAgICAgICAgICAgICAgICAgICAgJChcIiNzaWRlYmFyLXBvc2l0aW9uXCIpLnByb3AoXCJjaGVja2VkXCIsICEwKTtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIGVsc2Uge1xyXG4gICAgICAgICAgICAgICAgICAgICQoJyMnICsgbXlpZCkuYXR0cihcImRhdGEtc2lkZWJhci1wb3NpdGlvblwiLCAnYWJzb2x1dGUnKTtcclxuICAgICAgICAgICAgICAgICAgICAkKFwiI3NpZGViYXItcG9zaXRpb25cIikucHJvcChcImNoZWNrZWRcIiwgITEpO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgaWYgKGhlYWRlcnBvc2l0aW9uID09IHRydWUpIHtcclxuICAgICAgICAgICAgICAgICAgICAkKCcjJyArIG15aWQpLmF0dHIoXCJkYXRhLWhlYWRlci1wb3NpdGlvblwiLCAnZml4ZWQnKTtcclxuICAgICAgICAgICAgICAgICAgICAkKFwiI2hlYWRlci1wb3NpdGlvblwiKS5wcm9wKFwiY2hlY2tlZFwiLCAhMCk7XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICBlbHNlIHtcclxuICAgICAgICAgICAgICAgICAgICAkKCcjJyArIG15aWQpLmF0dHIoXCJkYXRhLWhlYWRlci1wb3NpdGlvblwiLCAncmVsYXRpdmUnKTtcclxuICAgICAgICAgICAgICAgICAgICAkKFwiI2hlYWRlci1wb3NpdGlvblwiKS5wcm9wKFwiY2hlY2tlZFwiLCAhMSk7XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICBicmVhaztcclxuICAgICAgICAgICAgZGVmYXVsdDpcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH1cclxuICAgICAgICAsIC8vKioqKioqKioqKioqKioqKioqKioqKioqKioqKlxyXG4gICAgICAgIC8vIE1hbmFnZUJveGVkTGF5b3V0IGZ1bmN0aW9uc1xyXG4gICAgICAgIC8vKioqKioqKioqKioqKioqKioqKioqKioqKioqKlxyXG4gICAgICAgIE1hbmFnZUJveGVkTGF5b3V0OiBmdW5jdGlvbiAoKSB7XHJcbiAgICAgICAgICAgIHZhciBib3hlZGxheW91dCA9IHNldHRpbmdzLkJveGVkTGF5b3V0O1xyXG4gICAgICAgICAgICBzd2l0Y2ggKHNldHRpbmdzLkxheW91dCkge1xyXG4gICAgICAgICAgICBjYXNlICd2ZXJ0aWNhbCc6XHJcbiAgICAgICAgICAgICAgICBpZiAoYm94ZWRsYXlvdXQgPT0gdHJ1ZSkge1xyXG4gICAgICAgICAgICAgICAgICAgICQoJyMnICsgbXlpZCkuYXR0cihcImRhdGEtYm94ZWQtbGF5b3V0XCIsICdib3hlZCcpO1xyXG4gICAgICAgICAgICAgICAgICAgICQoXCIjYm94ZWQtbGF5b3V0XCIpLnByb3AoXCJjaGVja2VkXCIsICEwKTtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIGVsc2Uge1xyXG4gICAgICAgICAgICAgICAgICAgICQoJyMnICsgbXlpZCkuYXR0cihcImRhdGEtYm94ZWQtbGF5b3V0XCIsICdmdWxsJyk7XHJcbiAgICAgICAgICAgICAgICAgICAgJChcIiNib3hlZC1sYXlvdXRcIikucHJvcChcImNoZWNrZWRcIiwgITEpO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgYnJlYWs7XHJcbiAgICAgICAgICAgIGNhc2UgJ2hvcml6b250YWwnOlxyXG4gICAgICAgICAgICAgICAgaWYgKGJveGVkbGF5b3V0ID09IHRydWUpIHtcclxuICAgICAgICAgICAgICAgICAgICAkKCcjJyArIG15aWQpLmF0dHIoXCJkYXRhLWJveGVkLWxheW91dFwiLCAnYm94ZWQnKTtcclxuICAgICAgICAgICAgICAgICAgICAkKFwiI2JveGVkLWxheW91dFwiKS5wcm9wKFwiY2hlY2tlZFwiLCAhMCk7XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICBlbHNlIHtcclxuICAgICAgICAgICAgICAgICAgICAkKCcjJyArIG15aWQpLmF0dHIoXCJkYXRhLWJveGVkLWxheW91dFwiLCAnZnVsbCcpO1xyXG4gICAgICAgICAgICAgICAgICAgICQoXCIjYm94ZWQtbGF5b3V0XCIpLnByb3AoXCJjaGVja2VkXCIsICExKTtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIGJyZWFrOyAgICAgICAgXHJcbiAgICAgICAgICAgIGRlZmF1bHQ6XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9XHJcbiAgICAsIH07XHJcbiAgICBBZG1pblNldHRpbmdzLkFkbWluU2V0dGluZ3NJbml0KCk7XHJcbn07XHJcbi8vKioqKioqKioqKioqKioqKioqKioqKioqKioqKlxyXG4vLyBUaGlzIGlzIGZvciB0aGUgY2hhdCBjdXN0b21pemVyIHNldHRpbmdcclxuLy8qKioqKioqKioqKioqKioqKioqKioqKioqKioqXHJcbiQoZnVuY3Rpb24gKCkge1xyXG4gICAgdmFyIGNoYXRhcmVhID0gJChcIiNjaGF0XCIpO1xyXG4gICAgJCgnI2NoYXQgLm1lc3NhZ2UtY2VudGVyIGEnKS5vbignY2xpY2snLCBmdW5jdGlvbiAoKSB7XHJcbiAgICAgICAgdmFyIG5hbWUgPSAkKHRoaXMpLmZpbmQoXCIubWFpbC1jb250bmV0IGg1XCIpLnRleHQoKTtcclxuICAgICAgICB2YXIgaW1nID0gJCh0aGlzKS5maW5kKFwiLnVzZXItaW1nIGltZ1wiKS5hdHRyKFwic3JjXCIpO1xyXG4gICAgICAgIHZhciBpZCA9ICQodGhpcykuYXR0cihcImRhdGEtdXNlci1pZFwiKTtcclxuICAgICAgICB2YXIgc3RhdHVzID0gJCh0aGlzKS5maW5kKFwiLnByb2ZpbGUtc3RhdHVzXCIpLmF0dHIoXCJkYXRhLXN0YXR1c1wiKTtcclxuICAgICAgICBpZiAoJCh0aGlzKS5oYXNDbGFzcyhcImFjdGl2ZVwiKSkge1xyXG4gICAgICAgICAgICAkKHRoaXMpLnRvZ2dsZUNsYXNzKFwiYWN0aXZlXCIpO1xyXG4gICAgICAgICAgICAkKFwiLmNoYXQtd2luZG93cyAjdXNlci1jaGF0XCIgKyBpZCkuaGlkZSgpO1xyXG4gICAgICAgIH1cclxuICAgICAgICBlbHNlIHtcclxuICAgICAgICAgICAgJCh0aGlzKS50b2dnbGVDbGFzcyhcImFjdGl2ZVwiKTtcclxuICAgICAgICAgICAgaWYgKCQoXCIuY2hhdC13aW5kb3dzICN1c2VyLWNoYXRcIiArIGlkKS5sZW5ndGgpIHtcclxuICAgICAgICAgICAgICAgICQoXCIuY2hhdC13aW5kb3dzICN1c2VyLWNoYXRcIiArIGlkKS5yZW1vdmVDbGFzcyhcIm1pbmktY2hhdFwiKS5zaG93KCk7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgZWxzZSB7XHJcbiAgICAgICAgICAgICAgICB2YXIgbXNnID0gbXNnX3JlY2VpdmUoJ0kgd2F0Y2hlZCB0aGUgc3Rvcm0sIHNvIGJlYXV0aWZ1bCB5ZXQgdGVycmlmaWMuJyk7XHJcbiAgICAgICAgICAgICAgICBtc2cgKz0gbXNnX3NlbnQoJ1RoYXQgaXMgdmVyeSBkZWVwIGluZGVlZCEnKTtcclxuICAgICAgICAgICAgICAgIHZhciBodG1sID0gXCI8ZGl2IGNsYXNzPSd1c2VyLWNoYXQnIGlkPSd1c2VyLWNoYXRcIiArIGlkICsgXCInIGRhdGEtdXNlci1pZD0nXCIgKyBpZCArIFwiJz5cIjtcclxuICAgICAgICAgICAgICAgIGh0bWwgKz0gXCI8ZGl2IGNsYXNzPSdjaGF0LWhlYWQnPjxpbWcgc3JjPSdcIiArIGltZyArIFwiJyBkYXRhLXVzZXItaWQ9J1wiICsgaWQgKyBcIic+PHNwYW4gY2xhc3M9J3N0YXR1cyBcIiArIHN0YXR1cyArIFwiJz48L3NwYW4+PHNwYW4gY2xhc3M9J25hbWUnPlwiICsgbmFtZSArIFwiPC9zcGFuPjxzcGFuIGNsYXNzPSdvcHRzJz48aSBjbGFzcz0ndGktY2xvc2UgY2xvc2VpdCcgZGF0YS11c2VyLWlkPSdcIiArIGlkICsgXCInPjwvaT48aSBjbGFzcz0ndGktbWludXMgbWluaS1jaGF0JyBkYXRhLXVzZXItaWQ9J1wiICsgaWQgKyBcIic+PC9pPjwvc3Bhbj48L2Rpdj5cIjtcclxuICAgICAgICAgICAgICAgIGh0bWwgKz0gXCI8ZGl2IGNsYXNzPSdjaGF0LWJvZHknPjx1bCBjbGFzcz0nY2hhdC1saXN0Jz5cIiArIG1zZyArIFwiPC91bD48L2Rpdj5cIjtcclxuICAgICAgICAgICAgICAgIGh0bWwgKz0gXCI8ZGl2IGNsYXNzPSdjaGF0LWZvb3Rlcic+PGlucHV0IHR5cGU9J3RleHQnIGRhdGEtdXNlci1pZD0nXCIgKyBpZCArIFwiJyBwbGFjZWhvbGRlcj0nVHlwZSAmIEVudGVyJyBjbGFzcz0nZm9ybS1jb250cm9sJz48L2Rpdj5cIjtcclxuICAgICAgICAgICAgICAgIGh0bWwgKz0gXCI8L2Rpdj5cIjtcclxuICAgICAgICAgICAgICAgICQoXCIuY2hhdC13aW5kb3dzXCIpLmFwcGVuZChodG1sKTtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH1cclxuICAgIH0pO1xyXG4gICAgJChkb2N1bWVudCkub24oJ2NsaWNrJywgXCIuY2hhdC13aW5kb3dzIC51c2VyLWNoYXQgLmNoYXQtaGVhZCAuY2xvc2VpdFwiLCBmdW5jdGlvbiAoZSkge1xyXG4gICAgICAgIHZhciBpZCA9ICQodGhpcykuYXR0cihcImRhdGEtdXNlci1pZFwiKTtcclxuICAgICAgICAkKFwiLmNoYXQtd2luZG93cyAjdXNlci1jaGF0XCIgKyBpZCkuaGlkZSgpO1xyXG4gICAgICAgICQoXCIjY2hhdCAubWVzc2FnZS1jZW50ZXIgLnVzZXItaW5mbyNjaGF0X3VzZXJfXCIgKyBpZCkucmVtb3ZlQ2xhc3MoXCJhY3RpdmVcIik7XHJcbiAgICB9KTtcclxuICAgICQoZG9jdW1lbnQpLm9uKCdjbGljaycsIFwiLmNoYXQtd2luZG93cyAudXNlci1jaGF0IC5jaGF0LWhlYWQgaW1nLCAuY2hhdC13aW5kb3dzIC51c2VyLWNoYXQgLmNoYXQtaGVhZCAubWluaS1jaGF0XCIsIGZ1bmN0aW9uIChlKSB7XHJcbiAgICAgICAgdmFyIGlkID0gJCh0aGlzKS5hdHRyKFwiZGF0YS11c2VyLWlkXCIpO1xyXG4gICAgICAgIGlmICghJChcIi5jaGF0LXdpbmRvd3MgI3VzZXItY2hhdFwiICsgaWQpLmhhc0NsYXNzKFwibWluaS1jaGF0XCIpKSB7XHJcbiAgICAgICAgICAgICQoXCIuY2hhdC13aW5kb3dzICN1c2VyLWNoYXRcIiArIGlkKS5hZGRDbGFzcyhcIm1pbmktY2hhdFwiKTtcclxuICAgICAgICB9XHJcbiAgICAgICAgZWxzZSB7XHJcbiAgICAgICAgICAgICQoXCIuY2hhdC13aW5kb3dzICN1c2VyLWNoYXRcIiArIGlkKS5yZW1vdmVDbGFzcyhcIm1pbmktY2hhdFwiKTtcclxuICAgICAgICB9XHJcbiAgICB9KTtcclxuICAgICQoZG9jdW1lbnQpLm9uKCdrZXlwcmVzcycsIFwiLmNoYXQtd2luZG93cyAudXNlci1jaGF0IC5jaGF0LWZvb3RlciBpbnB1dFwiLCBmdW5jdGlvbiAoZSkge1xyXG4gICAgICAgIGlmIChlLmtleUNvZGUgPT0gMTMpIHtcclxuICAgICAgICAgICAgdmFyIGlkID0gJCh0aGlzKS5hdHRyKFwiZGF0YS11c2VyLWlkXCIpO1xyXG4gICAgICAgICAgICB2YXIgbXNnID0gJCh0aGlzKS52YWwoKTtcclxuICAgICAgICAgICAgbXNnID0gbXNnX3NlbnQobXNnKTtcclxuICAgICAgICAgICAgJChcIi5jaGF0LXdpbmRvd3MgI3VzZXItY2hhdFwiICsgaWQgKyBcIiAuY2hhdC1ib2R5IC5jaGF0LWxpc3RcIikuYXBwZW5kKG1zZyk7XHJcbiAgICAgICAgICAgICQodGhpcykudmFsKFwiXCIpO1xyXG4gICAgICAgICAgICAkKHRoaXMpLmZvY3VzKCk7XHJcbiAgICAgICAgfVxyXG4gICAgICAgICQoXCIuY2hhdC13aW5kb3dzICN1c2VyLWNoYXRcIiArIGlkICsgXCIgLmNoYXQtYm9keVwiKS5wZXJmZWN0U2Nyb2xsYmFyKHtcclxuICAgICAgICAgICAgc3VwcHJlc3NTY3JvbGxYOiB0cnVlXHJcbiAgICAgICAgfSk7XHJcbiAgICB9KTtcclxuICAgICQoXCIucGFnZS13cmFwcGVyXCIpLm9uKCdjbGljaycsIGZ1bmN0aW9uIChlKSB7XHJcbiAgICAgICAgJCgnLmNoYXQtd2luZG93cycpLmFkZENsYXNzKCdoaWRlLWNoYXQnKTtcclxuICAgICAgICAkKCcuY2hhdC13aW5kb3dzJykucmVtb3ZlQ2xhc3MoJ3Nob3ctY2hhdCcpO1xyXG4gICAgfSk7XHJcbiAgICAkKFwiLnNlcnZpY2UtcGFuZWwtdG9nZ2xlXCIpLm9uKCdjbGljaycsIGZ1bmN0aW9uIChlKSB7XHJcbiAgICAgICAgJCgnLmNoYXQtd2luZG93cycpLmFkZENsYXNzKCdzaG93LWNoYXQnKTtcclxuICAgICAgICAkKCcuY2hhdC13aW5kb3dzJykucmVtb3ZlQ2xhc3MoJ2hpZGUtY2hhdCcpO1xyXG4gICAgfSk7XHJcbn0pO1xyXG5cclxuZnVuY3Rpb24gbXNnX3JlY2VpdmUobXNnKSB7XHJcbiAgICB2YXIgZCA9IG5ldyBEYXRlKCk7XHJcbiAgICB2YXIgaCA9IGQuZ2V0SG91cnMoKTtcclxuICAgIHZhciBtID0gZC5nZXRNaW51dGVzKCk7XHJcbiAgICByZXR1cm4gXCI8bGkgY2xhc3M9J21zZ19yZWNlaXZlJz48ZGl2IGNsYXNzPSdjaGF0LWNvbnRlbnQnPjxkaXYgY2xhc3M9J2JveCBiZy1saWdodC1pbmZvJz5cIiArIG1zZyArIFwiPC9kaXY+PC9kaXY+PGRpdiBjbGFzcz0nY2hhdC10aW1lJz5cIiArIGggKyBcIjpcIiArIG0gKyBcIjwvZGl2PjwvbGk+XCI7XHJcbn1cclxuXHJcbmZ1bmN0aW9uIG1zZ19zZW50KG1zZykge1xyXG4gICAgdmFyIGQgPSBuZXcgRGF0ZSgpO1xyXG4gICAgdmFyIGggPSBkLmdldEhvdXJzKCk7XHJcbiAgICB2YXIgbSA9IGQuZ2V0TWludXRlcygpO1xyXG4gICAgcmV0dXJuIFwiPGxpIGNsYXNzPSdvZGQgbXNnX3NlbnQnPjxkaXYgY2xhc3M9J2NoYXQtY29udGVudCc+PGRpdiBjbGFzcz0nYm94IGJnLWxpZ2h0LWluZm8nPlwiICsgbXNnICsgXCI8L2Rpdj48YnI+PC9kaXY+PGRpdiBjbGFzcz0nY2hhdC10aW1lJz5cIiArIGggKyBcIjpcIiArIG0gKyBcIjwvZGl2PjwvbGk+XCI7XHJcbn0iXSwic291cmNlUm9vdCI6IiJ9