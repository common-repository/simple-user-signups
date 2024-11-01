<?php
// create custom plugin settings menu
add_action('admin_menu', 'sus_create_menu');

function sus_create_menu() {

	//create new top-level menu
	add_menu_page('Simple User Signups', 'Simple Signups', 'administrator', 'sus_settings', 'sus_settings_page' );

	//call register settings function
	add_action( 'admin_init', 'register_sus_plugin_settings' );
}

function sus_register_submenu(){
    add_submenu_page( 'sus_settings', 'Add Form', 'Add Form', 'manage_options', 'post-new.php?post_type=signup-form' );
    add_submenu_page( 'sus_settings', 'Edit Forms', 'Edit Forms', 'manage_options', 'edit.php?post_type=signup-form' );
}

add_action('admin_menu', 'sus_register_submenu');

function register_sus_plugin_settings() {
	//register our settings
	register_setting( 'sus-plugin-settings-group', 'email-blank' );
	register_setting( 'sus-plugin-settings-group', 'email-invalid' );
	register_setting( 'sus-plugin-settings-group', 'email-exists' );
    register_setting( 'sus-plugin-settings-group', 'email-success' );
    register_setting( 'sus-plugin-settings-group', 'empty-password' );

    register_setting( 'sus-plugin-settings-group', 'password-auto' ); // randomly generate password and email to user or let user choose their password
}

function sus_settings_page() {
?>
<div class="wrap sus-wrap">

<h1>Simple User Signups</h1>

<div class="card" align="center">
    <h3>Please Donate to Support Continued Development.</h3>
    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
        <input type="hidden" name="cmd" value="_s-xclick">
        <input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----MIIHZwYJKoZIhvcNAQcEoIIHWDCCB1QCAQExggEwMIIBLAIBADCBlDCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbGl2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb20CAQAwDQYJKoZIhvcNAQEBBQAEgYA6oJGmJW28fcpgPVie8jiO7J+BFUNoLVXeUMYAkKtwOWTKqxYklCpC1ZHblKODFwGUdaqV7SagM/GjMr3/0+C1RNXtpQj0dFwv1LUos/fLiNFticHvUmg+xtC/4ov5Mc77vk2BYPUZfIXiCPxWYWfk/uFUWXKfaOaCZ224WXlvajELMAkGBSsOAwIaBQAwgeQGCSqGSIb3DQEHATAUBggqhkiG9w0DBwQIsx0zDtmXpYWAgcAZkJJ5s/Gxi9vfOplncmmEeyTRTvIfs5BTIWZGdvKI/8xYtSBPgY0K9XN7T0ci09/4aZfdmJ37MTix+lzbLgGFh90jFOqD+ldHlaQ1mJ6x8K9ge3wyRBvQTi7uFtjpEGnEDZJ0a1BbxUl1FWsYaXOvuhiIv3N0CXs4gYCkICmrxMtbscWLfiBOPuT6DcYkaFk2XnUED0n7r6+gW/uSzXmPyVBkJUIqoNd9kEDQZQLeF5E4iNFxa71Mcoxo8jWDAKKgggOHMIIDgzCCAuygAwIBAgIBADANBgkqhkiG9w0BAQUFADCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbGl2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb20wHhcNMDQwMjEzMTAxMzE1WhcNMzUwMjEzMTAxMzE1WjCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbGl2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb20wgZ8wDQYJKoZIhvcNAQEBBQADgY0AMIGJAoGBAMFHTt38RMxLXJyO2SmS+Ndl72T7oKJ4u4uw+6awntALWh03PewmIJuzbALScsTS4sZoS1fKciBGoh11gIfHzylvkdNe/hJl66/RGqrj5rFb08sAABNTzDTiqqNpJeBsYs/c2aiGozptX2RlnBktH+SUNpAajW724Nv2Wvhif6sFAgMBAAGjge4wgeswHQYDVR0OBBYEFJaffLvGbxe9WT9S1wob7BDWZJRrMIG7BgNVHSMEgbMwgbCAFJaffLvGbxe9WT9S1wob7BDWZJRroYGUpIGRMIGOMQswCQYDVQQGEwJVUzELMAkGA1UECBMCQ0ExFjAUBgNVBAcTDU1vdW50YWluIFZpZXcxFDASBgNVBAoTC1BheVBhbCBJbmMuMRMwEQYDVQQLFApsaXZlX2NlcnRzMREwDwYDVQQDFAhsaXZlX2FwaTEcMBoGCSqGSIb3DQEJARYNcmVAcGF5cGFsLmNvbYIBADAMBgNVHRMEBTADAQH/MA0GCSqGSIb3DQEBBQUAA4GBAIFfOlaagFrl71+jq6OKidbWFSE+Q4FqROvdgIONth+8kSK//Y/4ihuE4Ymvzn5ceE3S/iBSQQMjyvb+s2TWbQYDwcp129OPIbD9epdr4tJOUNiSojw7BHwYRiPh58S1xGlFgHFXwrEBb3dgNbMUa+u4qectsMAXpVHnD9wIyfmHMYIBmjCCAZYCAQEwgZQwgY4xCzAJBgNVBAYTAlVTMQswCQYDVQQIEwJDQTEWMBQGA1UEBxMNTW91bnRhaW4gVmlldzEUMBIGA1UEChMLUGF5UGFsIEluYy4xEzARBgNVBAsUCmxpdmVfY2VydHMxETAPBgNVBAMUCGxpdmVfYXBpMRwwGgYJKoZIhvcNAQkBFg1yZUBwYXlwYWwuY29tAgEAMAkGBSsOAwIaBQCgXTAYBgkqhkiG9w0BCQMxCwYJKoZIhvcNAQcBMBwGCSqGSIb3DQEJBTEPFw0xNTA5MjkyMTU0MDFaMCMGCSqGSIb3DQEJBDEWBBR1nRW+Jdj7SiLyK5tAdFhoznOCqDANBgkqhkiG9w0BAQEFAASBgKkBD6Br1dlWP4+aGAESOjCh4oXS49YJoAY/wCNXbYgJjqr6GVVETrODEEYQcdIVH5dVqU8awxzrTORcuoshGF7Sr/GuXThMV1v7shPApXcRM+t3exicu5WZXrn52L9D2F6PQ2HYY9MKh7Gu2bTlc0/1YE6FJ5MctTn0+T6g7lrf-----END PKCS7-----
        ">
        <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
        <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
    </form>
</div>

<div class="card sus_card" align="center">
    <a href="admin.php?page=sus_settings" class="button">Settings</a>
    <a href="post-new.php?post_type=signup-form" class="button">Add New Form</a>
    <a href="edit.php?post_type=signup-form" class="button">Edit Forms</a>
</div>

<form method="post" action="options.php" class="card sus_card">
    <h3>Email Error and Success Messages</h3>
    <?php settings_fields( 'sus-plugin-settings-group' ); ?>
    <?php do_settings_sections( 'sus-plugin-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Email Left Blank Error Message</th>
        <td><input type="text" name="email-blank" value="<?php echo esc_attr( get_option('email-blank', 'Please enter your email address.') ); ?>" /></td>
        </tr>
         
        <tr valign="top">
        <th scope="row">Invalid Email Address Error Message</th>
        <td><input type="text" name="email-invalid" value="<?php echo esc_attr( get_option('email-invalid', 'Please enter a valid email address.') ); ?>" /></td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Email Already Exists Message</th>
        <td><input type="text" name="email-exists" value="<?php echo esc_attr( get_option('email-exists', 'There is already an account associated with that email address.') ); ?>" /></td>
        </tr>

        <tr valign="top">
        <th scope="row">Success Message</th>
        <td><input type="text" name="email-success" value="<?php echo esc_attr( get_option('email-success', 'Your account was successfully created.  Check your email for your login details.') ); ?>" /></td>
        </tr>

        <tr valign="top">
        <th scope="row">Empty Password Message</th>
        <td><input type="text" name="empty-password" value="<?php echo esc_attr( get_option('empty-password', 'Please enter a password.') ); ?>" /></td>
        </tr>

        <?php 
            $auto_pass = get_option('password-auto', 'true');
        ?>

        <tr valign="top">
        <th scope="row">Generate Random Password or Let User Create Their Own</th>
        <td><input type="radio" name="password-auto" value="true" <?php if($auto_pass == 'true'){ echo 'checked'; } ?>/> Auto</td>
        <td><input type="radio" name="password-auto" value="false" <?php if($auto_pass == 'false'){ echo 'checked'; } ?>/> Choose</td>
        </tr>
    </table>
    
    <?php submit_button(); ?>

</form>
</div>
<?php } ?>