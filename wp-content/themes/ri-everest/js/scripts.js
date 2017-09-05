(function ($) {
    'use strict';
    $(window).load(function () {
        $(window).resize(function () {
            Parallax('.rit-element-image-hover.style-3');
            if ($(window).width() < 769) {
                $('#top-rit-footer').slideUp();
            } else {
                $('#top-rit-footer').slideDown();
            }
        }).resize();
        $('.footer-btn').on('click', function () {
            if ($('#top-rit-footer').is(":visible")) {
                $('#top-rit-footer').slideUp();
            } else {
                $('#top-rit-footer').slideDown();
            }
        })
        $('.header-transparent').Stickyfix();
        jQuery('.rit-smart-layout').bind('DOMNodeInserted DOMNodeRemoved', function (event) {
            jQuery('.rit-smart-layout .products').isotope('destroy');
            jQuery('.rit-smart-layout').layoutWoocommerce();
        });
    })
    jQuery(document).ready(function () {
        jQuery(window).resize(function () {
            jQuery('.rit-smart-layout:not(.product-carousel)').layoutWoocommerce();
        }).resize();
        MobileNav();
//For footer fixed
        $(window).resize(function () {
            if ($(window).width() > 768) {
                if ($('.footer-fixed')[0]) {
                    $('.footer-fixed').addClass('fixed');
                    $('body #rit-main').css('margin-bottom', $('.rit-footer').outerHeight());
                }
            }
        }).resize();
//For search
        jQuery('#activesearch').on("click", function () {
            jQuery('#header-search').addClass('active');
            jQuery('#header-search').find('input.ipt').focus();
        })
        jQuery('#close-search').on("click", function () {
            jQuery('#header-search').removeClass('active');
        });
        //For Woocommerce grid layout button group
        jQuery('.grid-layout li').on('hover', function (e) {
            if (e.type == "mouseenter") {
                jQuery(this).find('.wrapper-product-opt .button:first-child').addClass('onhover');
            }
            else { // mouseleave
                jQuery(this).find('.wrapper-product-opt .button').removeClass('onhover');
            }

        });
        jQuery('.grid-layout li .button').on('hover', function () {
            jQuery(this).parents('.wrapper-product-opt').find('.onhover').removeClass('onhover');
            jQuery(this).addClass('onhover');
        });
        $('.everest-billing input').each(function () {
            if ($(this).val() != '') {
                $('label[for=' + $(this).attr('name') + ']').hide();
            }
        })

        $('.everest-billing input').bind('focus', function () {
            $('label[for=' + $(this).attr('name') + ']').hide();
        });
        $('.everest-billing input').bind('focusout', function () {
            if ($(this).val() == '') {
                $('label[for=' + $(this).attr('name') + ']').show();
            }
        });
        $(window).resize(function () {
            if ($('.sidebar-left')[0]) {
                if ($(window).width() > 768) {
                    $('.sidebar-left').css('padding-top', $('.sec-nav-menu').outerHeight() + 'px');
                } else {
                    $('.sidebar-left').css('padding-top', '0');
                }
            }

        }).resize();
        Categorynav();
        $(window).on('resize', function () {
            if ($(window).width() < 768) {
                if ($('.header-default-style-3')[0]) {
                    if ($('.sticky-wrapper')[0]) {
                        $('.stick-active').unstick();
                    }
                    if(!$('#header-page-sticky-wrapper')[0]){					$('.header-default-style-3').sticky();}
                }
            } else {
                if ($('.header-default-style-3')[0]) {
                    $('.stick-active').sticky();
                    if ($('.sticky-wrapper')[0]) {
                        $('.header-default-style-3').unstick();
                    }
                }
            }
        }).resize();
    })
    function Categorynav() {
        if ($('.everest-stick-nav')[0]) {
            //$('.everest-stick-nav li ul').niceScroll();
            if (!jQuery('.everest-stick-nav ').find('.triggernav')[0]) {
                jQuery('.everest-stick-nav li:has("ul")>a').after('<span class="triggernav"><i class="clever-icon-plus"></i></span>');
            }
            toggleMobileNav('.triggernav', '.everest-stick-nav ul li ul');
            $('.everest-stick-nav  .triggernav').on('click', function () {
                if ($(this).find('.clever-icon-plus')[0]) {
                    $(this).find('.clever-icon-plus').removeClass('clever-icon-plus').addClass('clever-icon-minus');
                }
                else {
                    $(this).find('.clever-icon-minus').removeClass('clever-icon-minus').addClass('clever-icon-plus');
                }
            });
            $(window).resize(function () {
                if ($(window).width() > 768) {
                    $('.everest-stick-nav').find('.triggernav').remove();
                    $('.everest-stick-nav').find('.unvisible').removeClass('unvisible');
                }
            }).resize();
        }
    }

    function ChangeSelected() {
        var data;
        var parent;
        $('.clear_variations').hide();
        $('.product-attr').on('click', function () {
            $('.clear_variations').show();
            parent = $(this).parent('div');
            data = $(this).attr('data-id');
            parent.find('.active').removeClass('active');
            $(this).addClass('active');
            parent.find('option:selected').removeAttr('selected');
            if (parent.find('option[value="' + data + '"]')[0]) {
                parent.find('option[value="' + data + '"]').attr('selected', 'selected');
            }
            else {
                parent.find('select').trigger('change');
                parent.find('option[value="' + data + '"]').attr('selected', 'selected');
            }
            parent.find('select').trigger('change');
        });
        $('.clear_variations.btn-border').bind("click", function (e) {
            e.preventDefault();
            $('.reset_variations').trigger('click');
            $('.product-attr').removeClass('active');
            $('.clear_variations').hide();
        });
    }

    /*--------For mobile nav-------*/
    function MobileNav() {
        jQuery('#mobile-nav-block li:has("ul")>a').after('<span class="triggernav"><i class="fa fa-angle-down"></i></span>');
        toggleMobileNav('.triggernav', '#mobile-nav-block ul li ul');
        jQuery('.mobile-nav').on("click", function () {
            jQuery('#mobile-nav-block').toggleClass('active');
            jQuery('#mobile-nav-block').css('top', jQuery('#header-page').height())
        });
        jQuery('#mobile-nav-block').append('<span id="close-nav"></span>');
        jQuery('#close-nav').on("click", function () {
            jQuery('#mobile-nav-block').removeClass('active');
        })
    }

    function toggleMobileNav(trigger, target) {
        jQuery(target).each(function () {
            jQuery(this).attr('data-h', jQuery(this).outerHeight());
        });
        jQuery(target).addClass('unvisible');
        var h;
        var parent;
        jQuery(trigger).on("click", function () {
            h = 0;
            //jQuery(trigger).hasClass('active').removeClass('active');
            //jQuery(this).addClass('active');
            jQuery(this).prev('a').toggleClass('active');
            jQuery(this).toggleClass('active');
            jQuery.this = jQuery(this).next(target);
            if (jQuery.this.hasClass('unvisible')) {
                //Get height of this item
                if (jQuery.this.has("ul").length > 0) {
                    h = parseInt(jQuery.this.attr('data-h')) - parseInt(jQuery.this.find(target).attr('data-h'));
                }
                else {
                    h = parseInt(jQuery.this.attr('data-h'));
                }
                //resize for parent
                jQuery.this.parents(target).each(function () {
                    jQuery(this).css('height', jQuery(this).outerHeight() + h);
                })
                //set height for this item
                jQuery.this.css('height', h + "px");
            }
            else {
                jQuery.this.find(target).not(':has(.unvisible)').addClass('unvisible');
                //resize for parent when this item hide
                h = jQuery.this.outerHeight();
                jQuery.this.parents(target).each(function () {
                    jQuery(this).css('height', jQuery(this).outerHeight() - h);
                })
            }
            jQuery.this.toggleClass('unvisible');
        });
    }

//========================//
//----------Parallax----------//
//========================//
    function Parallax(id) {
        var wdheight = parseInt(jQuery(window).height());
        jQuery(id).each(function () {
            if (jQuery(this).find('.rit-parallax-inner').length == 0) {
                var wrapperW = $(this).width();
                var img = jQuery(this).find('.rit-parallax').attr('data-img');
                if ((jQuery(window).width() / wrapperW) < 2) {
                    jQuery(this).find('.rit-parallax').append('<div class="rit-parallax-inner" style="background-image:url(' + img + ');background-attachment: fixed;"></div>');
                }
                else {
                    jQuery(this).find('.rit-parallax').append('<div class="rit-parallax-inner" style="background:url(' + img + ') repeat-y fixed left center / 50% auto;"></div>');
                }
            }
        });
        jQuery(window).bind("scroll", function () {
            jQuery(id).each(function () {
                var ptop = Math.round(jQuery(this).offset().top - jQuery(window).scrollTop() - wdheight);
                if (wdheight > ptop > -wdheight && $(window).width() > 480) {
                    var p = (ptop / wdheight) * 100;
                    jQuery(this).find(' .rit-parallax-inner').css('transform', 'translateY(' + p + 'px)');
                }
            })
        });
    }

    function RitParallax(id) {
        (function ($) {
            "use strict";
            var wdheight = parseInt(jQuery(window).height());
            jQuery(id).not('.style-3').each(function () {
                jQuery(this).hasClass('style-1').data('height', jQuery(this).height());
                jQuery(this).hasClass('style-1').height(wdheight);
                if (jQuery(this).find('.rit-parallax-inner').length == 0) {
                    var img = jQuery(this).find('.rit-parallax').attr('data-img');
                    jQuery(this).find('.rit-parallax').append('<div class="rit-parallax-inner" style="background-image:url(' + img + ');"></div>');
                }
                if (jQuery(this).hasClass('style-4') && $(window).width() > 480) {
                    var p = jQuery(this).offset().top - jQuery(window).scrollTop();
                    jQuery(this).find('.rit-parallax-inner').css({'top': -p + 'px', 'height': wdheight + 'px'})
                }
            });
            jQuery(window).bind("scroll", function () {
                if ($(window).width() > 480) {
                    jQuery(id).not('.style-3').each(function () {
                        if (jQuery(this).hasClass('style-4') && $(window).width() > 480) {
                            var p = jQuery(this).offset().top - jQuery(window).scrollTop();
                            jQuery(this).find(' .rit-parallax-inner').css({'top': -p + 'px'})
                        }
                        else {
                            var ptop = Math.round(wdheight - (jQuery(this).offset().top - jQuery(window).scrollTop()))
                            if (wdheight > ptop && ptop > 0 && $(window).width() > 480) {
                                var p = (ptop / wdheight) * 100;
                                jQuery(this).find(' .rit-parallax-inner').css('top', -p + '%');
                            }
                        }
                    })
                }
            });
        })(jQuery);
    }

//========================//
//----------Cover img----------//
//========================//
    function RitCover(id) {
        jQuery(id).each(function () {
            jQuery(this).height('auto');
            var height = jQuery(window).height();
            var blockH = jQuery(this).parents('.vc_row').height();
            if (blockH < height || jQuery(window).width() < 768) {
                jQuery(this).height(height);
            }
            else {
                jQuery(this).height(blockH);
            }
            var align = jQuery(this).find('.image-hover-inner').attr('data-align');
            var width = jQuery(this).outerWidth();
            if (align == 'center' || jQuery(window).width() <= 768) {
                jQuery(this).find('.image-hover-inner').width(jQuery(window).width());
                jQuery(this).find('.image-hover-inner').css('left', '-15px');
            }
            else {
                if (align == 'left') {
                    jQuery(this).find('.image-hover-inner').width(width + 15 + jQuery(this).offset().left);
                    jQuery(this).find('.image-hover-inner').css('right', '-15px');
                }
                if (align == 'right') {
                    jQuery(this).find('.image-hover-inner').width(jQuery(window).width() - jQuery(this).offset().left + 15);
                    jQuery(this).find('.image-hover-inner').css('left', '-15px');
                }
            }
            jQuery(this).find('img').addClass('unvisible');
        });
    }

//========================//
//----------Footer fixed----------//
//========================//
    function footerFixed() {
        (function ($) {
            "use strict";
            jQuery(window).resize(function () {
                if ($(window).width() > 768) {
                    jQuery('.rit-footer').addClass('fixed');
                    jQuery('body #rit-main').css('margin-bottom', jQuery('.rit-footer').outerHeight());
                }
            }).resize();
        })(jQuery);
    }

//-------------------Parallax style 7-----------------//
    function RitParallaxS7(id) {
        (function ($) {
            "use strict";
            $(id).each(function () {
                if ($(this).has('.outscreen').length == 0) {
                    var windowH = $(window).height();
                    if ($(window).width() > 768) {
                        jQuery(this).addClass('outscreen');
                        if ($(this).parents('.wrap-block-h4')[0]) {
                            jQuery(this).parents('.wrapper-image-hover').css({
                                'height': $(this).parents('.wrap-block-h4').height() - 20,
                                'overflow': 'hidden'
                            });
                        }
                        else {
                            jQuery(this).parents('.wrapper-image-hover').css({'height': windowH, 'overflow': 'hidden'});
                        }
                    }
                    else {
                        jQuery(this).addClass('onscreen');
                    }
                }
            });
            jQuery(window).bind("scroll", function () {
                if ($(window).width() > 768) {
                    jQuery(id).each(function () {
                        if (jQuery(this).parents('.wrapper-image-hover').onScreen()) {
                            jQuery(this).removeClass('outscreen');
                            jQuery(this).not('.onscreen').addClass('onscreen');
                        }
                        else {
                            jQuery(this).not('.outscreen').addClass('outscreen');
                            jQuery(this).removeClass('onscreen');
                        }

                    });
                    if (jQuery(window).scrollTop() < jQuery(window).height()) {
                        jQuery(id).not('.outscreen').addClass('outscreen');
                        jQuery(id).removeClass('onscreen');
                    }
                }
            })
        })(jQuery);
    }

    function Animation() {
        $('.rit-demo-box[animation!=""]').each(function () {
            $(this).css('opacity', '0');
        })
        jQuery(window).bind("scroll", function () {
            $('.rit-demo-box[animation!=""]').each(function () {
                var classitem;
                if ($(this).ActiveScreen()) {
                    classitem = $(this).attr('animation');
                    $(this).addClass(' animated ' + classitem);
                    $(this).css('opacity', '1');
                }
            });
        })
    }

    //Parallax
    $(window).load(function () {

        jQuery(window).resize(function () {
            RitParallax('.rit-wrapper-parallax');
            RitParallaxS7('.rit-element-image-hover.style-7');
            RitCover('.rit-element-image-hover.style-4');
        }).resize();
        //Parallax s8
        jQuery(window).resize(function () {
            jQuery(window).bind("scroll", function () {
                $('.style-8.rit-parallax-s8').RitParallaxS8();
            })
        }).resize();
        Animation();
    });
    jQuery.fn.extend({
        onScreen: function () {
            var $window = $(window)
            var viewport_top = $window.scrollTop();
            var viewport_height = $window.height()
            var viewport_bottom = viewport_top + viewport_height;
            var $elem = $(this)
            var top = $elem.offset().top
            var height = $elem.height()
            var bottom = top + height;
            return (top <= viewport_top + (height / 3) && top < viewport_bottom + (height / 3)) ||
                (bottom > viewport_top && bottom <= viewport_bottom) ||
                (height > viewport_height && top <= viewport_top && bottom >= viewport_bottom)
        },
        ActiveScreen: function () {
            var itemtop, windowH, scrolltop;
            itemtop = $(this).offset().top;
            windowH = $(window).height();
            scrolltop = $(window).scrollTop();
            if (itemtop < scrolltop + windowH * 2 / 3) {
                return true;
            }
            else {
                return false;
            }
        },
        layoutWoocommerce: function () {
            if (jQuery(this)[0]) {
                jQuery(this).each(function () {
                    var col;
                    var $this = jQuery(this);
                    var wrap_w = $this.outerWidth();
                    if ($this.hasClass('grid-layout') || $this.hasClass('rit-element-builder')) {
                        if (jQuery(window).width() > 361) {
                            var item_w = jQuery(this).data('width');
                            col = Math.floor(wrap_w / item_w);
                        } else {
                            col = 2;
                        }
                        var col_w = wrap_w / col;
                        $this.find('.product-item').outerWidth(col_w - 1);
                    }
                    if ($this.hasClass('list-layout')) {
                        $this.find('.product-item').outerWidth(wrap_w);
                    }
                    $this.find('.products').imagesLoaded(function () {
                        $this.find('.products').isotope({
                            layoutMode: 'fitRows',
                            masonry: {
                                columns: col
                            }
                        });
                    });
                })

            }
        },
        //Fix sticky wp-admin bar
        Stickyfix: function () {
            if ($(this)[0]) {
                if ($('#wpadminbar')[0]) {
                    $(window).on('resize', function () {
                        if ($(window).width() > 600) {
                            if ($('body').find('.header-transparent:not(.header-oneline-2)')[0]) {
                                $('.header-transparent').css('top', $('#wpadminbar').height());
                            }
                            else {
                                var lastCroll = 0;
                                jQuery(window).bind("scroll", function () {
                                    var scroll = jQuery(this).scrollTop();
                                    if (scroll > lastCroll) {
                                        $('#wpadminbar').css('transform', 'translateY(-50px)');

                                    }
                                    else {
                                        $('#wpadminbar').css('transform', 'translateY(0px)');
                                    }
                                    lastCroll = scroll;
                                })
                            }
                        }
                    }).resize();
                }
            }
        },
        RitParallaxS8: function () {
            if ($(this).length > 0) {
                var height = $(window).height();
                if ($(window).width() <= 768) {
                    height = ($(window).height()) * 2
                }
                $(this).css('height', height + 'px');

                if ($(this).onScreen()) {
                    $(this).addClass('onscreen');
                }
                else {
                    $(this).removeClass('onscreen');
                }
            }
        }
    });
})(jQuery)
