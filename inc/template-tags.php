<?php
/**
 * Custom template tags for this theme.
 *
 * @package folio
 */

/**
 * Get Category List
 *
 * @return Array Category ID, Name, and Count
 */
if ( ! function_exists( 'folio_get_category_list' ) ) {

	function folio_get_category_list( $args = array() ) {

		$list = array();
		$categories = get_categories( $args );
		$list[''] = __( 'All categories', 'folio' );

		foreach ( (array) $categories as $category ) {
			$list[ $category->cat_ID ] = $category->cat_name;
			if ( ! isset( $args['show_count'] ) ) {
				$list[ $category->cat_ID ] .= ' (' . number_format_i18n( $category->category_count ) . ')';
			}
		}

		return $list;

	}
} // endif

/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
if ( ! function_exists( 'folio_comment' ) ) {

	function folio_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;

		if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>

		<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
			<div class="comment-body">
				<?php _e( 'Pingback:', 'folio' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'folio' ), '<span class="edit-link">', '</span>' ); ?>
			</div>

		<?php else : ?>

		<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
			<?php if ( 0 != $args['avatar_size'] ) { echo get_avatar( $comment, 64 ); } ?>
			
			<section id="div-comment-<?php comment_ID(); ?>" class="comment-body">
				<footer class="comment-meta">
					<div class="comment-author vcard">
						<?php printf( __( '%s', 'folio' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
					</div><!-- .comment-author -->

					<div class="comment-metadata">
						<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
							<time datetime="<?php comment_time( 'c' ); ?>">
								<?php printf( _x( '%1$s at %2$s', '1: date, 2: time', 'folio' ), get_comment_date(), get_comment_time() ); ?>
							</time>
						</a>
						<?php edit_comment_link( __( 'Edit', 'folio' ), '<span class="edit-link">', '</span>' ); ?>
						
						<?php
							comment_reply_link( array_merge( $args, array(
								'add_below' => 'div-comment',
								'depth'     => $depth,
								'max_depth' => $args['max_depth'],
								'before'    => '<div class="reply">',
								'after'     => '</div>',
							) ) );
						?>
					</div><!-- .comment-metadata -->

					<?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'folio' ); ?></p>
					<?php endif; ?>
				</footer><!-- .comment-meta -->

				<div class="comment-content">
					<?php comment_text(); ?>
				</div><!-- .comment-content -->

			</article><!-- .comment-body -->

		<?php
		endif;
	}
} // ends check for folio_comment()

/**
 * Extends WP NAV MENU walker menu
 */
class Folio_Walker_Nav_Menu extends Walker_Nav_Menu {


	function start_lvl( &$output, $depth = 0, $args = array() ) {

		$indent = str_repeat( "\t", $depth );
		$output	   .= "\n$indent<ul class=\"dropdown-menu\">\n";

	}

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$li_attributes = '';
		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = ($args->has_children) ? 'dropdown' : '';
		$classes[] = ($item->current || $item->current_item_ancestor) ? 'active' : '';
		$classes[] = 'menu-item-' . $item->ID;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = ' class="' . esc_attr( $class_names ) . '"';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $value . $class_names . $li_attributes . '>';

		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url ) .'"' : '';
		$attributes .= ($args->has_children) 	    ? ' class="dropdown-toggle" data-toggle="dropdown"' : '';

		$item_output = $args->before;
		$item_output .= '<a id="'.$item->object_id.'" '. $attributes .'>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= ($args->has_children) ? ' </a>' : '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {

		if ( ! $element ) {
			return; }

		$id_field = $this->db_fields['id'];

		//display this element
		if ( is_array( $args[0] ) ) {
			$args[0]['has_children'] = ! empty( $children_elements[ $element->$id_field ] ); } else if ( is_object( $args[0] ) ) {
			$args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] ); }
			$cb_args = array_merge( array( &$output, $element, $depth ), $args );
			call_user_func_array( array( &$this, 'start_el' ), $cb_args );

			$id = $element->$id_field;

			// descend only when the depth is right and there are childrens for this element
			if ( ($max_depth == 0 || $max_depth > $depth + 1 ) && isset( $children_elements[ $id ] ) ) {

				foreach ( $children_elements[ $id ] as $child ) {

					if ( ! isset( $newlevel ) ) {
						$newlevel = true;
						//start the child delimiter
						$cb_args = array_merge( array( &$output, $depth ), $args );
						call_user_func_array( array( &$this, 'start_lvl' ), $cb_args );
					}
					$this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
				}
				unset( $children_elements[ $id ] );
			}

			if ( isset( $newlevel ) && $newlevel ) {
				//end the child delimiter
				$cb_args = array_merge( array( &$output, $depth ), $args );
				call_user_func_array( array( &$this, 'end_lvl' ), $cb_args );
			}

			//end this element
			$cb_args = array_merge( array( &$output, $element, $depth ), $args );
			call_user_func_array( array( &$this, 'end_el' ), $cb_args );

	}
}

/**
 * Filter Categories
 *
 */
function folio_filters_cats() {
	$categories = get_the_category();
	foreach ( $categories as $category ) {
		echo $category->slug . ' ';
	}
}

/**
 * Archives title
 *
 */
function folio_archives_title() {
	if ( is_category() ) {
		printf( __( '<span>Browsing Category: </span> %s', 'folio' ), single_cat_title( '', false ) );
	} elseif ( is_404() ) {
		printf( __( 'Oops! That page can&rsquo;t be found.', 'folio' ) );
	} elseif ( is_tag() ) {
		printf( __( '<span>Browsing Tags: </span> %s', 'folio' ), single_tag_title( '', false ) );
	} elseif ( is_day() ) {
		printf( __( '<span>Archive For: </span> %s', 'folio' ), get_the_time( 'F jS, Y', 'folio' ) );
	} elseif ( is_month() ) {
		printf( __( '<span>Archive For: </span> %s', 'folio' ), get_the_time( 'F, Y', 'folio' ) );
	} elseif ( is_year() ) {
		printf( __( '<span>Archive For: </span> %s', 'folio' ), get_the_time( 'Y', 'folio' ) );
	} elseif ( is_search() ) {
		printf( __( '<span>Search Results For: </span> %s', 'folio' ), get_search_query() );
	} elseif ( is_author() ) {
		printf( __( '<span>Posts By: </span> %s', 'folio' ), get_the_author() );
	} elseif ( is_paged() ) {
		printf( __( '<span>Browsing: </span> Blog Archives', 'folio' ) );
	}
}


/**
 * The below functionality is used because the query is set
 * in a page template, the "paged" variable is available. However,
 * if the query is on a page template that is set as the websites
 * static posts page, "paged" is always set at 0. In this case, we
 * have another variable to work with called "page", which increments
 * the pagination properly.
 *
 */
if ( ! function_exists( 'folio_get_paged_query_var' ) ) {

	function folio_get_paged_query_var() {
		if ( get_query_var( 'paged' ) ) {
			$paged = get_query_var( 'paged' );
		} elseif ( get_query_var( 'page' ) ) {
			$paged = get_query_var( 'page' );
		} else {
			$paged = 1;
		}
		return $paged;
	}
} // endif


/**
 * Get Attachment Image
 *
 * Print the attached image with a link to the next attached image.
 *
 * @since 1.0
 */
if ( ! function_exists( 'folio_the_attached_image' ) ) {

	function folio_the_attached_image() {

		// Filter the image attachment size to use.
		$attachment_size     = apply_filters( 'folio_attachment_size', array( 724, 724 ) );
		$next_attachment_url = wp_get_attachment_url();
		$post                = get_post();

		// Grab the IDs of all the image attachments in a gallery so we can get the URL
		$attachment_ids = get_posts( array(
			'post_parent'    => $post->post_parent,
			'fields'         => 'ids',
			'numberposts'    => -1,
			'post_status'    => 'inherit',
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
			'order'          => 'ASC',
			'orderby'        => 'menu_order ID',
		) );

		// If there is more than 1 attachment in a gallery...
		if ( count( $attachment_ids ) > 1 ) {
			foreach ( $attachment_ids as $attachment_id ) {
				if ( $attachment_id == $post->ID ) {
					$next_id = current( $attachment_ids );
					break;
				}
			}

			// get the URL of the next image attachment...
			if ( $next_id ) {
				$next_attachment_url = get_attachment_link( $next_id ); } // or get the URL of the first image attachment.
			else { 				$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) ); }
		}

		printf( '<a href="%1$s" title="%2$s" rel="attachment">%3$s</a>',
			esc_url( $next_attachment_url ),
			the_title_attribute( array( 'echo' => false ) ),
			wp_get_attachment_image( $post->ID, $attachment_size )
		);
	}
} // endif

/**
* Get Post Thumbnail Caption and Title
*
*/
function p75_the_post_thumbnail_title() {
	global $post;

	$thumbnail_id    = get_post_thumbnail_id( $post->ID );
	$thumbnail_image = get_posts( array( 'p' => $thumbnail_id, 'post_type' => 'attachment' ) );

	if ( $thumbnail_image && isset( $thumbnail_image[0] ) ) {
		echo $thumbnail_image[0]->post_title;
	}
}

function p75_the_post_thumbnail_caption() {
	global $post;

	$thumbnail_id    = get_post_thumbnail_id( $post->ID );
	$thumbnail_image = get_posts( array( 'p' => $thumbnail_id, 'post_type' => 'attachment' ) );

	if ( $thumbnail_image[0]->post_excerpt ) {
		echo $thumbnail_image[0]->post_excerpt;
	}
}
