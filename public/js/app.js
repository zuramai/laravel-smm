/*
 Template Name: Zinzer - Responsive Bootstrap 4 Admin Dashboard
 Author: ThemeDesign
 File: Main js
 */



!function($) {
    "use strict";

    var MainApp = function() {};

    MainApp.prototype.initNavbar = function () {

        $('.navbar-toggle').on('click', function (event) {
            $(this).toggleClass('open');
            $('#navigation').slideToggle(400);
        });

        $('.navigation-menu>li').slice(-1).addClass('last-elements');

        $('.navigation-menu li.has-submenu a[href="#"]').on('click', function (e) {
            if ($(window).width() < 992) {
                e.preventDefault();
                $(this).parent('li').toggleClass('open').find('.submenu:first').toggleClass('open');
            }
        });
    },
    MainApp.prototype.initLoader = function () {
        $(window).on('load', function() {
            $('#status').fadeOut();
            $('#preloader').delay(350).fadeOut('slow');
            $('body').delay(350).css({
                'overflow': 'visible'
            });
        });
    },
    MainApp.prototype.initScrollbar = function () {
        $('.slimscroll-noti').slimScroll({
            height: '208px',
            position: 'right',
            size: "5px",
            color: '#98a6ad',
            wheelStep: 10
        });
    }
    // === fo,llowing js will activate the menu in left side bar based on url ====
    MainApp.prototype.initMenuItem = function () {
        $(".navigation-menu a").each(function () {
            var pageUrl = window.location.href.split(/[?#]/)[0];
            if (this.href == pageUrl) { 
                $(this).parent().addClass("active"); // add active to li of the current link
                $(this).parent().parent().parent().addClass("active"); // add active class to an anchor
                $(this).parent().parent().parent().parent().parent().addClass("active"); // add active class to an anchor
            }
        });
    },
    MainApp.prototype.initComponents = function () {
        $('[data-toggle="tooltip"]').tooltip();
        $('[data-toggle="popover"]').popover();
    },
    MainApp.prototype.initToggleSearch = function () {
        $('.toggle-search').on('click', function () {
            var targetId = $(this).data('target');
            var $searchBar;
            if (targetId) {
                $searchBar = $(targetId);
                $searchBar.toggleClass('open');
            }
        });
    },

    MainApp.prototype.init = function () {
        this.initNavbar();
        this.initLoader();
        this.initScrollbar();
        this.initMenuItem();
        this.initComponents();
        this.initToggleSearch();
    },

    //init
    $.MainApp = new MainApp, $.MainApp.Constructor = MainApp
}(window.jQuery),

//initializing
function ($) {
    "use strict";
    $.MainApp.init();
}(window.jQuery);
