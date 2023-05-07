<?php
/**
 * Custom Meta Fields for Videos.
 *
 * @package folio
 * @since 4.0.0
 */

/* Fire our meta box setup function on the post editor screen. */
add_action( 'load-post.php', 'folio_post_meta_boxes_setup' );
add_action( 'load-post-new.php', 'folio_post_meta_boxes_setup' );

/* Meta box setup function. */
function folio_post_meta_boxes_setup() {

	/* Add meta boxes on the 'add_meta_boxes' hook. */
	add_action( 'add_meta_boxes', 'folio_add_post_meta_boxes' );

	/* Save post meta on the 'save_post' hook. */
	add_action( 'save_post', 'folio_save_video_embed_meta', 10, 2 );
}

/* Create one or more meta boxes to be displayed on the post editor screen. */
function folio_add_post_meta_boxes() {

	add_meta_box(
		'folio-video-embed',      							// Unique ID
		esc_html__( 'Youtube or Vimeo URL', 'folio' ),    	// Title
		'folio_video_embed_meta_box',   						// Callback function
		'post',         										// Admin page (or post type)
		'normal',         										// Context
		'default'         										// Priority
	);
}

/* Display the post meta box. */
function folio_video_embed_meta_box( $object, $box ) {

	wp_nonce_field( basename( __FILE__ ), 'folio_video_embed_nonce' );

	echo '<p>';
	echo '<input class="widefat" type="text" name="folio-video-embed" id="folio-video-embed" value="'.esc_attr( get_post_meta( $object->ID, 'folio_video_embed', true ) ).'" size="30" />';
	echo '<small>If you are using YouTube or Vimeo, please enter in the video URL here.</small';
	echo '</p>';
}

/* Save the meta box's post metadata. */
function folio_save_video_embed_meta( $post_id, $post ) {

	/* Verify the nonce before proceeding. */
	if ( ! isset( $_POST['folio_video_embed_nonce'] ) || ! wp_verify_nonce( $_POST['folio_video_embed_nonce'], basename( __FILE__ ) ) ) {
		return $post_id; }

	/* Get the post type object. */
	$post_type = get_post_type_object( $post->post_type );

	/* Check if the current user has permission to edit the post. */
	if ( ! current_user_can( $post_type->cap->edit_post, $post_id ) ) {
		return $post_id; }

	/* Get the posted data and sanitize it for use as an HTML class. */
	$new_meta_value = ( isset( $_POST['folio-video-embed'] ) ? $_POST['folio-video-embed'] : '' );

	/* Get the meta key. */
	$meta_key = 'folio_video_embed';

	/* Get the meta value of the custom field key. */
	$meta_value = get_post_meta( $post_id, $meta_key, true );

	/* If a new meta value was added and there was no previous value, add it. */
	if ( $new_meta_value && '' == $meta_value ) {
		add_post_meta( $post_id, $meta_key, $new_meta_value, true ); } /* If the new meta value does not match the old value, update it. */
	elseif ( $new_meta_value && $new_meta_value != $meta_value ) {
		update_post_meta( $post_id, $meta_key, $new_meta_value ); } /* If there is no new meta value but an old value exists, delete it. */
	elseif ( '' == $new_meta_value && $meta_value ) {
		delete_post_meta( $post_id, $meta_key, $meta_value ); }
}


function customadmin_testimonial() {
	if ( is_admin() ) {
		ob_start();
		?>
		<script type='text/javascript'>
		jQuery(document).ready(function($) 
		{  
			// START UP
			show_hide_post_format_divs( $('#post-formats-select input[type="radio"]:checked').val() );
		
			// LIVE CHANGES
			$('#post-formats-select input[type="radio"]')
				.live( 'change', function(){ show_hide_post_format_divs( $(this).val() ); } );
		
			// DO HIDE/SHOW
			function show_hide_post_format_divs( val )
			{
				// WORKAROUND FOR FIRST BUTTON
				console.log( val );
				if( val === 'video' ) {
					$('#folio-video-embed').fadeIn();
				}
				else {
					$('#folio-video-embed').hide();
				}
			}
		});
		</script>
		<?php
		$script = ob_get_contents();
		ob_end_clean();
		echo $script;
	}
}
add_action( 'admin_footer', 'customadmin_testimonial' );
