<?php
/**
 * The template for displaying image post format.
 *
 * @package Folio
 */
?>

<?php $url = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) ); ?>

<?php if ( has_post_thumbnail() ) : ?>
	<div class="col-md-3 item <?php folio_filters_cats(); ?>">
		<div class="entry-thumb">
			<?php the_post_thumbnail( 'folio_thumbnail', array( 'class' => 'lazy', 'data-original' => $url ) ); ?>
		</div>
		<a href="<?php echo esc_url( $url ); ?>" class="image-link" title="<?php echo get_the_title(); ?>" data-description="<?php p75_the_post_thumbnail_caption(); ?>">
			<div class="item-content-container">
				<div class="item-content">
					<div class="dashicons dashicons-format-image"></div>
					<p><?php the_title(); ?></p>
				</div><!-- end .item-content -->
			</div><!-- end .item-content-container -->
	    </a>
	</div><!-- end .item -->
<?php endif; ?>
