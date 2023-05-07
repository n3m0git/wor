<?php
/**
 * Get Option
 *
 * Return given option value or return default
 *
 * @since 1.0
 */
function get_folio_option( $option_name, $default = false ) {

	$folio_options = get_theme_mod( 'folio_options' );

	if ( isset( $folio_options[ $option_name ] ) ) {
		$option = $folio_options[ $option_name ]; }

	if ( ! empty( $option ) ) {
		return $option; }

	return $default;

}

/**
 * Sanitize Text Input
 *
 * @since 1.0
 */
function input_sanitize_text( $input ) {
	return wp_kses_post( force_balance_tags( $input ) );
}

/**
 * Sanitize Dropdown
 *
 * @since 1.0
 */
function dropdown_sanitize_integer( $input ) {
	if ( is_numeric( $input ) ) {
		return intval( $input );
	}
}

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @since 1.0
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * @return void
 */
function folio_customize_register( $wp_customize ) {

	if ( $wp_customize->is_preview() && ! is_admin() ) {
		add_action( 'wp_footer', 'folio_customize_preview', 21 ); }

	// load the control itself
	require_once dirname( __FILE__ ) . '/customizer/advanced-upload-control.php';

	/**
	 * Site Title & Description Section
	 */
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	/**
	 * Create Folio Panel
	 */

	$wp_customize->add_panel( 'folio_customizer', array(
	    'priority'       => 10,
	    'capability'     => 'edit_theme_options',
	    'theme_supports' => '',
	    'title'          => 'Folio Customizer Options',
	    'description'    => 'Theme Options for Folio',
	) );

	/**
	 * Site Colors
	 */
	$wp_customize->add_section( 'color_section',
		array(
			'title'    => __( 'Colors', 'wanderer' ),
			'priority' => 100,
			'panel'  => 'folio_customizer',
		)
	);

	$wp_customize->add_setting(
	    'folio_options[primary_color]',
	    array(
	        'default'     => '#3c3c3f',
	        'sanitize_callback' => 'input_sanitize_text',
	    )
	);
	$wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'link_color',
	        array(
	            'label'      => __( 'Primary Site Color', 'folio' ),
	            'section'    => 'color_section',
	            'settings'   => 'folio_options[primary_color]',
	        )
	    )
	);

	$wp_customize->add_setting(
	    'folio_options[secondary_color]',
	    array(
	        'default'     => '#c5c5c6',
	        'sanitize_callback' => 'input_sanitize_text',
	    )
	);
	$wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'meta_color',
	        array(
	            'label'      => __( 'Secondary Site Color', 'folio' ),
	            'section'    => 'color_section',
	            'settings'   => 'folio_options[secondary_color]',
	        )
	    )
	);

	$wp_customize->add_setting(
	    'folio_options[filter_background_color]',
	    array(
	        'default'     => '#37373a',
	        'sanitize_callback' => 'input_sanitize_text',
	    )
	);
	$wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'filter_color',
	        array(
	            'label'      => __( 'Filter Background Color', 'folio' ),
	            'section'    => 'color_section',
	            'settings'   => 'folio_options[filter_background_color]',
	        )
	    )
	);

	/**
	 * Logo Section
	 */
	$wp_customize->add_section( 'logo_section',
		array(
			'title'    => __( 'Logo', 'folio' ),
			'priority' => 110,
			'panel'  => 'folio_customizer',
		)
	);

	$wp_customize->add_setting( 'folio_options[logo]' );
	$wp_customize->add_control(
	    new P75_Advanced_Upload_Control(
	        $wp_customize,
	        'p75-uploader',
	        array(
	            'label'      => __( 'Custom Logo', 'folio' ),
				'section' => 'logo_section',
	            'settings'   => 'folio_options[logo]',
				'priority' 	 => 0,
				'extensions' => array( 'jpg', 'jpeg', 'gif', 'png', 'svg' ),
	        )
	    )
	);

	$wp_customize->add_setting( 'folio_options[favicon]' );
	$wp_customize->add_control(
	    new P75_Advanced_Upload_Control(
	        $wp_customize,
	        'p75-favicon',
	        array(
	            'label'      => __( 'Custom Favicon', 'folio' ),
				'section' => 'logo_section',
	            'settings'   => 'folio_options[favicon]',
				'priority' 	 => 1,
				'extensions' => array( 'jpg', 'jpeg', 'gif', 'png', 'svg' ),
	        )
	    )
	);

	/**
	 * Ajax Pages
	 */
	$wp_customize->add_section( 'page_section',
		array(
			'title'    => __( 'Pages', 'folio' ),
			'priority' => 200,
			'panel'  => 'folio_customizer',
		)
	);
	$wp_customize->add_setting( 'folio_options[ajaxpages]',
	    array(
	        'sanitize_callback' => 'input_sanitize_text',
	    )
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'ajaxpages',
			array(
				'section' => 'page_section',
				'label'   => __( 'Standard Page Linking.', 'folio' ),
	            'settings'   => 'folio_options[ajaxpages]',
				'priority' 	 => 0,
				'type' => 'checkbox',
			)
		)
	);

	/**
	 * Social Icons Section
	 */
	$wp_customize->add_section( 'social_section',
		array(
			'title'    => __( 'Social Icons', 'folio' ),
			'priority' => 200,
			'description' => __( 'Links for social icons', 'folio' ),
			'panel'  => 'folio_customizer',
		)
	);
	$wp_customize->add_setting( 'folio_options[facebook]' );
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'facebook',
			array(
				'section' => 'social_section',
				'label'   => __( 'Facebook', 'folio' ),
	            'settings'   => 'folio_options[facebook]',
				'priority' 	 => 200,
				'sanitize_callback' => 'folio_sanitize_text',
			)
		)
	);
	$wp_customize->add_setting( 'folio_options[twitter]' );
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'twitter',
			array(
				'section' => 'social_section',
				'label'   => __( 'Twitter', 'folio' ),
	            'settings'   => 'folio_options[twitter]',
				'priority' 	 => 200,
				'sanitize_callback' => 'folio_sanitize_text',
			)
		)
	);
	$wp_customize->add_setting( 'folio_options[behance]' );
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'behance',
			array(
				'section' => 'social_section',
				'label'   => __( 'Behance', 'folio' ),
				'settings'   => 'folio_options[behance]',
				'priority' 	 => 200,
				'sanitize_callback' => 'folio_sanitize_text',
			)
		)
	);
	$wp_customize->add_setting( 'folio_options[instagram]' );
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'instagram',
			array(
				'section' => 'social_section',
				'label'   => __( 'Instagram', 'folio' ),
	            'settings'   => 'folio_options[instagram]',
				'priority' 	 => 200,
				'sanitize_callback' => 'folio_sanitize_text',
			)
		)
	);
	$wp_customize->add_setting( 'folio_options[pinterest]' );
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'pinterest',
			array(
				'section' => 'social_section',
				'label'   => __( 'Pinterest', 'folio' ),
	            'settings'   => 'folio_options[pinterest]',
				'priority' 	 => 200,
				'sanitize_callback' => 'folio_sanitize_text',
			)
		)
	);
	$wp_customize->add_setting( 'folio_options[vimeo]' );
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'vimeo',
			array(
				'section' => 'social_section',
				'label'   => __( 'Vimeo', 'folio' ),
	            'settings'   => 'folio_options[vimeo]',
				'priority' 	 => 200,
				'sanitize_callback' => 'folio_sanitize_text',
			)
		)
	);
	$wp_customize->add_setting( 'folio_options[youtube]' );
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'youtube',
			array(
				'section' => 'social_section',
				'label'   => __( 'Youtube', 'folio' ),
	            'settings'   => 'folio_options[youtube]',
				'priority' 	 => 200,
				'sanitize_callback' => 'folio_sanitize_text',
			)
		)
	);

	$wp_customize->add_setting( 'folio_options[linkedin]' );
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'linkedin',
			array(
				'section' => 'social_section',
				'label'   => __( 'LinkedIn', 'folio' ),
				'settings'   => 'folio_options[linkedin]',
				'priority' 	 => 200,
				'sanitize_callback' => 'folio_sanitize_text',
			)
		)
	);

	/**
	 * Social Icons Section
	 */
	$wp_customize->add_section( 'footer_section',
		array(
			'title'    => __( 'Footer', 'folio' ),
			'priority' => 210,
			'description' => __( 'Footer Copyright Text', 'folio' ),
			'panel'  => 'folio_customizer',
		)
	);
	$wp_customize->add_setting( 'folio_options[footer_text]' );
	$wp_customize->add_control( 'folio_options[footer_text]',
		array(
			'type'    => 'textarea',
			'section' => 'footer_section',
			'label'   => __( 'Footer Text', 'folio' ),
		)
	);

	/**
	 * Static Front Page
	 */
	$wp_customize->add_setting( 'folio_options[home_category]',
	    array(
	        'sanitize_callback' => 'dropdown_sanitize_integer',
	    )
	);
	$wp_customize->add_control( 'folio_options[home_category]',
		array(
			'type'    => 'select',
			'section' => 'static_front_page',
			'label'   => __( 'Latest Posts - Category', 'folio' ),
			'choices' => folio_get_category_list( array( 'show_count' => 1 ) ),
		)
	);

	/**
	* Remove Sections
	*/

	$wp_customize->remove_section( 'static_front_page' );
}
add_action( 'customize_register', 'folio_customize_register' );

/**
 * Customize Preview
 *
 * Allows transported customizer options to be displayed without delay.
 *
 * @since 1.0
 */
function folio_customize_preview() {
	?>

<script type="text/javascript">
( function( $ ) {
	/* Site title and description. */
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );

	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );
} )( jQuery );
</script>

<?php }
