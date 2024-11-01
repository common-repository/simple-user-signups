<?php
function sus_add_form_meta_box(){
	add_meta_box( 'sus-form-meta', 'Signup Form Options', 'sus_form_meta', 'signup-form', 'normal', 'high' );	
}

add_action( 'add_meta_boxes', 'sus_add_form_meta_box' );

function sus_form_meta($post){

	wp_nonce_field( 'sus_form_meta_save', 'sus_form_meta_box_nonce' );

	$link = get_post_meta($post->ID, 'sus-link', true);
	$submit = get_post_meta($post->ID, 'sus-email-button-text', true);
	$login = get_post_meta($post->ID, 'sus-login-button-text', true);	
	$hide_form = get_post_meta($post->ID, 'sus-hide-form', true);	

	if($hide_form == 'true'){
		$checked = 'checked';
	} else{
		$checked = '';
	}

	$post_id = get_the_ID();

	$post_status = get_post_status($post_id);

	$data = '';

	if($post_status == 'publish'){
		$data .= '<div class="updated notice notice-success is-dismissible"><p>Copy and paste the shortcode <strong>[simple-signup id="' . $post_id . '"]</strong> into any post or page you\'d like this form to appear in.</p></div>';
	}

	$data .= '<div class="wrap sus-wrap">';
		$data .= '<table>';
			$data .= '<tr><td>Email and Login Redirect Link</td><td><input type="text" name="sus-link" placeholder="www.sitename.com/get-started" value="' . $link . '" /></td></tr>';
			$data .= '<tr><td>Submit Email Button Text</td><td><input type="text" name="sus-email-button-text" placeholder="Join Now!" value="' . $submit. '"/></td></tr>';
			$data .= '<tr><td>Login Text</td><td><input type="text" name="sus-login-button-text" placeholder="Login and Get Started!" value="' . $login . '" /></td></tr>';
			$data .= '<tr><td>Hide Form When User is Logged In</td><td><input type="checkbox" name="sus-hide-form" value="true" ' . $checked . '/></td></tr>';
		$data .= '</table>';
	$data .= '</div>';

	echo $data;
}

function sus_form_meta_save($post_id){
	if ( ! isset( $_POST['sus_form_meta_box_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( $_POST['sus_form_meta_box_nonce'], 'sus_form_meta_save' ) ) {
		return;
	}

	// Is the post auto saving?
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check user permissions.
	if ( isset( $_POST['post_type'] ) && 'signup-form' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}

	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}

	// Sanitize user input.
	$link = sanitize_text_field( $_POST['sus-link'] );
	$submit = sanitize_text_field( $_POST['sus-email-button-text'] );
	$login = sanitize_text_field( $_POST['sus-login-button-text'] );

	if(isset($_POST['sus-hide-form'])){
		$hide_form = sanitize_text_field( $_POST['sus-hide-form'] );	
		update_post_meta($post_id, 'sus-hide-form', $hide_form);
	}

	// Now save post meta.
	update_post_meta( $post_id, 'sus-link', $link );
	update_post_meta( $post_id, 'sus-email-button-text', $submit );
	update_post_meta( $post_id, 'sus-login-button-text', $login );

}

add_action( 'save_post', 'sus_form_meta_save' );

?>