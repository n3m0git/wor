<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * @package folio
 */

/**
 * Custom Excerpt Length
 *
 */
function folio_new_excerpt_length( $length ) {
	return 35;
}
add_filter( 'excerpt_length', 'folio_new_excerpt_length' );

/**
 * Custom Excerpt More
 *
 */
function folio_new_excerpt_more( $more ) {
	return ' ...';
}

add_filter( 'excerpt_more', 'folio_new_excerpt_more' );

function wpe_excerpt( $length_callback = '', $more_callback = '' ) {
	global $post;

	if ( function_exists( $length_callback ) ) {
		add_filter( 'excerpt_length', $length_callback );
	}
	if ( function_exists( $more_callback ) ) {
		add_filter( 'excerpt_more', $more_callback );
	}
	$output = get_the_excerpt();
	$output = apply_filters( 'wptexturize', $output );
	$output = apply_filters( 'convert_chars', $output );
	$output = '<p class="excerpt">'.$output.'</p>';
	echo $output;
}

/**
 * Pings Callback Setup
 *
 * @since 1.0
 */
if ( ! function_exists( 'folio_pings_callback' ) ) {
	function folio_pings_callback( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		?>
		<li class="ping" id="li-comment-<?php comment_ID(); ?>"><?php comment_author_link(); ?>
		<?php
	}
}

/**
 * SVG Support Media Upload
 *
 */
function folio_mime_types( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter( 'upload_mimes', 'folio_mime_types' );
