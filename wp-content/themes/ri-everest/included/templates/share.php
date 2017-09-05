<div class="share-links clearfix">
    <ul class="social-icons">
        <li class="facebook"><a href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>" target="_blank" class="post_share_facebook" onclick="javascript:window.open(this.href,
                          '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=220,width=600');return false;"  title="<?php echo esc_html__('Share to facebook','ri-everest')?>"><i class="fa fa-facebook"></i> </a></li>
        <li class="twitter"><a href="https://twitter.com/share?url=<?php the_permalink(); ?>" target="_blank" onclick="javascript:window.open(this.href,
                          '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=260,width=600');return false;" title="<?php  echo esc_html__('Share to twitter','ri-everest')?>" class="product_share_twitter"><i class="fa fa-twitter"></i></a></li>
        <li class="googleplus"><a href="https://plus.google.com/share?url=<?php the_permalink(); ?>" target="_blank" onclick="javascript:window.open(this.href,
                          '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" title="<?php  echo esc_html__('Share to google plus','ri-everest')?>"><i class="fa fa-google-plus"></i></a></li>
        <li class="pinterest"><a href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php if(function_exists('the_post_thumbnail')) echo wp_get_attachment_url(get_post_thumbnail_id()); ?>&description=<?php echo get_the_title(); ?>" target="_blank"  title="<?php  echo esc_html__('Share to pinterest','ri-everest')?>"><i class="fa fa-pinterest"></i></a></li>
        <li class="mail"><a href="mailto:?subject=<?php the_title(); ?>&body=<?php echo strip_tags(get_the_excerpt()); ?> <?php the_permalink(); ?>" target="_blank" class="product_share_email" title="<?php  echo esc_html__('Sent to mail','ri-everest')?>"><i class="fa fa-mail-forward"></i></a></li>
    </ul>
</div>