$(document).ready(function () {
    var myFullpage = false;
    var flagMenu = false;
    headerInit();
    $(window).scroll(function () {
        headerInit();
    });
    $(window).resize(function () {
        headerInit();
    });
    $('select').select2({
        width: '100%'
    });
    $(window).scroll(function () {
        if ($(this).scrollTop() > 1000) {
            $('#top-btn').fadeIn();
        } else {
            $('#top-btn').fadeOut();
        }
    });
    $('#top-btn').click(function () {
        if(myFullpage) {
            myFullpage.moveTo(1);
        } else {
            $('body,html').animate({
                scrollTop: 0
            }, 400);
        }

        return false;
    });
    var reviewSlider = new Swiper('.review-slider', {
        slidesPerView: 1,
        autoHeight: true,
        pagination: {
            el: '.swiper-pagination-review',
            clickable: true
        },
        navigation: {
            nextEl: '.review-arrow .round-button-next',
            prevEl: '.review-arrow .round-button-prev',
        },
        on: {
            init: function () {
                var countSliderRev = $('.review-slider .swiper-slide').length;
                console.log(countSliderRev);
                if(countSliderRev == 1) {

                    $('.review-slider-wrapper .round-button-next,.review-slider-wrapper .round-button-prev').addClass('hidden');

                }
            },
        },


        // pagination: {
        //     el: '.swiper-pagination',
        // },
    });

    var popularPostSlider = new Swiper('.popular-article-slider', {
        autoHeight: true,
        pagination: {
            el: '.popular-article-pagination',
            clickable: true
        },
        navigation: {
            nextEl: '.slider-nav .round-button-next',
            prevEl: '.slider-nav .round-button-prev',
        },
        breakpoints: {
            768: {
                pagination: false,
            },
        }
    });
    var courceSlider = new Swiper('.course-slider', {
        slidesPerView: 1,
        spaceBetween: 25,
        autoHeight: true,
        pagination: {
            el: '.course-pagination',
            clickable: true
        },
        navigation: {
            nextEl: '.cource-nav .round-button-next',
            prevEl: '.cource-nav .round-button-prev',
        },
        breakpoints: {
            768: {
                slidesPerView: 2,
                // pagination: false,
            },
            990: {
                slidesPerView: 3,
            },
        }
    });
    var videoSlider = new Swiper('.video-slider', {
        slidesPerView: 1,
        slidesPerGroup: 1,
        spaceBetween: 25,
        autoHeight: true,
        pagination: {
            el: '.video-pagination',
            clickable: true
        },
        navigation: {
            nextEl: '.video-nav .round-button-next',
            prevEl: '.video-nav .round-button-prev',
        },
        breakpoints: {
            768: {
                slidesPerView: 2,
                slidesPerGroup: 2,
                spaceBetween: 25,
                // pagination: false,
            },
            990: {
                slidesPerView: 3,
                slidesPerGroup: 3,
                spaceBetween: 25,
            },
        }
    });
    var articleSlider = new Swiper('.article-slider', {
        slidesPerView: 1,
        spaceBetween: 25,
        autoHeight: true,
        pagination: {
            el: '.swiper-pagination-article',
            clickable: true
        },
        navigation: {
            nextEl: '.article-nav .round-button-next',
            prevEl: '.article-nav .round-button-prev',
        },
        breakpoints: {
            768: {
                slidesPerView: 2,
                // pagination: false,
            },
            990: {
                slidesPerView: 3,
            },
        }
    });

    $('.menu-trigger,.close-menu').on('click',function (e) {
        e.preventDefault();
        $('.menu-wrapper').stop().fadeToggle(400).toggleClass('activeMenu');
        $('body').toggleClass('no-scroll');
    });

    $('.tiger-parent-faq').on('click',function (e) {
        e.preventDefault();
        $(this).parents('.parent-faq').toggleClass('active').find('.parent-faq-content').stop().slideToggle(400);
    });


    $('.tab-trigger').on('click',function (e) {
        e.preventDefault();
        var tabID = $(this).attr('data-tab');
        if(!$(this).hasClass('active')) {
            $(this).parents('.tab-wrapper-content').find('.tab-trigger').removeClass('active');
            $(this).addClass('active');
            $(this).parents('.tab-wrapper-content').find('.tab-item-wrapper').stop().fadeOut(400,function () {
                $(tabID).fadeIn(400).addClass('active');
            });
        }
        // console.log(tabID);
    });

    $('.trigger-menu-mobile').on('click',function (e) {
        if($(window).width() < 991) {
            if(!flagMenu) {
                e.preventDefault();
                $(this).parents('.menu-col').find('.menu').slideDown(400);
                flagMenu = true;
            }
        }
    });

    $(".ancor").on("click", function (event) {
        event.preventDefault();
        if($(this).hasClass('program-details-navigation-link')) {
            $('.program-details-navigation-link').removeClass('active');
            $(this).addClass('active');
        }
        if($(this).parents('.ancor-menu').length) {
            $('.ancor-menu li a').removeClass('active');
            $(this).addClass('active');
        }
        var id  = $(this).attr('href'),

            top = $(id).offset().top - $('.header').outerHeight();

        //анимируем переход на расстояние - top за 1500 мс
        $('body,html').stop().animate({scrollTop: top}, 1500);
    });

    // $(window).scroll(function () {
    //
    // });

    $('.close-popup-success').on('click',function (e) {
        e.preventDefault();
        $(this).parents('.success-form-wrapper').fadeOut(400);
    });

    $('.shortcode-tab-link').on('click',function (e) {
        e.preventDefault();
        var idTab = $(this).attr('href');
        if(!$(this).hasClass('active')) {
            $('.shortcode-tab-link').removeClass('active');
            $(this).addClass('active');
            $('.shortcode-tab-content .shortcode-tab-content-item').stop().fadeOut(400,function () {
                setTimeout(function () {
                    $(idTab).fadeIn(400);
                },400);
            });
        }
    });
    $('.menu-wrapper .main-menu-title').on('click',function (e) {
        e.preventDefault();
        if($(window).width() < 991) {
            $(this).parents('.main-menu-widget').toggleClass('active');
            $(this).parents('.main-menu-widget').find('.menu').stop().slideToggle(400);
        }
    });
    $('.collapse-text-btn').on('click',function (e) {
        e.preventDefault();

        $(this).parents('.checkerboard-content').find('.collapse-text-block').toggleClass('open-text');
        if($(this).parents('.checkerboard-content').find('.collapse-text-block').hasClass('open-text')) {
            $(this).text('Hide');
        } else {
            $(this).text('Read More');
        }
    });

    $(window).scroll(function () {
        ancorScroll();
    });

    if($('.ancor-menu-inner').height() < $('.ancor-menu-wrapper').height()) {
        $('.ancor-menu-wrapper').addClass('heightAuto');
    }
    // $('.menu-item-has-children').on('click', () => {
    //     console.log($(this));
    // })
    $('.menu-item-has-children').on('click', function () {
        $('.menu-item-has-children').removeClass('active');
        $(this).toggleClass('active');
    })
    $('.menu-item-has-children a').on('click', function (e) {
       if($(this).attr('href') === '#') {
           e.preventDefault();
       }
    })
    $('#menu-sign-menu .sub-menu a').attr('target', '_blank');
    $(document).mouseup(function (e){ // событие клика по веб-документу
        var div = $(".menu-item-has-children"); // тут указываем ID элемента
        if (!div.is(e.target) // если клик был не по нашему блоку
            && div.has(e.target).length === 0) { // и не по его дочерним элементам
            div.removeClass('active'); // скрываем его
        }
    });
    if($('div').is('#fullpage')) {
        myFullpage = new fullpage('#fullpage', {
            licenseKey:"E375C282-63564B3E-BD04263B-BA5809AD",
            scrollOverflow: true,
            verticalCentered: false,
            navigation: true,
            navigationPosition: 'left',
            responsiveWidth: 990,
            scrollOverflowReset: true,
            onLeave: function(origin, destination, direction){
                if((direction === 'down' || direction === 'up') && destination.index !== 0){
                    $('.header').addClass('header-scroll');
                }
                if(direction === 'up' && destination.index === 0) {
                    $('.header').removeClass('header-scroll');
                }
            }
        });
        $('.menu-primary a').on('click', function (e) {
            if($(this).attr('href') === '#preps-programm') {
                e.preventDefault()
                myFullpage.moveTo(2);
            }
        })
    }

    if($('span').is('.txt-rotate')) {
        var TxtRotate = function(el, toRotate, period) {
            this.toRotate = toRotate;
            this.el = el;
            this.loopNum = 0;
            this.period = parseInt(period, 10) || 2000;
            this.txt = '';
            this.tick();
            this.isDeleting = false;
        };

        TxtRotate.prototype.tick = function() {
            var i = this.loopNum % this.toRotate.length;
            var fullTxt = this.toRotate[i];

            if (this.isDeleting) {
                this.txt = fullTxt.substring(0, this.txt.length - 1);
            } else {
                this.txt = fullTxt.substring(0, this.txt.length + 1);
            }

            this.el.innerHTML = '<span class="wrap">'+this.txt+'</span>';

            var that = this;
            var delta = 100 - Math.random() * 100;

            if (this.isDeleting) { delta /= 2; }

            if (!this.isDeleting && this.txt === fullTxt) {
                delta = this.period;
                this.isDeleting = true;
            } else if (this.isDeleting && this.txt === '') {
                this.isDeleting = false;
                this.loopNum++;
                delta = 500;
            }

            setTimeout(function() {
                that.tick();
            }, delta);
        };

        window.onload = function() {
            var elements = document.getElementsByClassName('txt-rotate');
            for (var i=0; i<elements.length; i++) {
                var toRotate = elements[i].getAttribute('data-rotate');
                var period = elements[i].getAttribute('data-period');
                if (toRotate) {
                    new TxtRotate(elements[i], JSON.parse(toRotate), period);
                }
            }
        };
    }
});
function headerInit() {
    var scrollTop = $(window).scrollTop();
    if($('.header').hasClass('header-sticky')) {
        if(scrollTop > 0 ) {
            $('.header').addClass('header-scroll');
        } else {
            $('.header').removeClass('header-scroll');
        }
    }
    if($(window).width() < 991) {
        $('.header').removeClass('header-transparent');
    } else {
        if($('body').hasClass('home')) {
            $('.header').addClass('header-transparent');
        }
    }
}

function ancorScroll() {
    if($('div').hasClass('ancor-menu-col')) {
        var scrollTop = $(window).scrollTop();
        // console.log(scrollTop);
        $('.ancor-text-block').each(function () {
            var elemOffsetTop = $(this).offset().top;
            var elemHeight = $(this).height();
            // console.log(elemOffsetTop);
            var idElem = $(this).attr('id');
            if(scrollTop > (elemOffsetTop - $(window).height()/2) && scrollTop < (elemOffsetTop + elemHeight)) {
                // console.log(elemHeight);
                $('.ancor-menu-link').removeClass('active');
                $('.ancor-menu-link[href="#'+ idElem +'"]').addClass('active');
                // console.log($('.ancor-menu-link[href="#'+ idElem +'"]').offset().top);
                // if($('.ancor-menu-link[href="#'+ idElem +'"]').offset().top > $('.ancor-menu-wrapper').outerHeight()) {
                //     var wrapM = $('.ancor-menu-inner').height();
                //     $('.ancor-menu-wrapper').stop().animate({scrollTop: $('.ancor-menu-wrapper').outerHeight()/2}, 500);
                // }
            }
            // console.log(elemOffsetTop);
        });
    } else {
        return false;
    }
}
