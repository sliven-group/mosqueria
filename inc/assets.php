<?php
function theme_enqueue_scripts() {
	wp_enqueue_script( 'jquery' );

	wp_register_style( 'style-se', mix('assets/css/style.css'), [], false );

	wp_register_script( 'manifest', mix('/assets/js/manifest.js'), [], false, true );
	wp_enqueue_script( 'vendor', mix('/assets/js/vendor.js'), [], false, true );
	wp_register_script( 'script-se', mix('assets/js/script.js'), [], false, true );

	wp_enqueue_style( 'style-se' );

	wp_enqueue_script( 'manifest' );
	wp_enqueue_script( 'vendor' );
	wp_enqueue_script( 'script-se' );

	if ( is_cart() ) {
		wp_register_script( 'script-template-cart', mix('assets/js/template-cart.js'), [], false, true );
		wp_enqueue_script( 'script-template-cart' );
	}

	if ( is_checkout() ) {
		wp_register_script( 'script-template-checkout', mix('assets/js/template-checkout.js'), [], false, true );
		wp_enqueue_script( 'script-template-checkout' );

		//wp_enqueue_script( 'my-custom-script', get_template_directory_uri() . '/assets/jquery.min.js', array('jquery'), false, false );
	}

	if ( is_checkout() || is_cart() ) {
		wp_register_style( 'style-template-checkout', mix('assets/css/template-checkout.css'), [], false );
		wp_enqueue_style( 'style-template-checkout' );

		$regular   = json_decode(file_get_contents(get_template_directory() . '/assets/json/regular.json'), true);
		$express   = json_decode(file_get_contents(get_template_directory() . '/assets/json/express.json'), true);
		$provincia = json_decode(file_get_contents(get_template_directory() . '/assets/json/provincia.json'), true);

		wp_localize_script('script-se', 'tarifasDistritos', [
			'express'   => array_column($express, 'distrito'),
			'regular'   => array_column($regular, 'distrito'),
			'provincia' => $provincia,
		]);

		$current_user = wp_get_current_user();
		$user_id = $current_user->ID;

		wp_localize_script('script-se', 'preloadedData', [
			'email'   => $current_user->user_email ?? '',
			'nombres'   => get_user_meta($user_id, 'first_name', true) ?? '',
			'apellidos' => get_user_meta($user_id, 'last_name', true) ?? '',
			'telefono' => get_field('acf_user_phone', 'user_' . $user_id) ?? '',
			'departamento' => get_user_meta($user_id, 'billing_departamento', true) ?? '',
			'provincia' => get_user_meta($user_id, 'billing_provincia', true) ?? '',
			'distrito' => get_user_meta($user_id, 'billing_distrito', true) ?? ''
		]);
	}

	wp_localize_script( 'script-se', 'jsVars',
		array(
			'baseUrl' => get_bloginfo( 'url' ),
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'nonce' => wp_create_nonce('ws-nonce'),
			'theme_root' => THEME_ROOT,
			'is_cart' => is_cart(),
			'is_checkout' => is_checkout()
		)
	);
}

add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');
