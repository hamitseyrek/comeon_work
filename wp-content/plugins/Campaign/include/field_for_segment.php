<?php

function segments_meta_box() {

	add_meta_box(
		'segment',
		__( 'Select Segment', 'sitepoint' ),
		'segments_meta_box_callback',
		'campaign'
	);
}

add_action( 'add_meta_boxes', 'segments_meta_box' );

function segments_meta_box_callback( $post ) {

	// Add a nonce field so we can check for it later.
	wp_nonce_field( 'segments_nonce', 'segments_nonce' );

	$value = get_post_meta( $post->ID, '_segments', true );
	$lv    = $value == 'LV' ? 'selected' : '';
	$mv    = $value == 'MV' ? 'selected' : '';
	$hv    = $value == 'HV' ? 'selected' : '';
	$vip   = $value == 'VIP' ? 'selected' : '';
	echo '<select id="segments" name="segments" class="form-control">
                                            <option value="LV" ' . esc_attr( $lv ) . '>LV</option>
                                            <option value="MV" ' . esc_attr( $mv ) . '>MV</option>
                                            <option value="HV" ' . esc_attr( $hv ) . '>HV</option>
                                            <option value="VIP" ' . esc_attr( $vip ) . '>VIP</option>
                                    </select>';

}

function save_segments_meta_box_data( $post_id ) {

	// Check if our nonce is set.
	if ( ! isset( $_POST['segments_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['segments_nonce'], 'segments_nonce' ) ) {
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
	if ( ! isset( $_POST['segments'] ) ) {
		return;
	}

	// Sanitize user input.
	$my_data = sanitize_text_field( $_POST['segments'] );

	// Update the meta field in the database.
	update_post_meta( $post_id, '_segments', $my_data );
}

add_action( 'save_post', 'save_segments_meta_box_data' );

function segments_before_post( $content ) {

	global $post;

	// retrieve the global notice for the current post
	$segments = esc_attr( get_post_meta( $post->ID, '_segments', true ) );

	$notice = "<div class='sp_segments'>$segments</div>";

	return $notice . $content;

}

add_filter( 'the_content', 'segments_before_post' );

