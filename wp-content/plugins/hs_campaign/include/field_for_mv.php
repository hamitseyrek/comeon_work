<?php
function mv_segment_meta_box() {

	add_meta_box(
		'mv_segment',
		__( 'MV - Segment Content', 'sitepoint' ),
		'mv_segment_meta_box_callback',
		'campaign'
	);
}

add_action( 'add_meta_boxes', 'mv_segment_meta_box' );

function mv_segment_meta_box_callback( $post ) {

	// Add a nonce field so we can check for it later.
	wp_nonce_field( 'mv_segment_nonce', 'mv_segment_nonce' );
	$postJsonDecode = json_decode( get_post_meta( $post->ID, 'mv', true ) );

	echo '<div class="container">
    <div class="row">
      <div class="col-25">
        <label>' . __( 'Header' ) . '</label>
      </div>
      <div class="col-75">
        <input type="text" name="header_mv" value="' . esc_attr( $postJsonDecode->header ) . '" >
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <th><label>' . __( 'Description' ) . '</label></th>
      </div>
      <div class="col-75">
        <textarea name="description_mv">' . esc_attr( $postJsonDecode->description ) . '</textarea>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <th><label>' . __( 'Button Text' ) . '</label></th>
      </div>
      <div class="col-75">
        <input type="text" name="button_text_mv" value="' . esc_attr( $postJsonDecode->button_text ) . '">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label>' . __( 'Button Link' ) . '</label>
      </div>
      <div class="col-75">
         <input type="text" name="button_link_mv" value="' . esc_attr( $postJsonDecode->button_link ) . '">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label>' . __( 'Disclaimer' ) . '</label>
      </div>
      <div class="col-75">
         <textarea name="disclaimer_mv">' . esc_attr( $postJsonDecode->disclaimer ) . '</textarea>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label>' . __( 'Background Image' ) . '</label>
      </div>
      <div class="col-75">';
	if ( $postJsonDecode->upload_image != null ) {
		echo '<input id="upload_image_mv" type="text" name="upload_image_mv" value="' . esc_attr( $postJsonDecode->upload_image ) . '"/>';
		echo '<a href="#" class="hase-upl" data-segment="mv"><img width="150" src="' . $postJsonDecode->upload_image . '"  /></a>
	      <a href="#" class="hase-rmv" data-segment="mv">Remove image</a>';
	} else {
		echo '<a href="#" class="hase-upl" data-segment="mv">Upload image</a>';
		echo '<input id="upload_image_mv" type="text" name="upload_image_mv"/>';
	}
	echo '</div>
    </div>
</div>';
}

function save_mv_segment_meta_box_data( $post_id ) {

	// Check if our nonce is set.
	if ( ! isset( $_POST['mv_segment_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['mv_segment_nonce'], 'mv_segment_nonce' ) ) {
		return;
	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check the user's permissions.

	if ( isset( $_POST['post_type'] ) && ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}


	/* OK, it's safe for us to save the data now. */


	// Sanitize user input.
	$keys   = array( 'header', 'description', 'button_text', 'button_link', 'disclaimer', 'upload_image' );
	$values = array(
		sanitize_text_field( $_POST['header_mv'] ),
		sanitize_text_field( $_POST['description_mv'] ),
		sanitize_text_field( $_POST['button_text_mv'] ),
		sanitize_text_field( $_POST['button_link_mv'] ),
		sanitize_text_field( $_POST['disclaimer_mv'] ),
		sanitize_text_field( $_POST['upload_image_mv'] ),
	);
	$data   = array();
	for ( $i = 0; $i < 6; $i ++ ) {
		$data[ $keys[ $i ] ] = $values[ $i ];
	}

	// Update the meta field in the database.
	update_post_meta( $post_id, 'mv', json_encode( $data ) );
}

add_action( 'save_post', 'save_mv_segment_meta_box_data' );