<?php
/**
 * The template used for displaying attachments.
 *
 * @package Folio
 */

get_header(); ?>

<section id="primary" class="col-sm-12">
	
	<!-- load pages -->
	<div class="js-load-pages"></div>

	<main id="main" class="site-main" role="main">
	
		<?php if ( have_posts() ) : ?>
		
			<?php while ( have_posts() ) : the_post(); ?>
			
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'type-loop' ); ?>>
					
					<header class="entry-header">
				
						<h2 class="entry-title">
							<a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
						</h2>
						
						<div class="entry-meta">
							
							<?php
							$published_text = __( '<span class="attachment-meta">Published on <time class="entry-date" datetime="%1$s">%2$s</time> in <a href="%3$s" title="Return to %4$s" rel="gallery">%5$s</a></span>', 'folio' );
							$post_title = get_the_title( $post->post_parent );
							if ( empty( $post_title ) || 0 == $post->post_parent ) {
								$published_text = '<span class="attachment-meta"><time class="entry-date" datetime="%1$s">%2$s</time></span>'; }

							printf( $published_text,
								esc_attr( get_the_date( 'c' ) ),
								esc_html( get_the_date() ),
								esc_url( get_permalink( $post->post_parent ) ),
								esc_attr( strip_tags( $post_title ) ),
								$post_title . ' '
							);

							$metadata = wp_get_attachment_metadata();
							printf( '<span class="attachment-meta full-size-link"><a href="%1$s" title="%2$s">%3$s (%4$s &times; %5$s)</a></span>',
								esc_url( wp_get_attachment_url() ),
								esc_attr__( 'Link to full-size image', 'folio' ),
								__( 'Full resolution', 'folio' ),
								$metadata['width'],
								$metadata['height']
							);

							edit_post_link( __( 'Edit', 'folio' ), '<span class="edit-link">', '</span>' );
							?>
						
						</div>
					</header><!-- .entry-header -->
				
					<div class="entry-content">
						<?php folio_the_attached_image(); ?>
						
						<?php if ( has_excerpt() ) : ?>
						<div class="entry-caption">
							<?php the_excerpt(); ?>
						</div>
						<?php endif; ?>
					</div><!-- .entry-content -->
				
				</article> <!-- gallery-item -->
				
			<?php endwhile; ?>
			
		<?php else : ?>
		
			<?php get_template_part( 'content', 'none' ); ?>
			
		<?php endif; ?>
		
	</main>
</section>
<?php get_footer(); ?>
