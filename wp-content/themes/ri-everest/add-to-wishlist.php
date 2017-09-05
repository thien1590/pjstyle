<?php
/**
 * Add to wishlist template
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Wishlist
 * @version 2.0.0
 */

global $product;
?>

<div class="yith-wcwl-add-to-wishlist button add-to-wishlist-<?php echo esc_attr($product_id) ?>">
    <?php if (!($disable_wishlist && !is_user_logged_in())): ?>
        <div class="yith-wcwl-add-button btn-wishlist <?php echo ($exists && !$available_multi_wishlist) ? 'hide' : 'show' ?>"
            style="display:<?php echo ($exists && !$available_multi_wishlist) ? 'none' : 'block' ?>">
            <?php yith_wcwl_get_template('add-to-wishlist-' . $template_part . '.php', $atts); ?>

        </div>


        <a class="yith-wcwl-wishlistaddedbrowse btn-wishlist hide" style="display:none;"
           href="<?php echo esc_url($wishlist_url) ?>"
           title="<?php echo apply_filters('yith-wcwl-browse-wishlist-label', $browse_wishlist_text) ?>">
            <i class="fa fa-check"></i>
            <span><?php echo apply_filters('yith-wcwl-browse-wishlist-label', $browse_wishlist_text) ?></span>
        </a>


        <a class="yith-wcwl-wishlistexistsbrowse btn-wishlist <?php echo ($exists && !$available_multi_wishlist) ? 'show' : 'hide' ?>"
           style="display:<?php echo ($exists && !$available_multi_wishlist) ? 'block' : 'none' ?>"
           href="<?php echo esc_url($wishlist_url) ?>"
           title="<?php echo apply_filters('yith-wcwl-browse-wishlist-label', $browse_wishlist_text) ?>">
            <i class="fa fa-check"></i>
            <span><?php echo apply_filters('yith-wcwl-browse-wishlist-label', $browse_wishlist_text) ?></span>
        </a>
    <?php else: ?>
        <a
           href="<?php echo esc_url(add_query_arg(array('wishlist_notice' => 'true', 'add_to_wishlist' => $product_id), get_permalink(wc_get_page_id('myaccount')))) ?>"
           title="<?php echo esc_attr($label) ?>" rel="nofollow"
           class="btn-wishlist <?php echo str_replace('add_to_wishlist', '', $link_classes) ?>">
            <i class="fa fa-heart-o"></i>
            <span><?php echo esc_attr($label) ?></span>
        </a>
    <?php endif; ?>

</div>