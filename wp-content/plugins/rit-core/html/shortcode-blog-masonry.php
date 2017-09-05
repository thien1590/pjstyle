<?php
/**
 * RIT Core Plugin
 * @package     RIT Core
 * @version     2.0.2
 * @author      Zootemplate
 * @link        http://www.zootemplate.com
 * @copyright   Copyright (c) 2015 Zootemplate
 * @license     GPL v2
 */

$args = array(
    'post_type' => 'post',
    'posts_per_page' => ($atts['number'] > 0) ? $atts['number'] : get_option('posts_per_page')
);
if ($atts['cat'] != '') {
    if ($atts['parent'])
    {
        $args['category_name'] = $atts['cat'];
    }
    else
    {
        $catid=array();
        foreach(explode(',', $atts['cat'])as $catslug){
            $catid[].=get_category_by_slug($catslug)->term_id;
        }
        $args['category__in'] = $catid;
    }
}
if ($atts['post_in'] != '')
    $args['post__in'] = explode(',', $atts['post_in']);
$args['paged'] = (rit_get_query_var('paged')) ? rit_get_query_var('paged') : 1;
$the_query = new WP_Query($args); ?>
    <script>
        jQuery(window).load(function(){
            setTimeout(function () {
                ConfigMasonry();
            }, 50);
            setTimeout(function () {
                ConfigMasonry();
            }, 100);
        })
        jQuery(document).ready(function () {

            jQuery('#rit-masonry-filter li').click(function () {
                M(jQuery(this),0);
            });
            var id;
            jQuery( window ).resize(function(){
                clearTimeout(id);
                id=setTimeout(ConfigMasonry,800);
            });
        });
        function ConfigMasonry() {
            var container = document.querySelector('#wrapper-rit-item-masonry');
            var msnry = new Masonry(container, {
                // options
                columnWidth: jQuery('.rit-news-item').outerWidth(),
                itemSelector: '.rit-item-masonry'
            });
        }
        function M(Obj,i){
            i++;
            jQuery('#rit-masonry-filter li.active').removeClass('active');
            Obj.addClass('active');
            var target = Obj.attr('data-id');
            jQuery('#mobile-masonry-filter span').html(target);
            jQuery('article.rit-item-masonry:not(.' + target + ')').addClass('rit_hide_item');
            setTimeout(function () {
                jQuery('.rit_hide_item').hide()
            }, 100);
            setTimeout(function () {
                jQuery('.rit_hide_item').show();
            }, 300);
            jQuery('article.' + target).removeClass('rit_hide_item');
            setTimeout(function () {
                ConfigMasonry();
            }, 100);
            if(i<=2){
                setTimeout(function () {
                    M(Obj,i);
                }, 120);
            }
        }
    </script>
<?php
//Begin control nav masonry
if ($atts['cat'] == '')
    $terms = get_terms('category', '');
else {
    $terms = array();
    $term_ids = explode(',', $atts['cat']);
    if (count($term_ids) > 0) {
        foreach ($term_ids as $id) {
            $terms[] = get_term($id, 'category');
        }
    }
}

if (!empty($terms) && !is_wp_error($terms)):?>
    <ul id="rit-masonry-filter">
        <?php if (count($terms) > 1) : ?>
            <li class="active" data-id="all"><span><?php echo esc_html__('All', RIT_TEXT_DOMAIN) ?></li>

            <?php foreach ($terms as $term) : ?>
                <li data-id="<?php echo esc_attr($term->slug) ?>"><span><?php echo esc_html($term->name); ?></span></li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
<?php endif; //End control nav masonry ?>

<?php if ($the_query->have_posts()) : ?>
    <div id="wrapper-rit-item-masonry"><?php
        while ($the_query->have_posts()) : $the_query->the_post();
            //get list catslug
            $catslug = '';
            $termspost = get_the_terms(get_the_ID(), 'category');
            if ($termspost && !is_wp_error($termspost)) :
                foreach ($termspost as $term) :
                    $catslug .= $term->slug . ' ';
                endforeach;
            endif;
            ?>
            <article class="rit-item-masonry all <?php echo esc_attr($catslug) ?>">
                <?php echo rit_get_template_part('post-format/post', 'default', array('atts' => $atts)) ?>
                <div class="rit-masonry-mask">
                    <div class="rit-wrapper-mask">
                        <h3 class="rit-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <h4 class="rit-cat"><?php echo get_the_term_list(get_the_ID(), 'category', ' ', ' / ', ' '); ?></h4>
                    </div>
                </div>
                <?php if ($atts['output_type'] != 'no') {
                    echo '<div class="description">';
                    if ($atts['output_type'] == 'excerpt') {
                        echo rit_excerpt($atts['excerpt_lenght']);
                    } else {
                        the_content();
                    }
                    echo '</div>';
                } ?>
            </article>
            <?php
        endwhile;
        ?>
    </div><!--End wrapper-rit-item-masonry-->
    <?php
    if (function_exists("rit_pagination")) :
        rit_pagination(3, $the_query);
    endif;
endif;

wp_reset_postdata(); ?>