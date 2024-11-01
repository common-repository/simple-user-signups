<?php
class Simple_Signup {
	private function sus_generate_strong_password($length = 9, $add_dashes = false, $available_sets = 'luds'){
		$sets = array();
		if(strpos($available_sets, 'l') !== false)
			$sets[] = 'abcdefghjkmnpqrstuvwxyz';
		if(strpos($available_sets, 'u') !== false)
			$sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
		if(strpos($available_sets, 'd') !== false)
			$sets[] = '23456789';
		if(strpos($available_sets, 's') !== false)
			$sets[] = '!@#$%&*?';
		$all = '';
		$password = '';
		foreach($sets as $set)
		{
			$password .= $set[array_rand(str_split($set))];
			$all .= $set;
		}
		$all = str_split($all);
		for($i = 0; $i < $length - count($sets); $i++)
			$password .= $all[array_rand($all)];
		$password = str_shuffle($password);
		if(!$add_dashes)
			return $password;
		$dash_len = floor(sqrt($length));
		$dash_str = '';
		while(strlen($password) > $dash_len)
		{
			$dash_str .= substr($password, 0, $dash_len) . '-';
			$password = substr($password, $dash_len);
		}
		$dash_str .= $password;
		return $dash_str;
	}
	public static function sus_form($atts){

		$home_url = home_url();

		$a = shortcode_atts( array(
		    'id' => null,
		), $atts );

		$post_id = $a['id'];

		$hide_form = get_post_meta($post_id, 'sus-hide-form', true);	

		if($hide_form == 'true' && is_user_logged_in()){
			$style = 'style="display:none;"';
		} else{
			$style = '';
		}

		$data = '';

		$data .= '<div class="sus-form-container" ' . $style . '>';

		$simple_signup = new Simple_Signup();

		/* VALIDATE THE FORM */

		$email = '';

		if(isset($_POST['sus_user_email'])){
			$email = $_POST['sus_user_email'];
		}

		$username = $email;

		// grab email validation messages
		$email_blank = get_option('email-blank', 'Please enter your email address.');
		$email_invalid = get_option('email-invalid', 'Please enter a valid email address.');
		$email_exists = get_option('email-exists', 'There is already an account associated with that email address.');
		$email_success = get_option('email-success', 'Your account was successfully created.  Check your email for your login details.');
		$empty_password = get_option('empty-password', 'Please enter a password.');

		$email_placeholder_text = 'Email Address';
		$pass_placeholder_text = 'Password';
		$email_label = 'Email Address: ';
		$pass_label = 'Password: ';

		$link = get_post_meta($post_id, 'sus-link', true);
		$submit = get_post_meta($post_id, 'sus-email-button-text', true);
		$login = get_post_meta($post_id, 'sus-login-button-text', true);

		$email_message = get_post_meta( $post_id, 'sus-email-message', true );
		$email_subject = get_post_meta( $post_id, 'sus-email-subject', true );
		$email_cta = get_post_meta( $post_id, 'sus-email-cta', true );	
		$email_from = get_post_meta( $post_id, 'sus-email-from', true );

		$pass_auto = get_option('password-auto');

		if($pass_auto == 'true' || $pass_auto == ''){
			// generate strong password
			$password = $simple_signup->sus_generate_strong_password();
		} else{
			$password = $_POST['sus_user_pass'];
		}

		$data .= '<div class="js_sus_error" style="display:none;"></div>';

		if(!isset($_POST['sus_submitted'])){

			$data .= '<div class="sus_wrapper">';
			$data .= email_form($email_label, $pass_label, $email_placeholder_text, $pass_placeholder_text, $submit);
			$data .= '</div>';
		} elseif( $email == '' ){
			$data .= '<div class="sus_error">' . $email_blank . '</div>';
			$data .= '<div class="sus_wrapper">';
			$data .= email_form($email_label, $pass_label, $email_placeholder_text, $pass_placeholder_text, $submit);			
			$data .= '</div>';
		} elseif( !filter_var($email, FILTER_VALIDATE_EMAIL) ){
			$data .= '<div class="sus_error">' . $email_invalid . '</div>';
			$data .= '<div class="sus_wrapper">';
			$data .= email_form($email_label, $pass_label, $email_placeholder_text, $pass_placeholder_text, $submit);
			$data .= '</div>';
		} elseif( username_exists( $username ) ){
			$data .= '<div class="sus_error">' . $email_exists . '</div>';
			$data .= '<div class="sus_wrapper">';
			$data .= email_form($email_label, $pass_label, $email_placeholder_text, $pass_placeholder_text, $submit);
			$data .= '</div>';
		} elseif( $password == '' ){
			$data .= '<div class="sus_error">' . $empty_password . '</div>';
			$data .= '<div class="sus_wrapper">';
			$data .= email_form($email_label, $pass_label, $email_placeholder_text, $pass_placeholder_text, $submit);
			$data .= '</div>';
		} else{

			$data .= '<div class="sus_success">' . $email_success . '</div>';

			// create the user
			wp_create_user( $username, $password, $email );

			// send user an email with their account details
			$site_name = get_bloginfo('name');
			$subject = $email_subject;

			$message = $email_message . '<br><br>';
			$message .= 'Username: ' . $email . '<br>';
			$message .= 'Password: ' . $password . '<br><br>';
			$message .= '<a href="' . $link . '">' . $email_cta . '</a><br><br>';
			$message .= '<a href="' . wp_login_url( ) . '">Login Here</a> or <a href="' . wp_lostpassword_url( $link ) . '">Reset Your Password Here</a>.';

			// set mail to allow html
			add_filter( 'wp_mail_content_type', 'set_html_content_type' );

			function set_html_content_type() {
				return 'text/html';
			}

			// preserve line breaks
			$message = nl2br($message);;

			// if email_from post meta empty use admin email
			if(empty($email_from)){
				$email_from = get_bloginfo('admin_email');
			}

			$headers = 'From: <' . $email_from . '>' . "\r\n";

			wp_mail( $email, $email_subject, $message, $headers );

			// reset content type
			remove_filter( 'wp_mail_content_type', 'set_html_content_type' );

			$login_form = wp_login_form(array(
				'echo'				=> false,
				'label_username' 	=> 'Email',
				'value_username'	=> $_POST['sus_user_email'],
				'label_log_in'		=> $login,
				'value_remember' 	=> true,
				'redirect'			=> $link,
			));

			$data .= '<div class="sus_wrapper">';
			$data .= $login_form;
			$data .= '</div>';
		} 

		$data .= '<script>

			var error = jQuery(".sus_error");

			if(error){
				for(i=0;i<3;i++) {
					error.first().fadeTo("slow", 0.5).fadeTo("slow", 1.0);
				}
			}

			if(error.length >= 1){
				jQuery("html, body").animate({
			        scrollTop: error.offset().top
			    }, 1000);
			}
			var success = jQuery(".sus_success");

			if(success.length >= 1){
				jQuery("html, body").animate({
			        scrollTop: success.offset().top - 40
			    }, 1000);
			}';

		if($pass_auto == 'false'){
			$data .= 'var passInput = jQuery("#sus_pass");

			jQuery("#sus_submit").click(function(e){
				if(passInput.val().length < 5){
					jsError = jQuery(".js_sus_error");
					jsError.css("display", "block");

					for(i=0;i<3;i++) {
						jsError.html("Your password must contain at least 5 characters.");
						jsError.fadeTo("slow", 0.5).fadeTo("slow", 1.0);
					}
					e.preventDefault();
				}
			});

			passInput.strength();';


		}

		$data .= '</script>';

		/*

		$data .= '<div id="hidden-pswrd">' . $password . '</div>';

		$data .= '<script>
			var pass = jQuery("#hidden-pswrd").text();
			jQuery("#hidden-pswrd").text("");
			jQuery("#user_pass").val(pass);
		</script>';

		*/

		$data .= '</div>';

		return $data;
	}
}

add_shortcode( 'simple-signup', array('Simple_Signup', 'sus_form') );
?>