<?php
/**
 * The template for displaying comments.
 *
 * @package Folio
 */

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
		<h2 class="comments-title">
			<?php
				printf( __( 'One response on &ldquo;%2$s&rdquo;', '%1$s responses on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'folio' ),
				number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
			?>
		</h2>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-above" class="comment-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'folio' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'folio' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'folio' ) ); ?></div>
		</nav><!-- #comment-nav-above -->
		<?php endif; // check for comment navigation ?>

		<ol class="comment-list">
			<?php
				wp_list_comments( array(
					'style'      => 'ol',
					'short_ping' => true,
					'avatar_size' => 100,
				) );
			?>
		</ol><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below" class="comment-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'folio' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'folio' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'folio' ) ); ?></div>
		</nav><!-- #comment-nav-below -->
		<?php endif; // check for comment navigation ?>

	<?php endif; // have_comments() ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
	<p class="no-comments"><?php _e( 'Comments are closed.', 'folio' ); ?></p>
	<?php endif; ?>

	<?php
		ob_start();
		comment_form(
			array(
				'comment_notes_after' => '',
				'comment_field' => '<p class="comment-form-comment"><label for="comment">' . esc_attr( 'Comment', 'noun' ) . '</label>' .
				( $req ? ' <span class="required">*</span>' : '' ) .
				'<br /><textarea id="comment" name="comment" class="form-control" rows="5"></textarea></p>',
				'fields' => apply_filters( 'comment_form_default_fields', array(
					'author' =>
					'<p class="comment-form-author">' .
					'<label for="author">' . __( 'Name', 'domainreference' ) . '</label> ' .
					( $req ? '<span class="required">*</span>' : '' ) .
					'<input id="author" class="form-control" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
					'" size="30" /></p>',

					'email' =>
					'<p class="comment-form-email"><label for="email">' . __( 'Email', 'domainreference' ) . '</label> ' .
					( $req ? '<span class="required">*</span>' : '' ) .
					'<input id="email" class="form-control" name="email" type="text" value="' . esc_attr( $commenter['comment_author_email'] ) .
					'" size="30" /></p>',
					)
				),
			)
		);
		$string = ob_get_contents();
	    $string = str_replace( '<h3 id="reply-title"', '<h5 ', $string );
	    $string = str_replace( '</h3>', '</h5>', $string );
	    $string = str_replace( '<input name="submit"', '<input class="btn btn-primary" name="submit" ', $string );
	    ob_end_clean();

	    // submit
	    echo $string;
	?>

</div><!-- #comments -->
