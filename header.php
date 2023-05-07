<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Folio
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php if ( get_folio_option( 'favicon' ) ) : ?>
		<?php $favicon = get_folio_option( 'favicon' ); ?>
		<link rel="icon" href="<?php echo $favicon['url']; ?>" type="image/x-icon">
	<?php else : ?>
		<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon.png" type="image/x-icon">
	<?php endif; ?>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>

	<?php include( 'inc/icons.svg' ); ?>

	<?php get_template_part( 'style', 'options' ); ?>

	<!--[if lt IE 9]>
		<script src="<?php echo get_template_directory_uri() . '/assets/js/html5shiv.min.js';?>"></script>
		<script src="<?php echo get_template_directory_uri() . '/assets/js/respond.min.js';?>"></script>
	<![endif]-->

</head>

<body <?php body_class(); ?>>

<div id="page" class="site">
	<header id="masthead" class="site-header" role="banner">

		<span class="dashicons dashicons-menu js-menu-icon"></span>

		<div class="container-fluid">
			<div class="col-xs-12 col-sm-6 site-branding no-padding">
				<?php $logo = get_folio_option( 'logo' ); ?>
				<?php if ( $logo['url'] ) : ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo" rel="home"><img src="<?php echo $logo['url']; ?>" class="logo"></a>
					<?php echo ( get_bloginfo( 'description' ) ? '<h4 class="site-description-nologo">'.get_bloginfo( 'description' ).'</h4>' : null ); ?>
				<?php else : ?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php echo ( get_bloginfo( 'description' ) ? '<h4 class="site-description-nologo">'.get_bloginfo( 'description' ).'</h4>' : null ); ?>
				<?php endif; ?>
			</div>

			<nav id="site-navigation" class="col-xs-12 col-sm-6 main-navigation no-padding" role="navigation">
					<?php if ( has_nav_menu( 'main_menu' ) ) {
						wp_nav_menu(
							array(
								'theme_location' => 'main_menu',
								'walker'         => new Folio_Walker_Nav_Menu(),
							)
						);
}
				?>
			</nav><!-- #site-navigation -->
		</div>
	</header><!-- #masthead -->

	<!-- Filters -->

	<?php if ( is_home() ) : ?>
		<div id="filters" class="filter-group">
			<button data-filter="*" class="active"><?php _e( 'All', 'folio' ); ?></button>
			<?php
				$filters = get_categories( array( 'exclude' => 1 ) );
			foreach ( $filters as $filter ) {
				echo '<button data-filter=".' . $filter->slug . '">' . $filter->cat_name . '</button>';
			}
			?>
		</div>
	<?php endif; ?>
