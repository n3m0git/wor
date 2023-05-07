<?php
/**
 * The template for displaying single content.
 *
 * @package Folio
 */

$video = get_post_meta( get_the_ID(), 'folio_video_embed', true );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">

		<?php
		if ( $video ) {
			echo wp_oembed_get( $video );
		}
		?>

		<?php if ( has_post_thumbnail() && empty( $video ) ) : ?>
			<div class="featured-image">
				<?php the_post_thumbnail(); ?>
				<p class="text-center"><?php p75_the_post_thumbnail_title(); ?></p>
			</div>
		<?php endif; ?>


		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'folio' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php
			// translators: used between list items, there is a space after the comma
			$category_list = get_the_category_list( __( ', ', 'folio' ) );

			// translators: used between list items, there is a space after the comma
			$tag_list = get_the_tag_list( '', __( ', ', 'folio' ) );

			// But this blog has loads of categories so we should probably display them here
		if ( '' != $tag_list ) {
			$meta_text = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" rel="bookmark">permalink</a>.', 'folio' );
		} else {
			$meta_text = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" rel="bookmark">permalink</a>.', 'folio' );
		}

			printf(
				$meta_text,
				$category_list,
				$tag_list,
				get_permalink()
			);
		?>

		<?php edit_post_link( __( 'Edit', 'folio' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
