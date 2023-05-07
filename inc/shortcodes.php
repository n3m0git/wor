<?php

/*
*
* Folio Shortcodes
*
*/

function folio_button( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'url' => '',
		'color' => '',
		'border' => '',
	), $atts) );

	$return_string = '<a href="' . $url . '" class="button" style="background: ' . $color . '">' . $content . '</a>';
	return $return_string;
}
add_shortcode( 'button', 'folio_button' );
