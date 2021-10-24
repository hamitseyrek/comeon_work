<?php

function disclaimer_meta_box() {

	add_meta_box(
		'disclaimer',
		__( 'Disclaimer Text', 'sitepoint' ),
		'disclaimer_meta_box_callback',
		'campaign'
	);
}

add_action( 'add_meta_boxes', 'disclaimer_meta_box' );

function disclaimer_meta_box_callback( $post ) {

	// Add a nonce field so we can check for it later.
	wp_nonce_field( 'disclaimer_nonce', 'disclaimer_nonce' );

	$value = get_post_meta( $post->ID, '_disclaimer', true );
	echo '<textarea style="width:100%" id="disclaimers" name="disclaimers">' . esc_attr( $value ) . '</textarea>';

}

function save_disclaimer_meta_box_data( $post_id ) {

	// Check if our nonce is set.
	if ( ! isset( $_POST['disclaimer_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['disclaimer_nonce'], 'disclaimer_nonce' ) ) {
		return;
	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}

	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}

	/* OK, it's safe for us to save the data now. */

	// Make sure that it is set.
	if ( ! isset( $_POST['disclaimer'] ) ) {
		return;
	}

	// Sanitize user input.
	$my_data = sanitize_text_field( $_POST['disclaimer'] );

	// Update the meta field in the database.
	update_post_meta( $post_id, '_disclaimer', $my_data );
}

add_action( 'save_post', 'save_disclaimer_meta_box_data' );

function disclaimer_before_post( $content ) {

	global $post;

	// retrieve the global notice for the current post
	$disclaimer = esc_attr( get_post_meta( $post->ID, '_disclaimer', true ) );

	$notice = "<div class='sp_disclaimer'>$disclaimer</div>";

	return $notice . $content;

}

add_filter( 'the_content', 'disclaimer_before_post' );

