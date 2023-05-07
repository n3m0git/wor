<?php
/**
 * The template for displaying video post format.
 *
 * @package Folio
 */
?>

<?php
	$video = get_post_meta( get_the_ID(), 'folio_video_embed', true );
	$content = get_the_content();
	$url = isset( $url ) ? $url : '';
?>

<?php if ( has_post_thumbnail() ) : ?>
	<div class="col-md-3 item <?php folio_filters_cats(); ?>">
		<div class="entry-thumb">
			<?php the_post_thumbnail( 'folio_thumbnail', array( 'class' => 'lazy', 'data-original' => $url ) ); ?>
		</div>
		<a href="<?php echo $video; ?>" class="mfp-video" title="<?php echo get_the_title(); ?>" data-description="<?php echo wp_strip_all_tags( $content ); ?>">
			<div class="item-content-container">
				<div class="item-content">
					<div class="dashicons dashicons-format-video"></div>
					<p><?php the_title(); ?></p>
				</div><!-- end .item-content -->
			</div><!-- end .item-content-container -->
		</a>
	</div><!-- .item -->
<?php endif; ?>
