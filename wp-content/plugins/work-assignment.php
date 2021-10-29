<?php
/*
 * Plugin Name: Work Assignment
 * Description: What you can really do?
 * Version: 0.1
 * Licence: GPL
 * Author: Hamit Seyrek
 * Author URI: https://birmuhendis.net/
 */

function remove_menus() {
	remove_menu_page( 'options-general.php' );
	remove_menu_page( 'tools.php' );
	remove_menu_page( 'themes.php' );
	remove_menu_page( 'edit-comments.php' );
	remove_menu_page( 'upload.php' );
	remove_menu_page( 'upload.php' );
	remove_submenu_page( 'plugins.php', 'plugin-editor.php' );
	remove_submenu_page( 'plugins.php', 'plugin-install.php' );
}

add_action( 'admin_menu', 'remove_menus' );


function my_admin_bar_render() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu( 'comments' );
	$wp_admin_bar->remove_menu( 'wp-logo' );
}

add_action( 'wp_before_admin_bar_render', 'my_admin_bar_render' );

function admin_default_page() {
	return '/comeon_work/';
}

add_filter( 'login_redirect', 'admin_default_page' );

function getSegment() {
	$url   = 'https://promocje.pzbuk.pl/comeon-work-assignment/';
	$email = wp_get_current_user()->user_email;
	//wp_remote_post( $url, $data );
	$response = wp_remote_post( $url, array(
			'method'      => 'POST',
			'timeout'     => 45,
			'body'        => array(
				'email' => $email
			),
			'cookies'     => array()
		)
	);

	if ( is_wp_error( $response ) ) {
		//$error_message = $response->get_error_message();
		return '';
	} else {
		return json_decode( $response['body'] )->result->value;
	}
}


