<?php

/*-----------------------------------------------------------------------------------------------------//
/*	Theme License and Updater
/*-----------------------------------------------------------------------------------------------------*/

// Includes the files needed for the theme updater
if ( !class_exists( 'EDD_Theme_Updater_Admin' ) ) {
	include( dirname( __FILE__ ) . '/theme-updater-admin.php' );
}

$p75_theme_name = 'Folio';
$p75_theme_lang = 'folio';
$p75_theme_id = '12077';

// Loads the updater classes
$updater = new P75_Theme_Updater_Admin(

	// Config settings
	$config = array(
		'remote_api_url' => 'http://press75com.staging.wpengine.com/', // TODO change back to http .com
		'item_name' => $p75_theme_name,
		'theme_slug' => $p75_theme_lang,
		'version' => P75THEME_VERSION,
		'author' => 'Press75',
		'download_id' => $p75_theme_id,
	),

	// Strings
	$strings = array(
		'theme-license'             => esc_html__( 'Press75', $p75_theme_lang ),
		'enter-key'                 => esc_html__( 'Enter the license key for the ' . $p75_theme_name . ' theme.', $p75_theme_lang ),
		'license-key'               => esc_html__( 'License Key', $p75_theme_lang ),
		'license-action'            => esc_html__( 'License Action', $p75_theme_lang ),
		'deactivate-license'        => esc_html__( 'Deactivate License', 'paperback' ),
		'activate-license'          => esc_html__( 'Activate License', 'paperback' ),
		'status-unknown'            => esc_html__( 'License status is unknown.', $p75_theme_lang ),
		'renew'                     => esc_html__( 'Renew?', $p75_theme_lang ),
		'unlimited'                 => esc_html__( 'unlimited', $p75_theme_lang ),
		'license-key-is-active'     => esc_html__( 'License key is active.', $p75_theme_lang ),
		'expires%s'                 => esc_html__( 'Expires %s.', $p75_theme_lang ),
		'%1$s/%2$-sites'            => esc_html__( 'You have %1$s / %2$s sites activated.', $p75_theme_lang ),
		'license-key-expired-%s'    => esc_html__( 'License key expired %s.', $p75_theme_lang ),
		'license-key-expired'       => esc_html__( 'License key has expired.', $p75_theme_lang ),
		'license-keys-do-not-match' => esc_html__( 'License keys do not match.', $p75_theme_lang ),
		'license-is-inactive'       => esc_html__( 'License is inactive.', $p75_theme_lang ),
		'license-key-is-disabled'   => esc_html__( 'License key is disabled.', $p75_theme_lang ),
		'site-is-inactive'          => esc_html__( 'Site is inactive.', $p75_theme_lang ),
		'license-status-unknown'    => esc_html__( 'License status is unknown.', $p75_theme_lang ),
		'update-notice'             => esc_html__( "Note: updating this theme will remove any customizations not performed in a child theme. 'Cancel' to stop, 'OK' to update.", $p75_theme_lang ),
		'update-available'          => __('<strong>%1$s %2$s</strong> is available. <a href="%3$s" class="thickbox" title="%4s">Check out what\'s new</a> or <a href="%5$s"%6$s>update now</a>.', $p75_theme_lang )
	)

);
