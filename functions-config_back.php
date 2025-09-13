<?php
// ==== CONFIGURATION (CUSTOM) ==== //
function get_cache_key($key) {
	return wp_cache_get($key, 'mosqueira_wp');
}

function set_cache_key($key, $data) {
	wp_cache_set($key, $data, 'mosqueira_wp', 250000);
	//69.4 horas
}

if (!is_admin()) {
	function add_defer_to_script( $tag, $handle, $src ) {
		$scripts_with_defer = array( 'manifest', 'script-se' );

		if ( in_array( $handle, $scripts_with_defer, true ) ) {
			$tag = '<script type="text/javascript" src="' . esc_url( $src ) . '" defer id="' . $handle . '"></script>';
		}

		return $tag;
	}
	add_filter( 'script_loader_tag', 'add_defer_to_script', 10, 3 );

	function prefix_defer_css_rel_preload( $html, $handle, $href, $media ) {
		echo '<link id="' . $handle . '" rel="stylesheet preload" as="style" href="' . $href . '" media="all">';
	}
	add_filter( 'style_loader_tag', 'prefix_defer_css_rel_preload', 10, 4 );
}

function jquery_to_footer() {
	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', false, ['jquery-core', 'jquery-migrate'], false, true );
	wp_enqueue_script( 'jquery-core', '/wp-includes/js/jquery/jquery.js', [], false, true);
	wp_enqueue_script( 'jquery-migrate', '/wp-includes/js/jquery/jquery-migrate.min.js', [], false, true);
}
add_action('wp_enqueue_scripts', 'jquery_to_footer');

function sdt_remove_ver_css_js( $src ) {
	if ( strpos( $src, 'ver=' ) ) {
		$src = remove_query_arg( 'ver', $src );
	}
	return $src;
}
add_filter( 'style_loader_src', 'sdt_remove_ver_css_js', 9999 );
add_filter( 'script_loader_src', 'sdt_remove_ver_css_js', 9999 );

// Function to unregister the WordPress embed script.
function unregister_wp_embed_script() {
	// Check if the current context is not the admin area.
	if (!is_admin()) {
		// Deregister the 'wp-embed' script.
		wp_deregister_script('wp-embed');
	}
}
add_action('init', 'unregister_wp_embed_script');

add_action( 'wp_enqueue_scripts', 'remove_select2_from_frontend', 100 );
function remove_select2_from_frontend() {
	if ( ! is_admin() ) {
		wp_dequeue_script( 'select2' );
		wp_dequeue_script( 'selectWoo' );
		wp_dequeue_script( 'select2-js' );
		wp_dequeue_script( 'thwcfd-checkout-script' );

		wp_dequeue_style( 'select2' );
		wp_dequeue_style( 'selectWoo' );
    wp_dequeue_style('wc-blocks-style');
    wp_deregister_style('wc-blocks-style');
		wp_dequeue_style( 'brands-styles' );

		wp_dequeue_style( 'woocommerce-layout' );
		wp_dequeue_style( 'woocommerce-smallscreen' );
		wp_dequeue_style( 'woocommerce-general' );
	}
}

// Remove the WordPress generator meta tag from the <head> of WordPress.
remove_action('wp_head', 'wp_generator');

// Enhance security and reduce exposure by disabling the registration of the oEmbed-related REST API route.
remove_action( 'rest_api_init', 'wp_oembed_register_route' );

// Remove oEmbed-specific JavaScript from the front-end and back-end.
remove_action( 'wp_head', 'wp_oembed_add_host_js' );

// Remove the RSD (Really Simple Discovery) link from the <head> of WordPress.
remove_action( 'wp_head', 'rsd_link');

// Remove the WLW (Windows Live Writer) manifest link from the <head> of WordPress.
remove_action( 'wp_head', 'wlwmanifest_link');

//removes feed links.
remove_action( 'wp_head', 'feed_links', 2 );

//removes comments feed.
remove_action( 'wp_head', 'feed_links_extra', 3 );

// Filters for WP-API version 1.x
add_filter( 'json_enabled', '__return_false' );
add_filter( 'json_jsonp_enabled', '__return_false' );

// Filters for WP-API version 2.x
add_filter( 'rest_enabled', '__return_false' );
add_filter( 'rest_jsonp_enabled', '__return_false' );

// Remove REST API info from head and headers
remove_action( 'xmlrpc_rsd_apis', 'rest_output_rsd' );
remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
remove_action( 'template_redirect', 'rest_output_link_header', 11 );

// Remove wp-json 404
add_filter('rest_endpoints', function( $endpoints ) {
	if (isset($endpoints['/wp/v2/users'])) {
		unset($endpoints['/wp/v2/users']);
	}
	return $endpoints;
});

//Remove everything related with emojis
function disable_wp_emojicons() {
	// all actions related to emojis
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
}
add_action( 'init', 'disable_wp_emojicons' );

//remove change language switcher in wp-admin
add_filter( 'login_display_language_dropdown', '__return_false' );


// === JUSTIFICAR TEXTO EN GUTENBERG === //
function agregar_boton_justificar_gutenberg() {
    wp_enqueue_script(
        'alinear-justificar',
        get_stylesheet_directory_uri() . '/administrator/admin/js/admin.js',
        array( 'wp-blocks', 'wp-element', 'wp-edit-post', 'wp-block-editor' ),
        filemtime( get_stylesheet_directory() . '/administrator/admin/js/admin.js' ),
        true
    );

    wp_enqueue_style(
        'alinear-justificar-css',
        get_stylesheet_directory_uri() . '/administrator/admin/css/admin.css',
        array(),
        filemtime( get_stylesheet_directory() . '/administrator/admin/css/admin.css' )
    );
}
add_action( 'enqueue_block_editor_assets', 'agregar_boton_justificar_gutenberg' );


//----------------
//custom login
include_once 'inc/actions/login-custom.php';

//remove comments
include_once 'inc/actions/class-comments.php';
