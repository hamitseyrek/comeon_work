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

function campaign_custom_post() {
	register_post_type( 'campaign',
		array(
			'labels' => array(
				'name'                  => __( 'Campaigns', 'codem' ),
				'singular_name'         => __( 'Campaign', 'codem' ),
				'add_new'               => __( 'New Campaign', 'codem' ),
				'add_new_item'          => __( 'Add New Campaign' ),
				'name_admin_bar'        => __( 'Campaign', 'admin bar' ),
				'edit_item'             => __( 'Edit Campaign' ),
				'new_item'              => __( 'New Campaign' ),
				'view_item'             => __( 'View Campaign' ),
				'all_item'              => __( 'All Campaign' ),
				'search_items'          => __( 'Search Campaign' ),
				'not_found'             => __( 'No Campaigns Found' ),
				'not_found_in_trash'    => __( 'No Campaigns found in Trash', 'codem' ),
				'featured_image'        => __( 'Background Image' ),
				'use_featured_image'    => __( 'Use background image' ),
				'remove_featured_image' => __( 'Remove background image' ),
				'set_featured_image'    => __( 'Select background' ),
			),

			'has_archive'  => true,
			'public'       => true,
			'hierarchical' => false,

			'supports' => array(
				'title',
				'editor',
				'thumbnail',
			),

			'rewrite' => array( 'slug' => 'campaigns' ),
			//'show_in_rest' => true
		)
	);
}

// Hooking up our function to theme setup
add_action( 'init', 'campaign_custom_post' );

include 'include/field_for_segment.php';
include 'include/field_for_button.php';
include 'include/remove_media_button.php';
include 'include/field_for_disclaimer.php';



