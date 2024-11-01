<?php
function sus_add_email_meta_box(){
	add_meta_box( 'sus-form-email-meta', 'Email Message and Options', 'sus_form_email_meta', 'signup-form', 'normal', 'high' );	
}

add_action( 'add_meta_boxes', 'sus_add_email_meta_box' );

function sus_form_email_meta($post){

	wp_nonce_field( 'sus_form_email_meta_save', 'sus_form_email_meta_box_nonce' );

	$site_name = get_bloginfo('name');

	$admin_email = get_bloginfo('admin_email');

	$email_message = get_post_meta( $post->ID, 'sus-email-message', true );
	$email_subject = get_post_meta( $post->ID, 'sus-email-subject', true );
	$email_cta = get_post_meta( $post->ID, 'sus-email-cta', true );
	$email_from = get_post_meta( $post->ID, 'sus-email-from', true );

	if(empty($email_from)){
		$email_from = $admin_email;
	}	

	if(empty($email_message)){
		$email_message = 'Hi,<br><br>Thanks for Joining ' . $site_name . '.  Below you will find your login credentials.';
	}

	$data = '';

	$data .= wp_editor( $email_message, 'email-message', $settings = array('textarea_name => email-message') );

	$data .= '<br>';
	$data .= '<div class="wrap sus-wrap">';
		$data .= '<table>';

			$data .= '<tr><td>Email Subject</td><td><input type="text" name="email-subject" placeholder="Thanks for Joining ' . $site_name . '" value="' . $email_subject . '" /></td></tr>';
			$data .= '<tr><td>Email Call to Action</td><td><input type="text" name="email-cta" placeholder="Start Now!" value="' . $email_cta . '" /></td></tr>';
			$data .= '<tr><td>Email From</td><td><input type="text" name="email-from" placeholder="Start Now!" placeholder="' . $admin_email . '" value="' . $email_from . '" /></td></tr>';

		$data .= '</table>';
	$data .= '</div>';

	echo $data;

}

function sus_form_email_meta_save($post_id){
	if ( ! isset( $_POST['sus_form_email_meta_box_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( $_POST['sus_form_email_meta_box_nonce'], 'sus_form_email_meta_save' ) ) {
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
	$email_message = $_POST['email-message'];
	$email_subject = sanitize_text_field( $_POST['email-subject'] );
	$email_cta = sanitize_text_field( $_POST['email-cta'] );
	$email_from = sanitize_text_field( $_POST['email-from'] );

	// Now save post meta.
	update_post_meta($post_id, 'sus-email-message', $email_message );
	update_post_meta($post_id, 'sus-email-subject', $email_subject);
	update_post_meta($post_id, 'sus-email-cta', $email_cta);
	update_post_meta($post_id, 'sus-email-from', $email_from);
}
add_action( 'save_post', 'sus_form_email_meta_save' );
?>