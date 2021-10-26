<?php


function hv_segment_meta_box() {

	add_meta_box(
		'hv_segment',
		__( 'HV - Segment Content', 'sitepoint' ),
		'hv_segment_meta_box_callback',
		'campaign'
	);
}

add_action( 'add_meta_boxes', 'hv_segment_meta_box' );

function hv_segment_meta_box_callback( $post ) {

	// Add a nonce field so we can check for it later.
	wp_nonce_field( 'hv_segment_nonce', 'hv_segment_nonce' );

	$header      = json_decode( get_post_meta( $post->ID, 'hv', true ) )->header;
	$description = json_decode( get_post_meta( $post->ID, 'hv', true ) )->description;
	$button_text = json_decode( get_post_meta( $post->ID, 'hv', true ) )->button_text;
	$button_link = json_decode( get_post_meta( $post->ID, 'hv', true ) )->button_link;
	$disclaimer  = json_decode( get_post_meta( $post->ID, 'hv', true ) )->disclaimer;
	$upload_image = json_decode( get_post_meta( $post->ID, 'hv', true ) )->upload_image;

	echo '<div class="container">
    <div class="row">
      <div class="col-25">
        <label>' . __( 'Header' ) . '</label>
      </div>
      <div class="col-75">
        <input type="text" name="header_hv" value="' . esc_attr( $header ) . '" >
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <th><label>' . __( 'Description' ) . '</label></th>
      </div>
      <div class="col-75">
        <textarea name="description_hv">' . esc_attr( $description ) . '</textarea>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <th><label>' . __( 'Button Text' ) . '</label></th>
      </div>
      <div class="col-75">
        <input type="text" name="button_text_hv" value="' . esc_attr( $button_text ) . '">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label>' . __( 'Button Link' ) . '</label>
      </div>
      <div class="col-75">
         <input type="text" name="button_link_hv" value="' . esc_attr( $button_link ) . '">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label>' . __( 'Disclaimer' ) . '</label>
      </div>
      <div class="col-75">
         <textarea name="disclaimer_hv">' . esc_attr( $disclaimer ) . '</textarea>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label>' . __( 'Background Image' ) . '</label>
      </div>
      <div class="col-75">';
	if ( $upload_image != null ) {
		echo '<input id="upload_image_hv" type="text" name="upload_image_hv" value="' . esc_attr( $upload_image ) . '"/>';
		echo '<a href="#" class="hase-upl" ><img width="150" src="' . $upload_image . '"  /></a>
	      <a href="#" class="hase-rmv">Remove image</a>';
	} else {
		echo '<a href="#" class="hase-upl" data-segment="hv">Upload image</a>';
		echo '<input id="upload_image_hv" type="text" name="upload_image_hv"/>';
	}
	echo '</div>
    </div>
</div>';
}

function save_hv_segment_meta_box_data( $post_id ) {

	// Check if our nonce is set.
	if ( ! isset( $_POST['hv_segment_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['hv_segment_nonce'], 'hv_segment_nonce' ) ) {
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
	$keys   = array( 'header', 'description', 'button_text', 'button_link', 'disclaimer', 'upload_image' );
	$values = array(
		sanitize_text_field( $_POST['header_hv'] ),
		sanitize_text_field( $_POST['description_hv'] ),
		sanitize_text_field( $_POST['button_text_hv'] ),
		sanitize_text_field( $_POST['button_link_hv'] ),
		sanitize_text_field( $_POST['disclaimer_hv'] ),
		sanitize_text_field( $_POST['upload_image_hv'] ),
	);
	$data   = array();
	for ( $i = 0; $i < 6; $i ++ ) {
		$data[ $keys[ $i ] ] = $values[ $i ];
	}

	// Update the meta field in the database.
	update_post_meta( $post_id, 'hv', json_encode( $data ) );
}

add_action( 'save_post', 'save_hv_segment_meta_box_data' );

function hv_segment_before_post( $content ) {

	global $post;

	// retrieve the global notice for the current post
	$button_text = esc_attr( get_post_meta( $post->ID, 'hv', true ) );

	$notice = "<div class='sp_button'>$button_text</div>";

	return $notice . $content;

}

add_filter( 'the_content', 'hv_segment_before_post' );

