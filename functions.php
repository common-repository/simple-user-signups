<?php

function my_login_redirect( $url, $request, $user ){
	if(isset($_POST['redirect_to'])){
        $url = $_POST['redirect_to'];
	}

    return $url;
}
add_filter('login_redirect', 'my_login_redirect', 10, 3 );

// enqueue styling
add_action( 'wp_enqueue_scripts', 'sus_enqueue_style', 2 );
function sus_enqueue_style(){
    wp_enqueue_style( 'sus_css', plugins_url('css/style.css', __FILE__ )); 
    wp_enqueue_script( 'strength_js', plugins_url('js/strength.min.js', __FILE__ ), 'jQuery'); 
}

add_action( 'admin_enqueue_scripts', 'sus_enqueue_admin_style', 2 );
function sus_enqueue_admin_style(){
    wp_enqueue_style( 'sus_admin_css', plugins_url('css/style.css', __FILE__ )); 
}

function email_form($email_label, $pass_label,  $email_placeholder_text, $pass_placeholder_text, $button_text){

	$data = '';

	if(!is_user_logged_in()){
		$data .= '<form method="post" action="?submit=true">';
			$data .= '<label>' . $email_label . '</label>';
			$data .= '<input type="email" placeholder="' . $email_placeholder_text . '" name="sus_user_email" id="sus_email" required/><br>';

			$pass_auto = get_option('password-auto');

			if($pass_auto == 'false' && $pass_auto != ''){
				$data .= '<label>' . $pass_label . '</label>';
				$data .= '<input type="password" placeholder="' . $pass_placeholder_text . '" name="sus_user_pass" id="sus_pass" required/><br>';
			}

			$data .= '<input type="submit" value="' . $button_text . '" name="sus_submit" id="sus_submit"/>';
			$data .= '<input type="hidden" name="sus_submitted" value="submitted"/>';
		$data .= '</form>';
	} else{
		$data .= '<a href="' . wp_logout_url() . '" class="sus_button">Logout</a>';
	}
	return $data;
}

?>