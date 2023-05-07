<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package Folio
 */

get_header(); ?>

	<div id="primary" class="col-sm-12 content-area">

		<!-- load pages -->
		<div class="js-load-pages"></div>

		<main id="main" class="site-main" role="main">

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php folio_archives_title(); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">

					<p><?php _e( 'It looks like the page you&rsquo;re looking for doesn&rsquo;t exist.', 'folio' ); ?></p>

				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- #main -->

	</div><!-- #primary -->
	
<?php get_footer(); ?>
