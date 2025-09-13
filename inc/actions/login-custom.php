<?php
function login_custom() {
	echo '<link rel="stylesheet" type="text/css" href="' . get_template_directory_uri() . '/administrator/css/login.css" />';
}
add_action('login_head', 'login_custom');

function login_custom_logo_url() {
	return get_site_url();
}
add_filter('login_headerurl', 'login_custom_logo_url');

function login_custom_logo_url_title() {
	return 'WS';
}
add_filter( 'login_headertext', 'login_custom_logo_url_title' );

function login_custom_error_message() {
	return 'Please enter valid login credentials.';
}
add_filter('login_errors', 'login_custom_error_message');

function login_custom_head() {
	remove_action('login_head', 'wp_shake_js', 12);
}
add_action('login_head', 'login_custom_head');
