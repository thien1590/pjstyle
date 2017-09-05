<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package WordPress
 * @subpackage everest
 * @since everest 1.0
 */
$commenter = wp_get_current_commenter();
$req = get_option( 'require_name_email' );
$aria_req = ( $req ? " aria-required='true'" : '' );
/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
    return;
}
?>
<div id="comments" class="comments-area">
    <?php if ( have_comments() ) : ?>
        <h4><?php comments_number( esc_html__('0 Comment','ri-everest'), esc_html__('1 Comment','ri-everest'),esc_html__('% Comments','ri-everest') ); ?></h4>
        <ul class="list-comments">
            <?php
            wp_list_comments( array(
                'style'       => 'ul',
                'short_ping'  => true,
                'avatar_size' => 100,
                'callback'=>'ri_everest_comment',
            ) );
            ?>
        </ul><!-- .comment-list -->
        <?php
        echo '<div class="pager" id="comment-pagination">';
            paginate_comments_links( array('prev_text' => '<i class="fa fa-chevron-left"></i>', 'next_text' => '<i class="fa fa-chevron-right"></i>') );
        echo '</div>';
    endif; // have_comments() ?>
    <?php
    // If comments are closed and there are comments, let's leave a little note, shall we?
    if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
        ?>
        <p class="no-comments"><?php echo esc_html__( 'Comments are closed.', 'ri-everest' ); ?></p>
    <?php endif; ?>
    <?php $comment_args = array( 'title_reply'=>esc_html__('Leave a reply','ri-everest'),
        'comment_notes_before' =>'',
        'logged_in_as'=>'<p>'
            . sprintf( __( 'Logged in as <a href="%1$s" class="primary-font">%2$s</a>. <a href="%3$s"  class="primary-font" title="Log out of this account">Log out?</a>','ri-everest' ),
                admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ).'</p>',
        'fields' => apply_filters( 'comment_form_default_fields', array(
            'author' => '<input id="author"  class="ipt text" placeholder="'.esc_html__('Your Name*','ri-everest').'" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' />',
            'email'  => '<input id="email"  class="ipt text" name="email" placeholder="'.esc_html__('Email*','ri-everest').'" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="60"' . $aria_req . ' />',
            'url'    => '<input id="url"  class="ipt text" name="url" placeholder="'.esc_html__('Website*','ri-everest').'" type="text" value="' . esc_attr(  $commenter['comment_author_url'] ) . '" size="80"' . $aria_req . ' />' ) ),
        'comment_field' => '<textarea id="comment" class="textarea text" name="comment" cols="45" rows="8" aria-required="true" placeholder="'.esc_html__('Messenger*','ri-everest').'"></textarea>',
        'class_submit'=>'btn-black',
        'comment_notes_after' => '',
    );
    comment_form($comment_args); ?>
</div><!-- .comments-area -->
