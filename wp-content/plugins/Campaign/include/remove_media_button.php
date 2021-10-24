<?php

function remove_media_buttons() {
	global $current_screen;
	if( 'campaign' == $current_screen->post_type ) remove_action('media_buttons', 'media_buttons');
}
add_action('admin_head','remove_media_buttons');