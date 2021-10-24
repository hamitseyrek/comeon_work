<?php

function lv_segment_meta_box() {

	add_meta_box(
		'lv_segment',
		__( 'LV Segment', 'sitepoint' ),
		'lv_segment_meta_box_callback',
		'campaign'
	);
}
add_action( 'add_meta_boxes', 'lv_segment_meta_box' );

function lv_segment_meta_box_callback( $post ) {

	// Add a nonce field so we can check for it later.
	wp_nonce_field( 'lv_segment_nonce', 'lv_segment_nonce' );

	$header = json_decode(get_post_meta( $post->ID, '_lv', true ))->header;
	$description = json_decode(get_post_meta( $post->ID, '_lv', true ))->description;
	$button_text = json_decode(get_post_meta( $post->ID, '_lv', true ))->button_text;
	$button_link = json_decode(get_post_meta( $post->ID, '_lv', true ))->button_link;
	$disclaimer = json_decode(get_post_meta( $post->ID, '_lv', true ))->disclaimer;

	echo '<p>';
	echo '

                Header Text
                <input type="text" id="header"  name="header" value="' . esc_attr( $header ) . '"  size="60" placeholder=""> <br />';
	echo '<p>';
	echo '
	Description
                <input type="text" id="description"  name="description" value="' . esc_attr( $description ) . '"  size="60" placeholder=""><br />';
	echo '<p>';
	echo '
                Button Text
                <input type="text" id="button_text"  name="button_text" value="' . esc_attr( $button_text ) . '"  size="60" placeholder=""><br />';
	echo '<p>';
	echo '
                Button Link
                <input type="text" id="button_link"  name="button_link" value="' . esc_attr( $button_link ) . '"  size="60" placeholder=""><br />';
	echo '<p>';
	echo '
                Disclaimer
                <input type="text" id="disclaimer"  name="disclaimer" value="' . esc_attr( $disclaimer ) . '"  size="60" placeholder="">';

}

function save_lv_segment_meta_box_data( $post_id ) {

	// Check if our nonce is set.
	if ( ! isset( $_POST['lv_segment_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['lv_segment_nonce'], 'lv_segment_nonce' ) ) {
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
	if ( ! isset( $_POST['button_text'] ) && ! isset( $_POST['button_link'] ) ) {
		return;
	}

	// Sanitize user input.
	$keys   = array( 'header', 'description', 'button_text', 'button_link', 'disclaimer' );
	$values = array(
		sanitize_text_field( $_POST['header'] ),
		sanitize_text_field( $_POST['description'] ),
		sanitize_text_field( $_POST['button_text'] ),
		sanitize_text_field( $_POST['button_link'] ),
		sanitize_text_field( $_POST['disclaimer'] )
	);
	$data   = array();
	for ( $i = 0; $i < 5; $i ++ ) {
		$data[ $keys[ $i ] ] = $values[ $i ];
	}

	// Update the meta field in the database.
	update_post_meta( $post_id, '_lv',json_encode($data) );
}

add_action( 'save_post', 'save_lv_segment_meta_box_data' );

function lv_segment_before_post( $content ) {

	global $post;

	// retrieve the global notice for the current post
	$button_text = esc_attr( get_post_meta( $post->ID, '_lv', true ) );

	$notice = "<div class='sp_button'>$button_text</div>";

	return $notice . $content;

}

add_filter( 'the_content', 'lv_segment_before_post' );

