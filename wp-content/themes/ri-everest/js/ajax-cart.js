(function($){
    "use strict";
    jQuery(document).ready(function(){
        $('.wrap-icon-cart, .mask-close, .close').live('click',function (e) {
            e.preventDefault();
            CartVisible();
        })

    function CartVisible() {
        $('body').toggleClass('cart-active');
    }
    if ( typeof wc_add_to_cart_params === 'undefined' ) {
        return false;
    }
    //Ajax Remove Cart ===================================
    $('.cart_list .remove').live('click',function (event) {
        event.preventDefault();
        $('.wrap-mini-cart').addClass('loading');
        var $this = $(this);
        var product_key = $this.data('cart-item-key');
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: wc_add_to_cart_params.ajax_url,
            data: {
                action: "cart_remove_product",
                product_key: product_key
            }, success: function (data) {
                var $cart = $('#mini-cart');
                $this.parents('li.mini-cart-item').remove();
                if (data.cart_count == 0) {
                    $cart.find('.cart_list').html('<li class="empty">' + $cart.data('text-emptycart') + '</li>');
                    $cart.find('.cart-bottom').remove();
                } else {
                    $cart.find('.total .woocommerce-Price-amount').replaceWith(data.cart_subtotal);
                }
                $('.btn-header>.primary-font').html(data.cart_count);
                $('.right-cart>.amount').replaceWith(data.cart_subtotal);
                $('.wrap-mini-cart').removeClass('loading');
            }
        });
        return false;
    });

    //Ajax Add to Cart ===================================
    $(document).on('click', '.add_to_cart_button', function () {
        CartVisible();
        $('.rit-drop-wrap').addClass('loading');
    });
    //Ajax Add to Cart Detail ===================================
    $(document).on('click', '.single_add_to_cart_button', function (event) {
        CartVisible();
        $('.wrap-mini-cart').addClass('loading');
        $('#yith-quick-view-modal').removeClass('open');
        var $this = $(this);
        var $productForm = $this.closest('form');

        var data = {
            product_id: $productForm.find("input[name*='add-to-cart']").val(),
            product_variation_data: $productForm.serialize()
        };
        if (!data.product_id) {
            console.log('(Error): No product id found');
            return;
        }
        $.ajax({
            type: 'POST',
            dataType: 'html',
            url: '?add-to-cart=' + data.product_id + '& ajax-add-to-cart=1',
            data: data.product_variation_data,
            cache: false,
            headers: {'cache-control': 'no-cache'},
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log('AJAX error - SubmitForm() - ' + errorThrown);
            },
            success: function (response) {
                var $response = $(response),
                    $shopNotices = $response.find('.woocommerce-message') // Shop notices
//                    Get replacement elements/values
                var fragments = {
                    '.btn-header>.primary-font': $response.find('.btn-header>.primary-font'), // Header menu cart count
                    '.woocommerce-message': $shopNotices,
                    '.right-cart>.amount':  $response.find('.right-cart>.amount'),
                    '.wrap-mini-cart': $response.find('.wrap-mini-cart') // Widget panel mini cart
                };
                console.log(fragments);
                // Replace elements
                $.each(fragments, function (selector, $element) {
                    if ($element.length) {
                        $(selector).replaceWith($element);
                    }
                });
                $('.wrap-mini-cart').removeClass('loading');
            }
        });
        return false;
    });
})})(jQuery);