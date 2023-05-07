<?php
/**
 * The template for displaying content.
 *
 * @package Folio
 */
?>

<?php if ( has_post_thumbnail() ) : ?>
	<div class="col-md-3 item <?php folio_filters_cats(); ?>">
		<div class="entry-thumb">
			<?php the_post_thumbnail(); ?>
		</div>
		<a href="<?php the_permalink(); ?>" title="<?php echo get_the_title(); ?>">
			<div class="item-content-container">
				<div class="item-content">
					<div class="dashicons dashicons-welcome-write-blog"></div>
					<p><?php the_title(); ?></p>
				</div><!-- end .item-content -->
			</div><!-- end .item-content-container -->
		</a>
	</div><!-- .item -->
<?php endif; ?>
