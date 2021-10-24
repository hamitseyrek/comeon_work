<?php


function vip_segment_meta_box() {

	add_meta_box(
		'vip_segment',
		__( 'VIP - Segment Content', 'sitepoint' ),
		'vip_segment_meta_box_callback',
		'campaign'
	);
}

add_action( 'add_meta_boxes', 'vip_segment_meta_box' );

function vip_segment_meta_box_callback( $post ) {

	// Add a nonce field so we can check for it later.
	wp_nonce_field( 'vip_segment_nonce', 'vip_segment_nonce' );

	$header      = json_decode( get_post_meta( $post->ID, 'vip', true ) )->header;
	$description = json_decode( get_post_meta( $post->ID, 'vip', true ) )->description;
	$button_text = json_decode( get_post_meta( $post->ID, 'vip', true ) )->button_text;
	$button_link = json_decode( get_post_meta( $post->ID, 'vip', true ) )->button_link;
	$disclaimer  = json_decode( get_post_meta( $post->ID, 'vip', true ) )->disclaimer;

	echo '<p>';
	echo '

                Header Text
                <input type="text" name="header_vip" value="' . esc_attr( $header ) . '"  size="60" placeholder=""> <br />';
	echo '</p>';
	echo '<p>';
	echo '
	Description
                <input type="text" name="description_vip" value="' . esc_attr( $description ) . '"  size="60" placeholder=""><br />';
	echo '</p>';
	echo '<p>';
	echo '
                Button Text
                <input type="text" name="button_text_vip" value="' . esc_attr( $button_text ) . '"  size="60" placeholder=""><br />';
	echo '</p>';
	echo '<p>';
	echo '
                Button Link
                <input type="text" name="button_link_vip" value="' . esc_attr( $button_link ) . '"  size="60" placeholder=""><br />';
	echo '</p>';
	echo '<p>';
	echo '
                Disclaimer
                <input type="text" name="disclaimer_vip" value="' . esc_attr( $disclaimer ) . '"  size="60" placeholder=""><br />';
	echo '</p>';

}

function save_vip_segment_meta_box_data( $post_id ) {

	// Check if our nonce is set.
	if ( ! isset( $_POST['vip_segment_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['vip_segment_nonce'], 'vip_segment_nonce' ) ) {
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
		sanitize_text_field( $_POST['header_vip'] ),
		sanitize_text_field( $_POST['description_vip'] ),
		sanitize_text_field( $_POST['button_text_vip'] ),
		sanitize_text_field( $_POST['button_link_vip'] ),
		sanitize_text_field( $_POST['disclaimer_vip'] )
	);
	$data   = array();
	for ( $i = 0; $i < 5; $i ++ ) {
		$data[ $keys[ $i ] ] = $values[ $i ];
	}

	// Update the meta field in the database.
	update_post_meta( $post_id, 'vip', json_encode( $data ) );
}
add_action( 'save_post', 'save_vip_segment_meta_box_data' );

function vip_segment_before_post( $content ) {

	global $post;

	// retrieve the global notice for the current post
	$button_text = esc_attr( get_post_meta( $post->ID, 'vip', true ) );

	$notice = "<div class='sp_button'>$button_text</div>";

	return $notice . $content;

}

add_filter( 'the_content', 'vip_segment_before_post' );

