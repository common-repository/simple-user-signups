<?php
// Register simple-signup custom post type
function sus_register_simple_user_signup_form() {

	$labels = array(
		'name'                => __( 'Simple Signup Forms', 'sus-text-domain' ),
		'singular_name'       => __( 'Simple Signup Form', 'sus-text-domain' ),
		'add_new'             => _x( 'Add New Signup Form', 'sus-text-domain', 'sus-text-domain' ),
		'add_new_item'        => __( 'Add New Signup Form', 'sus-text-domain' ),
		'edit_item'           => __( 'Edit Signup Form', 'sus-text-domain' ),
		'new_item'            => __( 'New Signup Form', 'sus-text-domain' ),
		'view_item'           => __( 'View Signup Form', 'sus-text-domain' ),
		'search_items'        => __( 'Search Signup Forms', 'sus-text-domain' ),
		'not_found'           => __( 'No Signup Forms found', 'sus-text-domain' ),
		'not_found_in_trash'  => __( 'No Signup Forms found in Trash', 'sus-text-domain' ),
		'parent_item_colon'   => __( 'Parent Signup Form:', 'sus-text-domain' ),
		'menu_name'           => __( 'Signup Forms', 'sus-text-domain' ),
	);

	$args = array(
		'labels'                   => $labels,
		'hierarchical'        => false,
		'description'         => 'Simple User Signup Forms',
		'taxonomies'          => array(),
		'public'              => false,
		'show_ui'				=>true,
		'show_in_menu'        => 'admin.php?page=sus_settings',
		'show_in_admin_bar'   => true,
		'menu_icon'           => null,
		'show_in_nav_menus'   => false,
		'publicly_queryable'  => true,
		'exclude_from_search' => true,
		'has_archive'         => false,
		'query_var'           => true,
		'can_export'          => true,
		'rewrite'             => true,
		'capability_type'     => 'post',
		'supports'            => array(	'title', 'revisions' )
	);

	register_post_type( 'signup-form', $args );
}

add_action( 'init', 'sus_register_simple_user_signup_form' );
?>