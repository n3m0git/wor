<?php
/**
 * The footer for the theme.
 *
 * @package Folio
 */
?>
	<div class="clearfix"></div>

	<footer class="footer col-sm-12">

		<div class="container-fluid">
			<div class="footer-left col-xs-12 col-sm-9">

				<?php if ( get_folio_option( 'footer_text' ) ) : ?>

					<p><?php echo get_folio_option( 'footer_text' ); ?></p>

				<?php else : ?>

				<p>
					<?php printf( __( 'Copyright %s by', 'folio' ), date( 'Y' ) ); ?>
					<a href="<?php echo esc_url( 'http://press75.com', 'folio' ); ?>" title="<?php esc_attr_e( 'A Semantic Personal Publishing Platform', 'folio' ); ?>" rel="generator" target="_blank">
						<?php _e( 'Press 75', 'folio' ); ?>
					</a>
					<?php printf( __( '&middot; Folio - A %s Theme by %s', 'folio' ), 'WordPress', 'Press75' ); ?>
				</p>

				<?php endif; // get_folio_option('footer_text') ) : ?>

			</div>

			<div class="footer-right col-xs-12 col-sm-3">
				<?php $social_icons = array( 'facebook', 'twitter', 'instagram', 'pinterest', 'vimeo', 'youtube', 'linkedin', 'behance' );

				foreach ( $social_icons as $icon ) {
					if ( $url = get_folio_option( $icon ) ) :
						echo '<a href="' . $url . '"><svg class="icon icon-' . $icon . '"><use xlink:href="#icon-' . $icon . '"></use></svg></a>';
					endif;
				} ?>

			</div>
		</div><!-- .container -->
	</footer><!-- .footer -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
