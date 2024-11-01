<?php

add_filter( 'manage_edit-signup-form_columns', 'sus_edit_form_columns' ) ;

function sus_edit_form_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Form' ),
		'shortcode' => __( 'Shortcode' ),
		'date' => __( 'Date' )
	);

	return $columns;
}

add_action( 'manage_signup-form_posts_custom_column', 'sus_manage_form_columns', 10, 2 );

function sus_manage_form_columns( $column, $post_id ) {
	global $post;

	switch( $column ) {

		case 'shortcode' :

			echo '[simple-signup id="' . $post->ID . '"]';

		break;

		default :
		break;
	}
}

?>