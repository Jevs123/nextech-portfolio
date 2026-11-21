<?php
/**
 * NexTech Portfolio – inc/post-types.php
 *
 * @package NexTech_Portfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* -------------------------------------------------------------------------
 * 3. Custom post types: Projects and (private) contact messages
 * ---------------------------------------------------------------------- */

function nextech_register_types() {
	register_post_type(
		'nextech_project',
		array(
			'labels'       => array(
				'name'               => __( 'Projects', 'nextech-portfolio' ),
				'singular_name'      => __( 'Project', 'nextech-portfolio' ),
				'add_new_item'       => __( 'Add New Project', 'nextech-portfolio' ),
				'edit_item'          => __( 'Edit Project', 'nextech-portfolio' ),
				'all_items'          => __( 'All Projects', 'nextech-portfolio' ),
				'featured_image'     => __( 'Project screenshot', 'nextech-portfolio' ),
				'set_featured_image' => __( 'Set project screenshot', 'nextech-portfolio' ),
			),
			'public'       => true,
			'has_archive'  => false,
			'show_in_rest' => true,
			'menu_icon'    => 'dashicons-portfolio',
			'menu_position' => 21,
			'rewrite'      => array( 'slug' => 'projects' ),
			'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes' ),
		)
	);

	register_post_type(
		'nextech_message',
		array(
			'labels'          => array(
				'name'          => __( 'Messages', 'nextech-portfolio' ),
				'singular_name' => __( 'Message', 'nextech-portfolio' ),
				'all_items'     => __( 'All Messages', 'nextech-portfolio' ),
			),
			'public'          => false,
			'show_ui'         => true,
			'show_in_menu'    => true,
			'menu_icon'       => 'dashicons-email-alt',
			'menu_position'   => 22,
			'capability_type' => 'post',
			'capabilities'    => array( 'create_posts' => 'do_not_allow' ),
			'map_meta_cap'    => true,
			'supports'        => array( 'title', 'editor' ),
		)
	);
}
add_action( 'init', 'nextech_register_types' );
