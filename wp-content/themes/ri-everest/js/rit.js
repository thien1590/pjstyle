jQuery(document).ready(function(){

    // ---------------------------------------- //
    // SLIDER OWL ----------------------------- //
    // ---------------------------------------- //
    jQuery('#owl-demo').owlCarousel({
        items : 1,
        navigation: true,
        navigationText : ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
        autoPlay : false,
        pagination: false
    });

    // ---------------------------------------- //
    // SLIDER BX ------------------------------ //
    // ---------------------------------------- //
    jQuery('.bxslider').each(function(){
        jQuery(this).bxSlider({
            pager : false,
            nextText: '<i class="fa fa-angle-right"></i>',
            prevText: '<i class="fa fa-angle-left"></i>'
        });
    });

    jQuery('.post-slider').owlCarousel({
        items : 1,
        navigation: true,
        navigationText : ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
        autoPlay : true,
        pagination: false
    });
    // ---------------------------------------- //
    // SCROLLER TOP --------------------------- //
    // ---------------------------------------- //
    jQuery('.arrow-down a').click(function(){
        var element = jQuery(this).attr('href');
        jQuery('html, body').animate({
            scrollTop: jQuery(element).offset().top
        }, 1000);
        return false;
    });


    // ---------------------------------------- //
    // BACK TO TOP --------------------------- //
    // ---------------------------------------- //
    jQuery(window).scroll(function () {
        if (jQuery(this).scrollTop() > 100) {
            jQuery('#back-to-top').addClass('show');
        } else {
            jQuery('#back-to-top').removeClass('show');
        }
    });
    jQuery('#back-to-top').on("click",function () {
        jQuery('body,html').animate({
            scrollTop: 0
        }, 800);
        return false;
    });
    CartQuantity();
    resizeVideo();
    CustomWoocommerceJS();

});
//CartQuantity for single product
function CartQuantity() {
    jQuery('.cart div.quantity').append('<span class="up"><i class="fa fa-angle-right"> </span>');
    jQuery('.cart div.quantity').prepend('<span class="down"><i class="fa fa-angle-left"> </span>');
    jQuery('.cart div.quantity span').on("click", function () {
        var check = jQuery(this).attr('class');
        var parent=jQuery(this).parents('div.quantity').find('input.qty');
        var val = parseInt(parent.val());
        if (check == 'up') {
            parent.val(val + 1);
        }
        else {
            if (val > 1) {
                parent.val(val - 1);
            }
        }
        parent.trigger('change')
    });
}
function resizeVideo() {
    // Find all YouTube videos
    var allVideos = jQuery(".wrapper-video iframe");

// Figure out and save aspect ratio for each video
    allVideos.each(function () {
        jQuery(this).data('aspectRatio', this.height / this.width)
            // and remove the hard coded width/height
            .removeAttr('height')
            .removeAttr('width');

    });

// When the window is resized
    jQuery(window).resize(function () {

        var newWidth = jQuery(".wrapper-video").width();
        // Resize all videos according to their own aspect ratio
        allVideos.each(function () {

            var el = jQuery(this);
            el
                .width(newWidth)
                .height(newWidth * el.data('aspectRatio'));

        });
// Kick off one resize to fix all videos on page load
    }).resize();
}
//===============Woo js======================//
function CustomWoocommerceJS() {
    setTimeout(function () {
        jQuery('.woocommerce-message').css('right', '0');
    }, 500);
    setTimeout(function () {
        jQuery('.woocommerce-message').removeAttr('style');
    }, 3000);
//Set cookie for change product layout
    jQuery('.pageviewitem').live("click", function () {
        jQuery('.pageviewitem.active').removeClass('active');
        jQuery(this).addClass('active');
        if(jQuery(this).attr('data-view')=='grid'){
            jQuery('.rit-smart-layout').removeClass('list-layout').addClass('grid-layout');
        }else{
            jQuery('.rit-smart-layout').removeClass('grid-layout').addClass('list-layout');
        }
        jQuery('.rit-smart-layout').layoutWoocommerce();
        if (jQuery.cookie('product-view') != '') {
            jQuery.cookie('product-view', jQuery(this).attr('data-view'));
        }
    });
    if( jQuery('body.woocommerce-page')[0]){
        jQuery('body').append('<div class="mask-product-page"><span class="close-sidebar"><i class="clever-icon-close"></i> </span></div>');
    }
    jQuery('.filter-trigger').on('click',function () {
        jQuery('body').addClass('sidebar-active');
    });
    jQuery('.mask-product-page, .close-sidebar').live('click',function () {
        jQuery('body').removeClass('sidebar-active');
    })
}