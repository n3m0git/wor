<?php
/**
 * Functions and definitions
 *
 * @package Folio
 */

define( 'THEME_VERSION', '3.4.7' );

function folio_version_id() {
	if ( WP_DEBUG ) {
		return time();
	}

	return THEME_VERSION;
}

/**
 * Custom content width for jetpack galleries.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 1170;
}

/**
 * Theme Setup
 *
 */
function folio_setup() {

	// Translation setup
	load_theme_textdomain( 'folio', get_template_directory() . '/languages' );

	// Add visual editor to resemble the theme styles.
	add_editor_style( array( 'style-editor.css' ) );

	// Add automatic feed links in header
	add_theme_support( 'automatic-feed-links' );

	// Add title tag support
	add_theme_support( 'title-tag' );

	// Add support for post formats
	add_theme_support( 'post-formats', array( 'video', 'image', 'gallery' ) );

	// Add Post Thumbnail Image sizes and support
	add_theme_support( 'post-thumbnails' );

	add_image_size( 'folio_thumbnail', 480, 9999 );

	// Register custom menus
	register_nav_menus( array(
		'main_menu' => __( 'Main Menu', 'folio' ),
	) );

}

add_action( 'after_setup_theme', 'folio_setup' );


/**
 * Load additional files and functions.
 */
require( get_template_directory() . '/inc/template-tags.php' );
require( get_template_directory() . '/inc/extras.php' );
require( get_template_directory() . '/inc/customizer.php' );
require( get_template_directory() . '/inc/meta.php' );
require( get_template_directory() . '/inc/shortcodes.php' );

/**
 * Returns the Google font stylesheet URL, if available.
 */
function folio_fonts_url() {
	$fonts_url = '';

	/* translators: If there are characters in your language that are not supported
       by dosis, translate this to 'off'. Do not translate into your own language. */
	$lato = _x( 'on', 'Lato font: on or off', 'folio' );

	if ( 'off' !== $lato ) {
		$query_args = array(
			'family' => 'Lato:300,400,700',
		);

		$fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
	}

	return $fonts_url;
}

/**
 * Required Theme Styles
 *
 */
function folio_theme_styles() {
	wp_enqueue_style( 'dashicons' );
	wp_enqueue_style( 'folio-fonts', folio_fonts_url(), array(), null );
	wp_enqueue_style( 'folio', get_stylesheet_uri(), array(), folio_version_id() );
}

add_action( 'wp_enqueue_scripts', 'folio_theme_styles' );

/**
 * Required Theme Scripts
 *
 */
function folio_theme_scripts() {
	wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/assets/js/modernizr.min.js', array(), folio_version_id(), false );
	wp_enqueue_script( 'plugins', get_template_directory_uri() . '/assets/js/plugins-min.js', array(), folio_version_id(), true );
	wp_enqueue_script( 'folio', get_template_directory_uri() . '/assets/js/theme.js', array( 'jquery' ), folio_version_id(), true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	$scroller = ( ! get_folio_option( 'filter' ) ? 'true' : null );
	wp_localize_script( 'folio', 'scrollSetting', $scroller );

	$ajax_pages = ( get_folio_option( 'ajaxpages' ) ? 'true' : null );
	wp_localize_script( 'folio', 'ajaxPageSetting', $ajax_pages );

	// Setup our data
	$loadPagesDataArray = array(
		'ajax_url' => admin_url( 'admin-ajax.php' ),
	);

	// Pass data to load-pages.js on page load
	wp_localize_script( 'folio', 'loadPagesData', $loadPagesDataArray );
}

add_action( 'wp_enqueue_scripts', 'folio_theme_scripts' );

/**
 * Load pages
 *
 */
function load_pages_callback() {

	$args = array( 'post_type' => 'page' );
	if ( isset( $_POST['id'] ) ) {
		$args['p'] = $_POST['id'];
	}
	$wp_query = new WP_Query( $args );
	while ( $wp_query->have_posts() ) : $wp_query->the_post();
		?>
        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <div class="load-page-content">
                <a href="#" class="close">
                    <svg class="icon icon-close">
                        <use xlink:href="#icon-close"></use>
                    </svg>
                </a>

                <h2 class="load-page-title"><?php the_title(); ?></h2>
                <?php the_content(); ?>
            </div>
        </div>
    <?php
	endwhile;
	exit;
}

add_action( 'wp_ajax_load_pages', 'load_pages_callback' ); // Enable for logged-in users
add_action( 'wp_ajax_nopriv_load_pages', 'load_pages_callback' ); // Enable for anonymous users

/**
 * Modify main query to show Category set in Theme Options if set.
 *
 * @param WP_Query $query
 *
 * @return WP_Query
 */
function folio_main_query_pre_get_posts( $query ) {
	// Bail if Home page template, not the home page, not a query, not main query
	if ( ! is_home() || ! is_a( $query, 'WP_Query' ) || ! $query->is_main_query() ) {
		return;
	}

	$query->set( 'cat', get_folio_option( 'home_category', null ) );
	$query->set( 'posts_per_page', get_option( 'posts_per_page', -1 ) );
	$query->set( 'paged', folio_get_paged_query_var() );
}

add_action( 'pre_get_posts', 'folio_main_query_pre_get_posts' );
