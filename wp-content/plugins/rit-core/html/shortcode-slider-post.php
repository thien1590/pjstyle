<?php
/**
 * RIT Core Plugin
 * @package     RIT Core
 * @version     0.1
 * @author      CleverSoft
 * @link        http://cleversoft.co
 * @copyright   Copyright (c) 2015 CleverSoft
 * @license     GPL v2
 */

$args = array(
    'post_type' => 'post',
    'posts_per_page' => ($atts['number'] > 0) ? $atts['number'] : get_option('posts_per_page')
);
if ($atts['cat'] != '') {
    if ($atts['parent'])
        $args['cat'] = $atts['cat'];
    else
        $args['category__in'] = explode(',', $atts['cat']);
}
if ($atts['post_in'] != '')
    $args['post__in'] = explode(',', $atts['post_in']);
if($atts['featured']){
    $args['meta_key'] = '_featured-post';
    $args['meta_value'] = 1;
}

$item = $atts['columns'];
if (empty($atts['slider_thumb'])):
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function () {
            jQuery("<?php if($atts['el_class']!='') echo '.'.$atts['el_class'];?>.rit-blog-carousel").owlCarousel({
                // Most important owl features
                items: '<?php echo $item ?>',
                itemsCustom: false,
                itemsDesktop: [1199, <?php echo $item; ?>],
                itemsDesktopSmall: [980, <?php if($item>1) { echo $item-1; }else{echo 1;} ?>],
                itemsTablet: [768, <?php if($item>2) { echo $item-2; }else{echo 1;} ?>],
                itemsTabletSmall: false,
                itemsMobile: [479, 1],
                singleItem: false,
                itemsScaleUp: false,
                // Navigation
                pagination: <?php if($atts['slider_pagination']==1) {
                        echo 'true';
                        }else{echo 'false';}?>,
                navigation: <?php if($atts['slider_nav']==1) {
                        echo 'true';
                        }else{echo 'false';}?>,
                navigationText: ['<span class="max-arrow left-arrow"></span>', '<span class="max-arrow right-arrow"></span>'],
                rewindNav: true,
                scrollPerPage: false,
                autoPlay: true,
                stopOnHover: true,
                rewindSpeed: 3000
            })
        });
    </script><?php
else:?>
    <script>
        jQuery(document).ready(function () {
            ConfigThumb("<?php if($atts['el_class']!='') echo '.'.$atts['el_class'];?> .rit-blog-carousel","<?php if($atts['el_class']!='') echo '.'.$atts['el_class'];?> .rit-blog-thumb", <?php echo $item ?>)
        })
        function ConfigThumb(param1, param2, numb) {
            (function ($) {
                "use strict";
                var sync1 = $(param1);
                var sync2 = $(param2);
                sync1.owlCarousel({
                    singleItem: true,
                    slideSpeed: 1000,
                    pagination: <?php if($atts['slider_pagination']==1) {
                        echo 'true';
                        }else{echo 'false';}?>,
                    navigation: <?php if($atts['slider_nav']==1) {
                        echo 'true';
                        }else{echo 'false';}?>,
                    navigationText: ['<span class="max-arrow left-arrow"></span>', '<span class="max-arrow right-arrow"></span>'],
                    afterAction: syncPosition,
                    responsiveRefreshRate: 200,
                });
                sync2.owlCarousel({
                    items: numb,
                    itemsDesktop: [1199, numb],
                    itemsDesktopSmall: [979, numb],
                    itemsTablet: [768, 2],
                    itemsMobile: [479, 1],
                    pagination: false,
                    responsiveRefreshRate: 100,
                    afterInit: function (el) {
                        el.find(".owl-item").eq(0).addClass("synced");
                    }
                });
                function syncPosition(el) {
                    var current = this.currentItem;
                    $(param2)
                        .find(".owl-item")
                        .removeClass("synced")
                        .eq(current)
                        .addClass("synced")
                    if ($(param2).data("owlCarousel") !== undefined) {
                        center(current)
                    }
                }
                $(param2).on("click", ".owl-item", function (e) {
                    e.preventDefault();
                    var number = $(this).data("owlItem");
                    sync1.trigger("owl.goTo", number);
                });
                function center(number) {
                    var sync2visible = sync2.data("owlCarousel").owl.visibleItems;
                    var num = number;
                    var found = false;
                    for (var i in sync2visible) {
                        if (num === sync2visible[i]) {
                            var found = true;
                        }
                    }
                    if (found === false) {
                        if (num > sync2visible[sync2visible.length - 1]) {
                            sync2.trigger("owl.goTo", num - sync2visible.length + 2)
                        } else {
                            if (num - 1 === -1) {
                                num = 0;
                            }
                            sync2.trigger("owl.goTo", num);
                        }
                    } else if (num === sync2visible[sync2visible.length - 1]) {
                        sync2.trigger("owl.goTo", sync2visible[1])
                    } else if (num === sync2visible[0]) {
                        sync2.trigger("owl.goTo", num - 1)
                    }
                }
            })(jQuery)}
    </script>

<?php endif; ?>
<div class="wrapper-slider <?php if ($atts['el_class'] != '') echo $atts['el_class']; if (!empty($atts['slider_thumb'])){echo ' thumb-active';}?>">
    <?php
    $the_query = new WP_Query($args);
    if ($the_query->have_posts()) :?>
        <ul class="rit-blog-carousel">
            <?php
            while ($the_query->have_posts()) : $the_query->the_post();
                if (has_post_thumbnail()) :
                    ?>
                    <li id="post-<?php the_ID(); ?>" <?php post_class('blog-carousel-item'); ?>
                    style="background:url('<?php echo wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), "full" )[0];?>') center center/cover; height: <?php echo $atts['slider_height'].'px'?>">
                        <div class="container">
                        <div class="wrapper-info">
                            <div class="list-cat"><?php list_cat_label(get_the_ID());?></div>
                            <?php if (get_theme_mod('rit_enable_page_heading', '1')) { ?>
                                <?php
                                the_title(sprintf('<h2 class="title-post"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h2>');
                                ?>
                            <?php } ?>
                            <?php if ($atts['output_type'] != 'no') { ?>
                                <div class="caption-thumb-post"><?php
                                    if ($atts['output_type'] == 'excerpt') {
                                        echo rit_excerpt($atts['excerpt_lenght']);
                                    } else {
                                        the_content();
                                    } ?>
                                </div>
                            <?php }
                            ?>
                            <div class="post-info">
                                <?php echo get_the_date(); ?>
                                <span>|</span>
                                <?php comments_number('0 Comment', '1 Comment', '% Comments'); ?>
                            </div>
                            <?php if (!empty($atts['view_more'])) { ?>
                                <a href="<?php the_permalink() ?>"
                                   class="rit-readmore"
                                   title="<?php the_title(); ?>"><?php echo __('Read more', 'ri-max'); ?>
                                </a>
                            <?php } ?>
                        </div>
                        </div>
                        <!-- .entry-content -->
                    </li><!-- #post-## -->
                    <?php
                endif;
            endwhile; ?>
        </ul>
        <?php
        if (!empty($atts['slider_thumb'])):?>
            <div class="container wrapper-blog-thumb">
            <ul class="rit-blog-thumb">
                <?php
                while ($the_query->have_posts()) : $the_query->the_post();
                    if (has_post_thumbnail()) :
                        ?>
                        <li id="post-<?php the_ID(); ?>" <?php post_class('blog-carousel-item'); ?>>
                            <a href="<?php echo get_permalink() ?>"
                               title="<?php the_title(); ?>"
                               class="thumb-post"><?php the_post_thumbnail('thumbnail'); ?></a>
                            <div class="wrapper-info">
                                <?php if (get_theme_mod('rit_enable_page_heading', '1')) { ?>
                                    <?php
                                    the_title(sprintf('<h2 class="title-post"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h2>');
                                    ?>
                                <?php } ?>
                                <div class="post-info">
                                    <?php echo get_the_date(); ?>
                                </div>
                            </div>
                            <!-- .entry-content -->
                        </li><!-- #post-## -->
                        <?php
                    endif;
                endwhile; ?>
            </ul>
            </div>
            <?php
        endif;
    endif;
    wp_reset_postdata();
    ?>
</div>
