<?php
/**
 * Setup the WordPress core custom header feature.
 *
 * @uses folio_header_style()
 *
 * @package folio
 * @since 1.0
 */

function folio_custom_header_setup() {
	$args = array(
		'default-image'          => '',
		'default-text-color'     => '444444',
		'width'                  => 220,
		'height'                 => 80,
		'flex-height'            => true,
		'wp-head-callback'       => 'folio_header_style',
	);

	$args = apply_filters( 'folio_custom_header_args', $args );

	add_theme_support( 'custom-header', $args );
}

add_action( 'after_setup_theme', 'folio_custom_header_setup' );


/**
 * Styles the header image and text displayed on the blog
 *
 * @see folio_custom_header_setup().
 *
 * @since folio 1.0
 */
if ( ! function_exists( 'folio_header_style' ) ) {

	function folio_header_style() {

		// If no custom options for text are set, let's bail
		// get_header_textcolor() options: HEADER_TEXTCOLOR is default, hide text (returns 'blank') or any hex value
		if ( HEADER_TEXTCOLOR == get_header_textcolor() ) {
			return;
		}
		// If we get this far, we have custom styles. Let's do this.
		?>
		<style type="text/css">
		<?php
			// Has the text been hidden?
		if ( 'blank' == get_header_textcolor() ) :
		?>
		.site-title,
		.site-description {
			position: absolute !important;
			clip: rect(1px 1px 1px 1px); /* IE6, IE7 */
			clip: rect(1px, 1px, 1px, 1px);
		}
		<?php
		// If the user has set a custom color for the text use that
			else :
		?>
			.site-title a,
			.site-description {
				color: #<?php echo get_header_textcolor(); ?> !important;
			}
		<?php endif; ?>
		</style>
		<?php
	}
}

