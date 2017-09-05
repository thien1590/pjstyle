<?php
/**
 * Created by PhpStorm.
 * User: NTK
 * Date: 10-Jan-16
 * Time: 6:18 PM
 */
if (is_woocommerce()) {
    $text=$image='';
    if (is_product_category()) {
        global $wp_query;
        $cat = $wp_query->get_queried_object();
        $text = '<h3 class="cover-title">' . $cat->name . '</h3><div class="description">' . $cat->description . '</div>';
        $thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
        $image = wp_get_attachment_url( $thumbnail_id );

    if($image !=''){?>
        <div id="woo-cat-thumb">
            <?php
                if($image !=''){
                    echo '<img src="'.esc_url($image).'" alt=""/>';
                }
            if($text!=''){
                echo '<div class="content-cat-thumb">'. $text.'</div>';
            }
            ?>
        </div>
<?php
    }
    }
}
