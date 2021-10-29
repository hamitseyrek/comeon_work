<?php
/*
 * Plugin Name: Campaign Post
 * Description: My custom post type
 * Version: 1.0.1
 * Licence: GPL
 * Author: Hamit Seyrek
 * Author URI: https://birmuhendis.net/
 * Text Domain: campaign
 */

// Hooking for custom post
add_action( 'init', 'campaign_custom_post' );
function campaign_custom_post() {
	register_post_type( 'campaign',
		array(
			'labels'       => array(
				'name'                  => __( 'Campaigns'),
				'singular_name'         => __( 'Campaign'),
				'add_new'               => __( 'New Campaign'),
				'add_new_item'          => __( 'Add New Campaign' ),
				'name_admin_bar'        => __( 'Campaign'),
				'edit_item'             => __( 'Edit Campaign' ),
				'new_item'              => __( 'New Campaign' ),
				'view_item'             => __( 'View Campaign' ),
				'all_item'              => __( 'All Campaign' ),
				'search_items'          => __( 'Search Campaign' ),
				'not_found'             => __( 'No Campaigns Found' ),
				'not_found_in_trash'    => __( 'No Campaigns found in Trash'),
				'featured_image'        => __( 'Background Image' ),
				'use_featured_image'    => __( 'Use background image' ),
				'remove_featured_image' => __( 'Remove background image' ),
				'set_featured_image'    => __( 'Select background' ),
			),
			'description'  => 'For creating Campaign page',
			'has_archive'  => true,
			'public'       => true,
			'hierarchical' => false,

			'supports' => array(
				'title',
			),

			'rewrite' => array( 'slug' => 'campaigns' ),
			//'show_in_rest' => true
		)
	);
}

/*
// for jquery library hmtsyrk
add_action( 'get_header', 'hook_javascript' );
function hook_javascript() {
	?>
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="https://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	<?php
}
*/

// for background-image upload
add_action( 'admin_enqueue_scripts', 'include_js' );
function include_js() {
	if ( ! did_action( 'wp_enqueue_media' ) ) {
		wp_enqueue_media();
	}
	wp_enqueue_script( 'campaign-admin-js', WP_PLUGIN_URL.'/Campaign/assets/js/campaign.js', array( 'jquery' ) );
}

// for custom_meta_box style
add_action( 'admin_enqueue_scripts', 'include_css' );
function include_css() {
	wp_register_style( 'custom_wp_admin_css', WP_PLUGIN_URL.'/Campaign/assets/css/campaign.css', false );
	wp_enqueue_style( 'custom_wp_admin_css' );
}

add_action( 'wp_enqueue_scripts', 'include_css_popup' );
function include_css_popup() {
	wp_register_style( 'uniquestylesheetid', WP_PLUGIN_URL.'/Campaign/assets/css/popup.css', false );
	wp_enqueue_style( 'uniquestylesheetid' );
}

//for Campaign Popup in website
include 'popup_campaign.php';

include 'include/field_for_lv.php';
include 'include/field_for_mv.php';
include 'include/field_for_hv.php';
include 'include/field_for_vip.php';



