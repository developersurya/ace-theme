jQuery(document).ready(function ($) {

    if ($('#module-video').length > 0) {

        $(".fancybox-video").fancybox({
            type: "iframe",
            width		: '85%',
            height		: '55%',
        })

    }
    //trip booking form : dates
    if($('body.page-template-tpl-trip-booking-form').length != 0) {
        if($("#input_2_37").val() == '') {
            $('#field_2_37').remove();
        }
    }
    //==============================================================
    // get Widget title as a widget class
    // ==============================================================

    $('.widget_text').each( function(){
        var widgetTitle = $(this).find('.widget-title').text(),
            widgetTitleSlug = widgetTitle.replace(/ /gi, "-");

        widgetTitleSlug = widgetTitleSlug.toLowerCase();
        widgetTitleSlug = "widget-" + widgetTitleSlug;
        $(this).addClass(widgetTitleSlug);
    });

    $('.widget_nav_menu ul').removeClass('sub-menu').addClass('sub-menu-widget');
    $('.widget_nav_menu li').removeClass('menu-item-has-children');

    /*For mobile and desktop menu
     * ======================================================================
     * ======================================================================
     * */



    if ($(window).width() < 1200) {
        $('.mobile-menu').css('display', 'block');
        $('.mobile-menu-wrap').css('display', 'block');
        $('#masthead').css('display', 'none');
    } else {
        $('.mobile-menu').css('display', 'none');
        $('.mobile-menu-wrap').css('display', 'none');
        $('#masthead').css('display', 'block');
    }

    if ($(window).width() > 1200) {
        $('.menu-item-has-children').hover(function () {
            $('.sub-menu', this).not('.sub-menu .sub-menu', this).stop().toggle("fast");
        });
        $('.sub-menu .menu-item-has-children').hover(function () {
            $('.sub-menu', this).stop().toggle("fast");
        });
    }
    $(window).on("resize", function (e) {
        if ($(window).width() < 1200) {
            $('.mobile-menu').css('display', 'block');
            $('.mobile-menu-wrap').css('display', 'block');
            $('#masthead').css('display', 'none');
        } else {
            $('.mobile-menu').css('display', 'none');
            $('.mobile-menu-wrap').css('display', 'none');
            $('#masthead').css('display', 'block');
        }
    });


    if ($(window).width() < 1183) {
        jQuery(window).scroll(function () {
            var scroll = jQuery(window).scrollTop();
            if (scroll <= 120) {
                jQuery(".top-space").css({"height": "90px"});
            }
        });
    } else {
        jQuery(window).scroll(function () {
            var scroll = jQuery(window).scrollTop();
            if (scroll <= 120) {
                jQuery(".top-space").css({"height": "90px"});
            }
        });
    }
    if ($('body.single-trip').length > 0) {
        if (window.location.hash) {
            var h = window.location.hash;
            var _h = h.substring(1);
            console.log(h + '--' + _h);
            setTimeout(function () {
                $('.trip-tab .nav-tabs a.' + _h).trigger('click');
            }, 1000);

        }
    }

});

// Hide Sticky Header
$(document).ready(function () {
    $("#journey-type a, #team-tab a, #ajax-tab a").click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });

    $("#homeslider").carousel({
        //interval: 5000
        interval: false
    });
    $("#homeslider").swiperight(function() {
        $(this).carousel('prev');
    });
    $("#homeslider").swipeleft(function() {
        $(this).carousel('next');
    });
    $("#testimonial-slider").carousel();
    $("#testimonial-slider").swiperight(function() {
        $(this).carousel('prev');
    });
    $("#testimonial-slider").swipeleft(function() {
        $(this).carousel('next');
    });
    $('.selectpicker').selectpicker({
        style: 'btn-info',
        size: 4
    });
    $("select.search-trip").selectbox();

        $('.border-box').matchHeight({
            byRow: true
        });

        $('.equal-box').matchHeight({
            byRow: false
        });
    $(window).bind('orientationchange', function(event) {
        $('.border-box').matchHeight({
            byRow: true
        });
    });
    $('.tab-equipment-content ul').addClass('clearfix'); //This is for formatting the layout and for the client comfort
    /* $("#booking-dates").tablesorter();*/ //Booking date sort
    $("[data-toggle='tooltip']").tooltip({
        container: 'body'
    });

    //$("td.closed").on('hover', function () {
    //    $(this).children("div.closed").toggle();
    //});
    //$("td.limited").on('hover', function () {
    //    $(this).children("div.limited").toggle();
    //});
    //$("td.guaranteed").on('hover', function () {
    //    $(this).children("div.guaranteed").toggle();
    //});


    function bsCarouselAnimHeight() {
        $('.carousel').carousel({
            interval: 5000
        }).on('slide.bs.carousel', function (e) {
            var nextH = $(e.relatedTarget).height();
            $(this).find('.active.item').parent().animate({
                height: nextH
            }, 500);
        });
    }

    bsCarouselAnimHeight();

    $(".fancybox").fancybox();

    //  Check Radio-box
    $("#gform_fields_10 ul.gfield_radio > li > input[type='radio']").attr("checked", false);
    $("#gform_fields_10 ul.gfield_radio > li > input[type='radio']").click(function () {
        //if ( $( this).closest( "li" ).hasClass( "checked" ) ) {
        //    $(this).parent().removeClass('checked');
        //}
        $( this).closest( "ul").children("li").removeClass('checked');
        $(this).parent().addClass('checked');
    });

    /*Cookie setup*/
    document.addEventListener('scroll', function (event) {
        if (document.body.scrollHeight ==
            document.body.scrollTop +
            window.innerHeight) {
            setTimeout(function () {
                var show_popup = $.cookie('subscribe_popup');
                if (typeof(show_popup) == 'undefined') {
                    $.cookie('subscribe_popup', 'yes');
                    $('.pop').trigger('click');
                }
            }, 10000);
        }
    });
    //=================

    $('.mobile-nav-btn').click(function () {
        // return $(this).toggleClass("active"), $("#navigation-menu.active-nav").length > 0 ? $("#navigation-menu").fadeOut(500) : $("#navigation-menu").fadeIn(500),
         $(".mobile-nav-wrap #navigation-menu").toggleClass("active-nav");
         $("body").toggleClass("overflow");
        // $(this).toggleClass("active");

    });
    if ($('.main-nav ').length > 0) {
        $('#navigation-menu li.menu-item-has-children').prepend('<i class="sub-menu-toggle"></i>');
        $('.sub-menu-toggle').click(function (e) {
            // Prevent default behaviour
            e.preventDefault();
            if ($(this).hasClass('menu-open')) {

                $(this).parent('li.menu-item-has-children').children('ul').slideToggle('slow');
                $(this).parent('li.menu-item-has-children').removeClass('active');
                $('#navigation-menu ul li').removeClass('inactive');
                $(this).toggleClass('menu-open');
            } else {
                $('#navigation-menu ul li').addClass('inactive');
                $('#navigation-menu ul li').removeClass('active');
                $(this).removeClass('menu-open');
                $(this).parent('li.menu-item-has-children').children('ul').slideUp('slow');
                $(this).parent('li.menu-item-has-children').children('ul').slideToggle('slow');
                $(this).parent('li.menu-item-has-children').removeClass('inactive');
                $(this).parent('li.menu-item-has-children').addClass('active');
                $(this).toggleClass('menu-open');

            }
        });
    }
    //sticky Header
    $(window).on("resize scroll", function (e) {
        if ($(this).scrollTop() > 119) {
            $('#masthead').addClass("sticky");
        } else {
            $('#masthead').removeClass("sticky");

        }

        var top_offset = $(window).scrollTop();
        if (top_offset < 700) {
            $('.single-trip .trip-tab--heading').removeClass('sticky');

            $('.single-trip #masthead').removeClass('none');
        } else {
            $('.single-trip .trip-tab--heading').addClass('sticky');
            $('.single-trip #masthead').addClass('none');

        }
        /*Sidebar dim in scroll */
        if (top_offset < 1000) {
            $('.trip-sidebar').parent().removeClass('opacity');
        } else {
            $('.trip-sidebar').parent().addClass('opacity');
        }


    });


    // Adding placeholder into the comment form fields
    $('#commentform #comment').attr('placeholder', 'Comment *');
    $('#commentform #author').attr('placeholder', 'Full Name *');
    $('#commentform #email').attr('placeholder', 'Email *');


    $("#menu-primary-menu li .sub-menu li .sub-menu").each(function () {

        if ($(this).children('li').size() > 4) {
            $(this).addClass('three-col');
        }
    });
    $("#menu-primary-menu > li:last-child").each(function () {
        if ($(window).width() > 1200) {
            $(this).addClass('right');
        }
    });

    /*Menu break down into columns as per the list count*/
    $(document).ready(function () {
        $.each($('.sub-menu .sub-menu'), function () {
            var length = $("li", this).length;
            if (length > 10) {
                $(this).addClass('lenght-2');
            }
            if (length > 30) {
                $(this).addClass('lenght-3');
            }
        });

    });

    // Hide Header on on scroll down
    var didScroll;
    var lastScrollTop = 0;
    var delta = 5;
    var navbarHeight = $('#masthead').outerHeight();

    $(window).scroll(function (event) {
        didScroll = true;
    });

    setInterval(function () {
        if (didScroll) {
            hasScrolled();
            didScroll = false;
        }
    }, 250);

    function hasScrolled() {
        var st = $(this).scrollTop();

        // Make sure they scroll more than delta
        if (Math.abs(lastScrollTop - st) <= delta)
            return;

        // If they scrolled down and are past the navbar, add class .nav-up.
        // This is necessary so you never see what is "behind" the navbar.
        if (st > lastScrollTop && st > 90) {
            // Scroll Down
            $('#masthead').addClass('nav-up');
            $('.sticky-short-desc').addClass('nav-up');
        } else {
            // Scroll Up
            if (st + $(window).height() < $(document).height()) {
                $('#masthead').removeClass('nav-up');
                $('.sticky-short-desc').removeClass('nav-up');
            }
        }

        lastScrollTop = st;
    }

    /**
     *  Detect if dropdown navigation would go off screen and reposition it
     */

    // $(".primary-menu li").on('mouseenter mouseleave', function (e) {
    //     if ($('ul', this).length) {
    //         var elm = $('ul:first', this);
    //         var off = elm.offset();
    //         var l = off.left;
    //         var w = elm.width();
    //         var docH = $("body").height();
    //         var docW = $("body").width();

    //         var isEntirelyVisible = (l + w <= docW);

    //         if (!isEntirelyVisible) {
    //             $(this).addClass('edge');
    //         } else {
    //             $(this).removeClass('edge');
    //         }
    //     }
    // });
    // 
    // 
    // 
    var win_width = jQuery(window).width();
    var half = win_width / 2;
    jQuery('#menu-primary-menu-1 > li').each(function() {
      var pos = jQuery(this).offset().left;
      if( pos <= half ) {
        jQuery(this).addClass('left-menu');
      } else {
        jQuery(this).addClass('right-menu');
      }
    });

    // Star Rating
    var logID = 'log',
        log = $('<div id="'+logID+'"></div>');
    $('body').append(log);
    $('[type*="radio"]').change(function () {
        var me = $(this);
        log.html(me.attr('value'));
    });


    ;( function ( document, window, index )
    {
        'use strict';

        var elSelector		= '.mobile-menu',
            elClassHidden	= 'header--hidden',
            throttleTimeout	= 200,
            element			= document.querySelector( elSelector );

        if( !element ) return true;

        var dHeight			= 0,
            wHeight			= 0,
            wScrollCurrent	= 0,
            wScrollBefore	= 0,
            wScrollDiff		= 0,

            hasElementClass		= function( element, className ){ return element.classList ? element.classList.contains( className ) : new RegExp( '(^| )' + className + '( |$)', 'gi' ).test( element.className ); },
            addElementClass		= function( element, className ){ element.classList ? element.classList.add( className ) : element.className += ' ' + className; },
            removeElementClass	= function( element, className ){ element.classList ? element.classList.remove( className ) : element.className = element.className.replace( new RegExp( '(^|\\b)' + className.split( ' ' ).join( '|' ) + '(\\b|$)', 'gi' ), ' ' ); },

            throttle = function( delay, fn )
            {
                var last, deferTimer;
                return function()
                {
                    var context = this, args = arguments, now = +new Date;
                    if( last && now < last + delay )
                    {
                        clearTimeout( deferTimer );
                        deferTimer = setTimeout( function(){ last = now; fn.apply( context, args ); }, delay );
                    }
                    else
                    {
                        last = now;
                        fn.apply( context, args );
                    }
                };
            };

        window.addEventListener( 'scroll', throttle( throttleTimeout, function()
        {
            dHeight			= document.body.offsetHeight;
            wHeight			= window.innerHeight;
            wScrollCurrent	= window.pageYOffset;
            wScrollDiff		= wScrollBefore - wScrollCurrent;

            if( wScrollCurrent <= 0 ) // scrolled to the very top; element sticks to the top
                removeElementClass( element, elClassHidden );

            else if( wScrollDiff > 0 && hasElementClass( element, elClassHidden ) ) // scrolled up; element slides in
                removeElementClass( element, elClassHidden );

            else if( wScrollDiff < 0 ) // scrolled down
            {
                if( wScrollCurrent + wHeight >= dHeight && hasElementClass( element, elClassHidden ) ) // scrolled to the very bottom; element slides in
                    removeElementClass( element, elClassHidden );

                else // scrolled down; element slides out
                    addElementClass( element, elClassHidden );
            }

            wScrollBefore = wScrollCurrent;
        }));

    }( document, window, 0 ));

    if ($('.sticky-widget').length > 0) {
        $('.sticky-widget').sticky({
            topSpacing: 0, // Space between element and top of the viewport
            zIndex: 1, // z-index
            stopper: ".bottom-block-content", // Id, class, or number value
            stickyClass: true
        });
    }
    if ($('#sticky-menu-container').length > 0) {
        $('#sticky-menu-container').sticky({
            topSpacing: 54, // Space between element and top of the viewport
            zIndex: 1, // z-index
            stopper: "#footer" // Id, class, or number value
        });
    }
    $( ".trip-tab .nav-tabs li a" ).click(function() {
        var active_tab = $(this).attr('href');
        $(".extra-info").removeClass('show');
        if(active_tab == '#tab-overview'){
            $(".extra-info").removeClass('show');
            $(".extra-info").addClass('show');
        }
        if(active_tab == '#tab-itinerary') {
            $(".extra-info").removeClass('show');
            $(".extra-info").addClass('show');
        }

    });

    if ($('.trip-tab').length > 0) {
        $(".trip-tab .nav-tabs li a").click(function () {
            //var tab_position = $( this ).offset();
            //$("html, body").scrollTop($( this ).offset().top);


            var initial_pos = $("#trip-container").offset().top;
            var actual_pos = initial_pos - 70;
            $('html, body').animate({
                scrollTop: actual_pos
            }, 200);



        });
    }


    if ($('.link-to-review').length > 0) {
        $(".link-to-review").click(function (event) {
            event.preventDefault();
            $('html, body').animate({
                scrollTop: $(".trip-review").offset().top
            }, 400);

        });
    }

// Select dropdowns
    if ($('.gform_body select').length) {
        // Traverse through all dropdowns
        $.each($('.gform_body select'), function (i, val) {
            var $el = $(val);

            // If there's any dropdown with default option selected
            // give them `not_chosen` class to style appropriately
            // We assume default option to have a value of '' (empty string)
            if (!$el.val()) {
                $el.addClass("not_chosen");
            }

            // Add change event handler to do the same thing,
            // i.e., adding/removing classes for proper
            // styling. Basically we are emulating placeholder
            // behaviour on select dropdowns.
            $el.on("change", function () {
                if (!$el.val())
                    $el.addClass("not_chosen");
                else
                    $el.removeClass("not_chosen");
            });

            // end of each callback
        });
    }

    $(".group-discount").click(function(){
        $(this).next().stop().slideToggle();
    });

    $(".check-availability").click(function(){
        $( ".tab-dates" ).trigger( "click" );
    });


    if ($('.related-trip-slider').length > 0) {
        $(".related-trip-slider").slick({
            dots: false,
            infinite: true,
            slidesToShow: 2,
            slidesToScroll: 2,
            responsive: [
                {
                    breakpoint: 1100,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        infinite: true,
                        arrows:false,
                        dots: true
                    }
                },
                {
                    breakpoint: 500,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        dots: true
                    }
                }
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
            ]
        });
    }

    $( ".phone-list-trigger" ).click(function() {
        $( this).next(".quick-contact--menu-secondary").stop().slideToggle( 500 );
    });

    //end
});

$( window ).load(function() {
    /*Support for menu
     * =========================
     * =========================*/
    if ($(window).width() < 1200) {
        var metabarHeight = $('.mobile-menu .site-header').height();
        $('.metabar--spacer').css('height', metabarHeight + 'px');
        $(window).on("resize", function (e) {
            var metabarHeight = $('.mobile-menu .site-header').height();
            $('.metabar--spacer').css('height', metabarHeight + 'px');
        });
    } else {
        var metabarHeight = $('#masthead').height();
        $('.metabar--spacer').css('height', metabarHeight + 'px');
        $(window).on("resize", function (e) {
            var metabarHeight = $('#masthead').height();
            $('.metabar--spacer').css('height', metabarHeight + 'px');
        });
    }
    $(window).on("resize", function (e) {
        if ($(window).width() < 1200) {
            var metabarHeight = $('.mobile-menu .site-header').height();
            $('.metabar--spacer').css('height', metabarHeight + 'px');
            $(window).on("resize", function (e) {
                var metabarHeight = $('.mobile-menu .site-header').height();
                $('.metabar--spacer').css('height', metabarHeight + 'px');
            });
        } else {
            var metabarHeight = $('#masthead').height();
            $('.metabar--spacer').css('height', metabarHeight + 'px');
            $(window).on("resize", function (e) {
                var metabarHeight = $('#masthead').height();
                $('.metabar--spacer').css('height', metabarHeight + 'px');
            });
        }
    });

   // jQuery custom scrollbar
    if ($('#custom-scroller').length > 0) {
        $("#custom-scroller").mCustomScrollbar({
            theme: "minimal"
        });
    }

     //new scroll top animation added
     // $(".trip-tab .nav-tabs li a").click(function () {
     //        $('html, body').animate({
     //            scrollTop: $(".tab-content").offset().top
     //        }, 200);

     //    });
     //    
     //    


     //new page js
     $('.single-trip .no-price-avl').parent().css('margin','150px 0 75px'); 

     //home-page inquiry logic
     
     $(document).on('click','.home-inq-btn,.enq-without-date',function(){

            var data = $(this).attr('data-title');
            $('#input_7_10').val(data);
            localStorage.setItem('trip_title',data);
            //debugger;
            $('.border-btm').remove();
            $('#field_7_10').append('<h1 class="border-btm">'+ data +'</h1>');
            $('#field_7_17').hide();
      });

     //After gravity form submit check title
        function errorListeners(){
            var data = localStorage.getItem('trip_title');
            $('#input_7_10').val(data);
            //debugger;
            $('.border-btm').remove();
            $('#field_7_10').append('<h1 class="border-btm">'+ data +'</h1>');
            $('#field_7_17').hide();
             localStorage.removeItem('trip_title');
           //alert(data);
        }

        jQuery(document).bind('gform_post_render', function(){
           errorListeners();
        });

    $(document).on('hover','.gravity-process-payment,.gravity-direct-bank',function(e){
        //debugger;
         if($('.number-of-pax select').val() == "" || $('.number-of-pax select').val() == 0  ){
                alert('Please choose Number of Pax');
            }
    });
});

