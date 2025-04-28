$(function () {

    "use strict";


    //===== Prealoder

    // if ($('.preloader').length) {
    //     $('.preloader').fadeOut();
    // }


    const logoImg = document.getElementById("logoRotativo");
    let current = 0;

    setInterval(() => {
    logoImg.style.opacity = 0; // Fade out

    setTimeout(() => {
        current = (current + 1) % logos.length;
        logoImg.src = logos[current];
        logoImg.style.opacity = 1; // Fade in
    }, 1000); // Wait for fade out to complete
    }, 3000);


    //===== Sticky

    $(window).on('scroll', function (event) {
        var scroll = $(window).scrollTop();
        if (scroll < 110) {
            $(".navigation").removeClass("sticky");
        } else {
            $(".navigation").addClass("sticky");
        }
    });


    /*---canvas menu activation---*/
    $('.canvas_open').on('click', function () {
        $('.offcanvas_menu_wrapper,.off_canvars_overlay').addClass('active')
    });

    $('.canvas_close,.off_canvars_overlay').on('click', function () {
        $('.offcanvas_menu_wrapper,.off_canvars_overlay').removeClass('active')
    });

    /*---Off Canvas Menu---*/
    var $offcanvasNav = $('.offcanvas_main_menu'),
        $offcanvasNavSubMenu = $offcanvasNav.find('.sub-menu');
    $offcanvasNavSubMenu.parent().prepend('<span class="menu-expand"><i class="fa fa-angle-down"></i></span>');

    $offcanvasNavSubMenu.slideUp();

    $offcanvasNav.on('click', 'li a, li .menu-expand', function (e) {
        var $this = $(this);
        if (($this.parent().attr('class').match(/\b(menu-item-has-children|has-children|has-sub-menu)\b/)) && ($this.attr('href') === '#' || $this.hasClass('menu-expand'))) {
            e.preventDefault();
            if ($this.siblings('ul:visible').length) {
                $this.siblings('ul').slideUp('slow');
            } else {
                $this.closest('li').siblings('li').find('ul:visible').slideUp('slow');
                $this.siblings('ul').slideDown('slow');
            }
        }
        if ($this.is('a') || $this.is('span') || $this.attr('clas').match(/\b(menu-expand)\b/)) {
            $this.parent().toggleClass('menu-open');
        } else if ($this.is('li') && $this.attr('class').match(/\b('menu-item-has-children')\b/)) {
            $this.toggleClass('menu-open');
        }
    });


    //===== faq accrodion

    if ($('.accrodion-grp').length) {
        var accrodionGrp = $('.accrodion-grp');
        accrodionGrp.each(function () {
            var accrodionName = $(this).data('grp-name');
            var Self = $(this);
            var accordion = Self.find('.accrodion');
            Self.addClass(accrodionName);
            Self.find('.accrodion .accrodion-content').hide();
            Self.find('.accrodion.active').find('.accrodion-content').show();
            accordion.each(function () {
                $(this).find('.accrodion-title').on('click', function () {
                    if ($(this).parent().parent().hasClass('active') === false) {
                        $('.accrodion-grp.' + accrodionName).find('.accrodion').removeClass('active');
                        $('.accrodion-grp.' + accrodionName).find('.accrodion').find('.accrodion-content').slideUp();
                        $(this).parent().parent().addClass('active');
                        $(this).parent().parent().find('.accrodion-content').slideDown();
                    };


                });
            });
        });

    };


    // Single Features Active
    $('.nano-area').on('mouseover', '.nano-item', function () {
        $('.nano-item.active').removeClass('active');
        $(this).addClass('active');
    });

    //===== banner animation slick slider

    function mainSlider() {
        var BasicSlider = $('.banner-slide');
        BasicSlider.on('init', function (e, slick) {
            var $firstAnimatingElements = $('.banner-area:first-child').find('[data-animation]');
            doAnimations($firstAnimatingElements);
        });

        BasicSlider.on('beforeChange', function (e, slick, currentSlide, nextSlide) {
            var $animatingElements = $('.banner-area[data-slick-index="' + nextSlide + '"]').find('[data-animation]');
            doAnimations($animatingElements);
        });

        BasicSlider.slick({
            autoplay: true,
            autoplaySpeed: 4000,
            dots: false,
            fade: true,
            arrows: true,
            prevArrow: '<span class="prev"><i class="fa fa-angle-left"></i></span"></i></span>',
            nextArrow: '<span class="next"><i class="fa fa-angle-right"></i></span>',
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        arrows: false
                    }
                }
            ]
        });

        function doAnimations(elements) {
            var animationEndEvents = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
            elements.each(function () {
                var $this = $(this);
                var $animationDelay = $this.data('delay');
                var $animationType = 'animated ' + $this.data('animation');
                $this.css({
                    'animation-delay': $animationDelay,
                    '-webkit-animation-delay': $animationDelay
                });
                $this.addClass($animationType).one(animationEndEvents, function () {
                    $this.removeClass($animationType);
                });
            });
        }
    }

    mainSlider();

    //===== feedback slide slick slider
    $('.solution-slide-item').slick({
        dots: true,
        infinite: true,
        autoplay: false,
        autoplaySpeed: 2000,
        arrows: false,
        speed: 1000,
        slidesToShow: 1,
        slidesToScroll: 1,

    });


    //===== feedback slide slick slider
    $('.brand-active').slick({
        dots: false,
        infinite: true,
        autoplay: true,
        autoplaySpeed: 2000,
        arrows: false,
        speed: 1000,
        slidesToShow: 5,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 4,
                }
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 4,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 3,
                }
            },
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: 2,
                }
            }
        ]

    });



    //===== feedback slide slick slider
    $('.client-active').slick({
        dots: true,
        infinite: true,
        autoplay: false,
        autoplaySpeed: 2000,
        arrows: false,
        speed: 1000,
        slidesToShow: 3,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 1600,
                settings: {
                    slidesToShow: 2,
                }
            }, {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                    dots: false,
                }
            }
        ]

    });

    //===== feedback slide slick slider
    $('.client-2-active').slick({
        dots: false,
        infinite: true,
        autoplay: false,
        autoplaySpeed: 2000,
        arrows: false,
        speed: 1000,
        slidesToShow: 1,
        slidesToScroll: 1,

    });



    //===== feedback slide slick slider
    $('.project-active').slick({
        dots: true,
        infinite: true,
        autoplay: false,
        autoplaySpeed: 2000,
        arrows: false,
        speed: 1000,
        slidesToShow: 4,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 1600,
                settings: {
                    slidesToShow: 3,
                }
            }, {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                }
            }
        ]

    });


    $('#SelectLanguage').change(function() {
        console.log('Language changed');
        var selectedLanguage = this.value;
        var currentUrl = window.location.href;
        var urlParts = currentUrl.split('/');
        var fileName = urlParts.pop();
        var domain = urlParts.join('/');
        
        if (selectedLanguage === 'en') {
            // Check if the URL does not already contain '/en/' and adjust the URL correctly for subfolders
            if (!currentUrl.includes('/en/')) {
                if (urlParts[urlParts.length - 1] === 'products') {
                    // If current URL is in the 'products' subfolder, insert '/en/' before 'products'
                    var newUrl = domain.replace('/products', '/en/products') + '/' + fileName;
                    window.location.href = newUrl;
                } else {
                    // For other cases, just append '/en/' to the domain
                    window.location.href = domain + '/en/' + fileName;
                }
            }
        } else if (selectedLanguage === 'es') {
            // Check if the URL contains '/en/' and adjust the URL correctly for Spanish
            if (currentUrl.includes('/en/')) {
                var newUrl = currentUrl.replace('/en/', '/');
                window.location.href = newUrl;
            }
        }
    });
    


    //===== feedback slide slick slider
    $('.project-2-active').slick({
        dots: true,
        infinite: true,
        autoplay: true,
        autoplaySpeed: 2000,
        arrows: false,
        speed: 1000,
        slidesToShow: 4,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 1600,
                settings: {
                    slidesToShow: 3,
                }
            }, {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 2,
                    dots: false,
                }
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 2,
                    dots: false,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                    dots: false,
                }
            },
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: 1,
                    dots: false,
                }
            }
        ]

    });


    //===== industri-active slide slick slider
    $('.industri-active').slick({
        dots: true,
        infinite: true,
        autoplay: false,
        autoplaySpeed: 2000,
        arrows: false,
        speed: 1000,
        slidesToShow: 3,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 1600,
                settings: {
                    slidesToShow: 3,
                }
            }, {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                }
            },
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: 1,
                }
            }
        ]

    });



    //====== Magnific Popup

    // $('.video-popup').magnificPopup({
    //     type: 'iframe'
    //     // other options
    // });


    //===== Magnific Popup

    // $('.image-popup').magnificPopup({
    //     type: 'image',
    //     gallery: {
    //         enabled: true
    //     }
    // });


    //===== niceSelect js
    $('select').niceSelect();





    // if ($('.wow').length) {
    //     var wow = new WOW({
    //         boxClass: 'wow', // animated element css class (default is wow)
    //         animateClass: 'animated', // animation css class (default is animated)
    //         offset: 150, // distance to the element when triggering the animation (default is 0)
    //         mobile: true, // trigger animations on mobile devices (default is true)
    //         live: true // act on asynchronously loaded content (default is true)
    //     });
    //     wow.init();
    // }




    //===== Odometer js

    // $('.odometer').appear(function (e) {
    //     var odo = $(".odometer");
    //     odo.each(function () {
    //         var countNumber = $(this).attr("data-count");
    //         $(this).html(countNumber);
    //     });
    // });



    // Progress Bar
    if ($('.progress-line').length) {
        $('.progress-line').appear(function () {
            var el = $(this);
            var percent = el.data('width');
            $(el).css('width', percent + '%');
        }, {
            accY: 0
        });
    }
    if ($('.count-box').length) {
        $('.count-box').appear(function () {
            var $t = $(this),
                n = $t.find(".count-text").attr("data-stop"),
                r = parseInt($t.find(".count-text").attr("data-speed"), 10);

            if (!$t.hasClass("counted")) {
                $t.addClass("counted");
                $({
                    countNum: $t.find(".count-text").text()
                }).animate({
                    countNum: n
                }, {
                    duration: r,
                    easing: "linear",
                    step: function () {
                        $t.find(".count-text").text(Math.floor(this.countNum));
                    },
                    complete: function () {
                        $t.find(".count-text").text(this.countNum);
                    }
                });
            }

        }, {
            accY: 0
        });
    }


    //===== Back to top

    // Scroll Event
    $(window).on('scroll', function () {
        var scrolled = $(window).scrollTop();
        if (scrolled > 300) $('.go-top').addClass('active');
        if (scrolled < 300) $('.go-top').removeClass('active');
    });

    // Click Event
    $('.go-top').on('click', function () {
        $("html, body").animate({
            scrollTop: "0"
        }, 1200);
    });



    //===== 
















});