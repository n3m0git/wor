<?php
/**
 * Setup the WordPress core custom header feature.
 *
 * @package Folio
 */

function folio_custom_background_setup() {

	$args = array(
		'default-color' => 'f7f7f7',
	);

	add_theme_support( 'custom-background', apply_filters( 'folio_custom_background_args', $args ) );

}

add_action( 'after_setup_theme', 'folio_custom_background_setup' );
