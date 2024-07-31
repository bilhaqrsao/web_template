(function ($) {
    // USE STRICT
    "use strict";

    $(document).ready(function() {
        var accordion_select = $('.accordion');
        accordion_select.accordion({
            "transitionSpeed": 400
        });
    });

})(jQuery);





(function ($) {
    // USE STRICT
    "use strict";

    $(document).ready(function () {

        var counter_select =  $('.counter');

        counter_select.counterUp({
            delay: 10,
            time: 1000,
            offset: 70,
            beginAt: 100,
            formatter: function (n) {
                return n.replace(/,/g, '.')
            }
        });
    });

})(jQuery);
(function ($) {
    // USE STRICT
    "use strict";

    $(document).ready(function () {

        /*Search form*/
        var search_select = $('.search');
        $( ".search-input" ).on('click', function () {
            search_select.addClass( "search-open");
            event.stopPropagation();
        });
        $(".search-submit").on('click', function (event) {
            search_select.toggleClass( "search-open");
            event.stopPropagation();
        });
        $(window).on('click', function () {
            search_select.removeClass( "search-open");
        });

        /*Fixed Navbar*/

        // Cache Header
        var $header = $('header .navbar-main');
        var navpos = $header.offset();
        // Get height of global-header to use later as starting point
        var $hHeight = $header.height();
        // Set initial position to current position on page
        var prevTop = $(window).scrollTop();

        $(window).on('scroll', function(e) {
            var st = $(this).scrollTop(); // Set scroll location
            if ($(window).scrollTop() > navpos.top) {
                $header.addClass('navbar-fixed');
            }
            else {
                $header.removeClass('navbar-fixed');
            }
            if (st > prevTop && st > $hHeight) {
                $header.addClass('js-global-header-scrolling');
            } else {
                $header.removeClass('js-global-header-scrolling');
            }
            prevTop = st;
        });

        /*Video Block*/
        $('.vimeo a, .youtube a').on('click', function (e) {
            e.preventDefault();
            var videoLink = $(this).attr('href');
            var PlaceV = $(this).parent();
            if ($(this).parent().hasClass('youtube')) {
                $(this).parent().wrapAll('<div class="video-wrapper">');
                $(PlaceV).html('<iframe frameborder="0" height="333" src="' + videoLink + '?autoplay=1&showinfo=0" title="YouTube video player" width="100%"></iframe>');
            } else {
                $(this).parent().wrapAll('<div class="video-wrapper">');
                $(PlaceV).html('<iframe src="' + videoLink + '?title=0&amp;byline=0&amp;portrait=0&amp;autoplay=1&amp;color=cfa144" width="100%" height="300" frameborder="0"></iframe>');
            }
        });

    });

    $(window).on('load', function () {
        $('#loading').fadeOut(500);
    });

})(jQuery);
(function ($) {
    // USE STRICT
    "use strict";

    $(document).ready(function () {

        $('.fancy-select-wrapper .basic').fancySelect();

    });

})(jQuery);
(function ($) {
    // USE STRICT
    "use strict";

    $(document).ready(function () {
        var $isoContainer = $('.isotope-grid');
        var $filter = $('.filter-button-group');

        // filter items on button click
        $filter.each(function () {
            $filter.on( 'click', 'li', function() {
                var filterValue = $(this).attr('data-filter');
                $isoContainer.isotope({ filter: filterValue });
            });
            var $buttonGroup = $('.filter-button-group');
            $buttonGroup.on('click', 'li', function () {
                $buttonGroup.find('.is-checked').removeClass('is-checked');
                $(this).addClass('is-checked');
            });
        });

        // init Isotope
        var $grid = $isoContainer.each(function () {
            $(this).isotope({
                itemSelector: '.isotope-item',
                percentPosition: true,
                masonry: {
                    columnWidth: '.isotope-item'
                }
            });
        });

        // layout Isotope after each image loads
        $grid.imagesLoaded().progress( function() {
            $grid.isotope('layout');
        });
    });

})(jQuery);
(function ($) {
    // USE STRICT
    "use strict";

    $(document).ready(function() {
        $('.match-item').matchHeight({

        });
    });

})(jQuery);
(function ($) {
    // USE STRICT
    "use strict";

    $(document).ready(function() {
        var mmenu = $("#mmenu");
        mmenu.mmenu({
            "extensions": [
                "pagedim-black",
                "theme-blue",
                "shadow-page"
            ],
            "offCanvas": {
                zposition   : "front"
            },
            navbar: {
                title: "INSURANCE"
            },
            "navbars": [
                {
                    "position": "top"
                },
                {
                    "position": "bottom",
                    "content": [
                        "<a class='fa fa-envelope' href='#/'></a>",
                        "<a class='fa fa-twitter' href='#/'></a>",
                        "<a class='fa fa-facebook' href='#/'></a>"
                    ]
                }
            ]
        });
        var API = mmenu.data( "mmenu" );

        $(".navbar-toggle").click(function() {
            API.open();
        });
    });

})(jQuery);





(function ($) {
    // USE STRICT
    "use strict";

    $(document).ready(function() {
        var owlSelector = $('.owl-carousel');
        owlSelector.each(function () {
            var owl = $(this);
            var dots = $(this).attr('data-dots');
            var center = false;
            var col_sm =  1;
            var col_md =  1;
            var col_lg =  1;
            var col_xs =  1;
            var items = 1;
            if ($(this).attr('data-center') == 1) {
                center = true;
            }
            if ($(this).attr('data-items') != null) {
                items = $(this).attr('data-items');
            }
            if ($(this).attr('data-col-xs') != null &&
                $(this).attr('data-col-sm') != null &&
                $(this).attr('data-col-lg') != null &&
                $(this).attr('data-col-md') != null) {

                col_sm = $(this).attr('data-col-sm');
                col_md = $(this).attr('data-col-md');
                col_lg = $(this).attr('data-col-lg');
                col_xs = $(this).attr('data-col-xs');
            }
            $(this).owlCarousel({
                autoplay: true,
                dotsContainer: dots,
                loop: true,
                animateOut: 'fadeOut',
                animateIn: 'fadeIn',
                responsive: {
                    // breakpoint from 0 up
                    0: {
                        items: col_xs,
                        center:center
                    },
                    // breakpoint from 480 up
                    320: {
                        items: col_sm,
                        center:center
                    },
                    // breakpoint from 768 up
                    480: {
                        items: col_md,
                        center:center
                    },
                    992: {
                        items: col_lg,
                        center:center
                    },
                    1200: {
                        items : items
                    }
                }
            });

            $('.owl-dots .owl-dot').on('click', function () {
                owl.trigger('to.owl.carousel', [$(this).index(), 300]);
            });

            // Go to the next item
            $('.slider-arrow .next').on('click', function() {
                owl.trigger('next.owl.carousel');
            });
            // Go to the previous item
            $('.slider-arrow .prev').on('click', function() {
                // With optional speed parameter
                // Parameters has to be in square bracket '[]'
                owl.trigger('prev.owl.carousel', [300]);
            });
        });
    });

})(jQuery);




