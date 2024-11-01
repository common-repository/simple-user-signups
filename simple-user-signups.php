<?php
/**
 * @package           Simple User Signups
 * @author            Web Monkey Design and Development
 * @author            Myles English
 * @author            Myles English <myleslloydenglish@hotmail.com>
 * @link              http://www.webmonkeydd.com/
 *
 * @wordpress-plugin
 * Plugin Name:       Simple User Signups
 * Description:       Users can create a WordPress account with only their email address.  Great for gathering leads on landing pages.  Password is randomly generated and emailed to users.  Email address is also used for username.  Use shortcode [simple-signup] with parameter id equal to post id.
 * Version:           1.0.0
 * Author:            Web Monkey Design and Development
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

include 'functions.php';
include 'settings.php';
include 'meta-box-donate.php';
include 'meta-box-form.php';
include 'meta-box-email.php';
include 'cp-type-signup-form.php';
include 'class-simple-signup.php';
include 'columns-signup-form.php';