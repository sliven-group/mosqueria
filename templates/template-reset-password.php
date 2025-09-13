<?php
	/* Template Name: Restablecer contraseña */

	if (is_user_logged_in()) {
    wp_redirect(home_url());
    exit;
	}

	$login = isset($_GET['login']) ? sanitize_text_field($_GET['login']) : '';
	$key   = isset($_GET['key']) ? sanitize_text_field($_GET['key']) : '';

	if (empty($login) || empty($key)) {
		wp_redirect(home_url());
    exit;
	}

	$user = check_password_reset_key($key, $login);

	if (is_wp_error($user)) {
		wp_redirect(home_url());
    exit;
		wp_die('Este enlace ya expiró o es inválido.');
	}

	function add_css_js() {
		wp_register_style( 'style-reset-password', mix('assets/css/template-reset-password.css'), [], false );
		wp_enqueue_style( 'style-reset-password' );

		wp_register_script( 'script-reset-password', mix('assets/js/template-reset-password.js'), [], false, true );
		wp_enqueue_script( 'script-reset-password' );
	}
	add_action('wp_enqueue_scripts', 'add_css_js');

	get_header();
?>

<section class="mos__password">
	<div class="mos__container">
		<form id="mos-form-password-create" action="">
			<div class="form-input mb-20">
				<label for="email-password">CORREO ELECTRONICO</label>
				<input type="email" id="email-password" name="email-password" value="" placeholder="Ingrese su correo electronico" autocomplete="off">
			</div>
			<div class="form-input mt-20">
				<label for="password-password">NUEVA CONTRASEÑA</label>
				<input type="password" id="password-password" name="password-password" placeholder="Ingrese su contraseña" autocomplete="off">
			</div>
			<div class="form-input mt-20">
				<label for="password-password-2">REPETIR CONTRASEÑA</label>
				<input type="password" id="password-password-2" name="password-password-2" placeholder="Ingrese su contraseña" autocomplete="off">
			</div>
			<input type="hidden" name="user_login" value="<?php echo esc_attr($login); ?>">
			<input type="hidden" name="rp_key" value="<?php echo esc_attr($key); ?>">
			<button id="mos-form-password-create-btn" class="mos__btn mos__btn--primary mt-40 upper">Guardar nueva contraseña</button>
			<div id="mos-form-password-create-message" class="mt-20 ds-flex flex-wrap align-center">
				<p style="margin: 0 15px 0 0;"></p>
				<button data-modal-target="mos-modal-account" class="mos__btn mos__btn--text js-modal-trigger ds-none" style="padding: 10px 0;min-width: auto;">Iniciar sesión</button>
			</div>
		</form>
	</div>
</section>
<?php
	get_footer();
?>
