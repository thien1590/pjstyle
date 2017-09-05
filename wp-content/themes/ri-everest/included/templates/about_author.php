<div class="post-author clear-fix">
	<div class="row">
	<div class="author-img col-xs-3">
		<?php echo get_avatar( get_the_author_meta('email'), '200' ); ?>
	</div>
	
	<div class="author-content col-xs-9">
		<h3 class="title"><?php the_author_posts_link(); ?></h3>
		<p><?php the_author_meta('description'); ?></p>
        <div class="author-socail">
		<?php if(get_the_author_meta('facebook')) : ?><a target="_blank" class="author-social-item" href="http://facebook.com/<?php echo esc_attr(the_author_meta('facebook')); ?>"><i class="fa fa-facebook"></i></a><?php endif; ?>
		<?php if(get_the_author_meta('twitter')) : ?><a target="_blank" class="author-social-item" href="http://twitter.com/<?php echo  esc_attr(the_author_meta('twitter')); ?>"><i class="fa fa-twitter"></i></a><?php endif; ?>
		<?php if(get_the_author_meta('instagram')) : ?><a target="_blank" class="author-social-item" href="http://instagram.com/<?php echo  esc_attr(the_author_meta('instagram')); ?>"><i class="fa fa-instagram"></i></a><?php endif; ?>
		<?php if(get_the_author_meta('google')) : ?><a target="_blank" class="author-social-item" href="http://plus.google.com/<?php echo  esc_attr(the_author_meta('google')); ?>?rel=author"><i class="fa fa-google-plus"></i></a><?php endif; ?>
		<?php if(get_the_author_meta('pinterest')) : ?><a target="_blank" class="author-social-item" href="http://pinterest.com/<?php echo  esc_attr(the_author_meta('pinterest')); ?>"><i class="fa fa-pinterest"></i></a><?php endif; ?>
		<?php if(get_the_author_meta('tumblr')) : ?><a target="_blank" class="author-social-item" href="http://<?php echo  esc_attr(the_author_meta('tumblr')); ?>.tumblr.com/"><i class="fa fa-tumblr"></i></a><?php endif; ?>
        </div>
	</div>
    </div>
</div>