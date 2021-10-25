<?php

function button_meta_box() {

	add_meta_box(
		'button',
		__( 'Button Text', 'sitepoint' ),
		'button_meta_box_callback',
		'campaign'
	);
}

add_action( 'add_meta_boxes', 'button_meta_box' );

function button_meta_box_callback( $post ) {

	// Add a nonce field so we can check for it later.
	wp_nonce_field( 'button_nonce', 'button_nonce' );

	$button_text = get_post_meta( $post->ID, '_button_text', true );
	$button_link = get_post_meta( $post->ID, '_button_link', true );

	echo '
					<div class="col-md-12 row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label">Button Text</label>
                                <div class="col-sm-8">
									<input style="width:100%" id="button_text" name="button_text" value="' . esc_attr( $button_text ) . '">
								</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label">Button Link</label>
                                <div class="col-sm-8">
 									<input style="width:100%" id="button_link" name="button_link" value="' . esc_attr( $button_link ) . '">
 								</div>
							</div>
						</div>
                    </div>';

}

function save_button_meta_box_data( $post_id ) {

	// Check if our nonce is set.
	if ( ! isset( $_POST['button_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['button_nonce'], 'button_nonce' ) ) {
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
	$button_text = sanitize_text_field( $_POST['button_text'] );
	$button_link = sanitize_text_field( $_POST['button_link'] );

	// Update the meta field in the database.
	update_post_meta( $post_id, '_button_text', $button_text );
	update_post_meta( $post_id, '_button_link', $button_link );
}

add_action( 'save_post', 'save_button_meta_box_data' );

function button_before_post( $content ) {

	global $post;

	// retrieve the global notice for the current post
	$button_text = esc_attr( get_post_meta( $post->ID, '_button_text', true ) );
	$button_link = esc_attr( get_post_meta( $post->ID, '_button_link', true ) );

	$notice = "<div class='sp_button'>$button_text, $button_link</div>";

	return $notice . $content;

}

add_filter( 'the_content', 'button_before_post' );