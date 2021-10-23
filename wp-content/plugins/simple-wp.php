<?php
/*
 * Plugin Name: Remove Unnecessary Menus
 * Description: Do you want to remove unnecessary item from sidebar?
 * Version: 0.1
 * Licence: GPL
 * Author: Hamit Seyrek
 * Author URI: https://birmuhendis.net/
 */

function remove_menus(){
	remove_menu_page('options-general.php');
	remove_menu_page('tools.php');
	remove_menu_page('themes.php');
	remove_menu_page('edit-comments.php');
	remove_menu_page('upload.php');
	remove_menu_page('upload.php');
}

add_action('admin_menu','remove_menus');


function my_admin_bar_render() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('comments');
	$wp_admin_bar->remove_menu('wp-logo');
}

add_action( 'wp_before_admin_bar_render', 'my_admin_bar_render' );