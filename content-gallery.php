<?php
/**
 * The template for displaying gallery post format.
 *
 * @package Folio
 */
?>

<?php if ( has_post_thumbnail() ) : ?>
	
<?php

	$url = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
	$title = get_the_title();
	$title = strtolower( $title );
	$title = strtr( $title, ' ', '-' );
	$title = preg_replace( '/[^\w-]/', '', $title );
?>

	<div class="col-md-3 <?php echo $title; ?> item <?php folio_filters_cats(); ?>">
		<div class="entry-thumb">
			<?php the_post_thumbnail( 'folio_thumbnail', array( 'class' => 'lazy', 'data-original' => $url ) ); ?>
		</div>
		<a href="<?php echo esc_url( $url ); ?>" class="open-gallery-link" data-name="<?php echo $title; ?>" title="<?php the_title(); ?>" data-description="<?php p75_the_post_thumbnail_caption(); ?>">
			<div class="item-content-container">
				<div class="item-content">
					<div class="dashicons dashicons-format-gallery"></div>
					<p><?php the_title(); ?></p>
				</div><!-- end .item-content -->
			</div><!-- end .item-content-container -->
		</a>

		<ul class="<?php echo $title; ?> mfp-hide">
			<?php
			if ( get_post_gallery() ) {

				$gallery = get_post_gallery( $post->ID, false );
				$gallery_ids = $gallery['ids'];
				$gallery_ids = explode( ',', $gallery_ids );
				$image_path = wp_upload_dir();
				$image_path = $image_path['baseurl'];

				foreach ( $gallery_ids as $id ) {
					$meta = wp_get_attachment_metadata( $id );
					$attachment_title = get_the_title( $id );
					$attachment_caption = get_post_field( 'post_excerpt', $id );
					if ( $meta ) {
						echo '<a href="' . $image_path . '/' . $meta['file'] . '" title="' . $attachment_title . '" data-description="' . $attachment_caption . '"></a>';
					}
				}
			}
			?>
		</ul>
	</div><!-- end .item -->
<?php endif; ?>
