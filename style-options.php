<?php $primary_color = get_folio_option( 'primary_color' ); ?>
	<?php $secondary_color = get_folio_option( 'secondary_color' ); ?>
	<?php $filter_color = get_folio_option( 'filter_background_color' ); ?>

	<style type="text/css">

		<?php if ( $primary_color ) : ?>
			.site-header,
			.isotope,
			.footer,
			body {
				background: <?php echo $primary_color; ?>;
			}
		<?php endif; ?>

		<?php if ( $secondary_color ) : ?>
			.filter-group button,
			.main-navigation ul li a,
			.pagination,
			.pagination a,
			.site-title a {
				color: <?php echo $secondary_color; ?>;
			}
		<?php endif; ?>

		<?php if ( $filter_color ) : ?>
			.filter-group {
				background: <?php echo $filter_color; ?>;
			}
		<?php endif; ?>
		
	</style>
