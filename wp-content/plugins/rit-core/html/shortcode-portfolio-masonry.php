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
    'post_type' => 'portfolio',
    'posts_per_page' => ($atts['number'] > 0) ? $atts['number'] : get_option('posts_per_page')
);

if ($atts['cat']) {
    $catid=array();
    foreach(explode(',', $atts['cat'])as $catslug){
        $catid[].=get_term_by('slug',$catslug,'portfolio_category')->term_id;
    }
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'portfolio_category',
            'field' => 'id',
            'terms' => $catid,
        )
    );
}

if ($atts['post_in'])
    $args['post__in'] = explode(',', $atts['post_in']);
$args['paged'] = (rit_get_query_var('paged')) ? rit_get_query_var('paged') : 1;
$the_query = new WP_Query($args);?>
<script>
    jQuery(window).load(function () {
        ConfigMasonry();
        jQuery('#rit-porfolio-filter li').on('click', function () {
            jQuery('#rit-porfolio-filter li.active').removeClass('active');
            jQuery(this).addClass('active');
            var target = jQuery(this).attr('data-id');
            jQuery('div.rit-item-masonry:not(.' + target + ')').addClass('rit_hide_item');
            setTimeout(function () {
                jQuery('.rit_hide_item').hide()
            }, 100);
            setTimeout(function () {
                jQuery('.rit_hide_item').show();
            }, 300);
            jQuery('div.' + target).removeClass('rit_hide_item');
            setTimeout(function () {
                ConfigMasonry();
            }, 100);
        });
    });
    function ConfigMasonry() {
        var container = document.querySelector('#rit-porfolio-content');
        var width = jQuery('.rit-item-masonry').width();
        var msnry = new Masonry(container, {
            // options
            columnWidth: container.width,
            itemSelector: '.rit-item-masonry'
        });
    }
</script>

<?php
//Begin control nav masonry
if ($atts['cat'] == '')
    $terms = get_terms('portfolio_category', '');
else {
    $terms = array();
    $term_ids = $catid;
    if (count($term_ids) > 0) {
        foreach ($term_ids as $id) {
            $terms[] = get_term($id, 'portfolio_category');
        }
    }
}

if (!empty($terms) && !is_wp_error($terms)):?>
    <ul id="rit-masonry-filter">
        <?php if(count($terms) > 1) :?>
            <li class="active" data-id="all"><span><?php echo esc_html__('All', RIT_TEXT_DOMAIN) ?></li>

            <?php foreach ($terms as $term) : ?>
                <li data-id="<?php echo esc_attr($term->slug) ?>"><span><?php echo esc_html($term->name); ?></span></li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
<?php endif; //End control nav masonry ?>
<div id="wrapper-rit-item-masonry">
    <?php if ($the_query->have_posts()) :
        while ($the_query->have_posts()) : $the_query->the_post();
            //get list catslug
            $catslug = '';
            $termspost = get_the_terms( get_the_ID(), 'portfolio_category');
            if ($termspost && !is_wp_error($termspost)) :
                foreach ($termspost as $term) :
                    $catslug .= $term->slug . ' ';
                endforeach;
            endif;
            ?>
            <div class="rit-item-masonry all <?php echo esc_attr($catslug) ?>">
                <?php echo rit_get_template_part('post-format/portfolio', 'default', array('atts' => $atts)) ?>
                <div class="rit-masonry-mask">
                    <div class="rit-wrapper-mask">
                        <h3 class="rit-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <h4 class="rit-cat"><?php echo get_the_term_list(get_the_ID(), 'portfolio_category', ' ', ' / ', ' '); ?></h4>
                    </div>
                </div>
            </div>
        <?php
        endwhile;
    endif;
    wp_reset_postdata();?>
</div><!--End wrapper-rit-item-masonry-->