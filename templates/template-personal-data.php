<?php
	/* Template Name: Datos personales */

	if (!is_user_logged_in()) {
    wp_redirect(home_url());
    exit;
	}

	function add_css_js() {
		wp_register_style( 'style-perfil', mix('assets/css/template-perfil.css'), [], false );
		wp_enqueue_style( 'style-perfil' );

		wp_register_script( 'script-perfil', mix('assets/js/template-perfil.js'), [], false, true );
		wp_enqueue_script( 'script-perfil' );
	}
	add_action('wp_enqueue_scripts', 'add_css_js');
	get_header();

	$dias = range(1, 31);
	$meses = [
    'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
    'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
	];
	$anios = range(1970, 2010);
	/*$codes_phone = [
    '+51', '+54', '+591', '+55', '+56', '+57',
    '+593', '+592', '+595', '+597', '+598', '+58', '+1'
	];*/

	$current_user = wp_get_current_user();
	$user_id = $current_user->ID;
	$userDisplayName = $current_user->display_name;
	$userEmail = $current_user->user_email;
	$userFirstName = get_user_meta($current_user->ID, 'first_name', true);
	$userLastName = get_user_meta($current_user->ID, 'last_name', true);
	$birthdate = get_field('acf_user_fdn', 'user_' . $user_id);
	$selected_day = $birthdate ? $birthdate['acf_user_fdn_date'] : '';
	$selected_month = $birthdate ? $birthdate['acf_user_fdn_mes'] : '';
	$selected_year = $birthdate ? $birthdate['acf_user_fdn_ano'] : '';
	$phone = get_field('acf_user_phone', 'user_' . $user_id) ?? '';
	//$code_phone = get_field('acf_user_phone_code', 'user_' . $user_id) ?? '';
	$confirm_age = get_field('acf_user_mayor_edad', 'user_' . $user_id) ?? '';

	$name_billing = get_user_meta($user_id, 'billing_first_name', true) ?? '';
	$lastname_billing = get_user_meta($user_id, 'billing_last_name', true) ?? '';
	$address_billing = get_user_meta($user_id, 'billing_address_1', true) ?? '';
	$departamento_billing = get_user_meta($user_id, 'billing_departamento', true) ?? '';
	$provincia_billing = get_user_meta($user_id, 'billing_provincia', true) ?? '';
	$distrito_billing = get_user_meta($user_id, 'billing_distrito', true) ?? '';
	$data_departamento_billing = get_cached_locations('ubigeo_departamento', 'mos_departamentos', 'idDepa', 'departamento');
	//$genero = get_user_meta($user_id, 'mos_genero', true);
?>

<section class="mos__account">
	<div class="mos__container">
		<ul class="mos__account__nav ds-flex align-center justify-center">
			<li>
				<a class="active" href="<?php echo home_url('mi-cuenta/perfil'); ?>">Perfil</a>
			</li>
			<li>
				<a href="<?php echo home_url('mi-cuenta/pedidos'); ?>">Pedidos</a>
			</li>
			<li>
				<a href="<?php echo home_url('mi-cuenta/mosqueira-social-club'); ?>">Mosqueira Social Club</a>
			</li>
		</ul>
	</div>
</section>
<section class="mos__pd">
	<div class="mos__container">
		<div class="mos__tab">
			<ul class="mos__pd__nav mos__tab__header ds-flex align-center mb-40">
				<li class="mos__tab__li active" data-id="datos-personales">DATOS PERSONALES</li>
				<li class="mos__tab__li" data-id="direcciones">DIRECCIONES</li>
			</ul>
			<div class="mos__pd__wrapper">
				<div id="datos-personales" class="mos__pd__content__item mos__tab__content active">
					<form id="mos-form-account" action="" autocomplete="off">
						<div class="form-input mb-30">
							<label for="email-account">CORREO ELECTRONICO</label>
							<input type="email" id="email-account" name="email-account" value="<?php echo $userEmail; ?>" placeholder="Ingrese su correo electronico" autocomplete="off">
						</div>
						<div class="ds-grid ds-grid__col2 ds-grid__gap30">
							<div class="form-input mb-30">
								<label for="name-account">NOMBRES</label>
								<input type="text" id="name-account" name="name-account" value="<?php echo $userFirstName; ?>" placeholder="Ingrese tu nombre">
							</div>
							<div class="form-input mb-30">
								<label for="lastname-account">APELLIDOS</label>
								<input type="text" id="lastname-account" name="lastname-account" value="<?php echo $userLastName; ?>" placeholder="Ingrese tu apellido">
							</div>
							<div class="form-input mb-30">
								<label for="phone-account">TELEFONO</label>
								<input type="text" id="phone-account" name="phone-account" placeholder="Ingrese su telefono" autocomplete="off" value="<?php echo $phone; ?>">
								<?php /*
								<div class="ds-grid ds-grid__col2 ds-grid__gap20">
									<div>
										<select name="phone-code-account" id="phone-code-account">
											<?php foreach ($codes_phone as $code ) : ?>
												<option value="<?php echo $code; ?>" <?php selected($code_phone, $code); ?>><?php echo $code; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div> */ ?>
							</div>
							<div class="form-input mb-30">
								<label for="day-account">FECHA DE NACIMIENTO</label>
								<div class="ds-grid ds-grid__col3 ds-grid__gap20">
									<div>
										<select name="day-account" id="day-account">
											<option value="">DÍA</option>
											<?php foreach ($dias as $dia ) : ?>
												<option value="<?php echo $dia; ?>" <?php selected($selected_day, $dia); ?>><?php echo $dia; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
									<div>
										<select name="mount-account" id="mount-account">
											<option value="">MES</option>
												<?php foreach ($meses as $mes ) : ?>
													<option value="<?php echo $mes; ?>" <?php selected($selected_month, $mes); ?>><?php echo $mes; ?></option>
												<?php endforeach; ?>
											</select>
										</select>
									</div>
									<div>
										<select name="year-account" id="year-account">
											<option value="">AÑO</option>
											<?php foreach ($anios as $anio ) : ?>
												<option value="<?php echo $anio; ?>" <?php selected($selected_year, $anio); ?>><?php echo $anio; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
							</div>
							<div class="form-input mb-30">
								<label for="password-account">CONTRASEÑA <small class="mt-5">(Dejar en blanco si no desea cambiarla)</small></label>
								<input type="password" id="password-account" name="password-account" placeholder="Ingrese su contraseña" autocomplete="new-password" value="">
							</div>
							<div class="form-input mb-30">
								<label for="password-confirm-account">CONFIRMAR LA CONTRASEÑA <small class="mt-5">(Dejar en blanco si no desea cambiarla)</small></label>
								<input type="password" id="password-confirm-account" name="password-confirm-account" placeholder="Ingrese su contraseña" autocomplete="new-password" value="">
							</div>
						</div>
						<div class="form-input mb-30">
							<label class="mos-checkbox">
								<span class="mos-checkbox__text">Confirmo que soy mayor de edad y que he leído la información proporcionada conforme a la normativa vigente. Entiendo que el suministro de mis datos para perfilado y marketing es opcional y no condiciona el procesamiento de una transacción</span>
								<input type="checkbox" id="personal-data-account" name="personal-data-account" <?php echo $confirm_age ? 'checked="checked"' : '' ?>>
								<span class="mos-checkbox__checkmark"></span>
							</label>
						</div>
						<input type="hidden" id="nickname-account" name="nickname-account" value="<?php echo $userDisplayName; ?>">
						<button id="mos-form-account-btn" class="mos__btn mos__btn--primary ds-block mt-auto-40">GUARDAR CAMBIOS</button>
						<div id="mos-form-account-message" class="text-center"></div>
					</form>
				</div>
				<div id="direcciones" class="mos__tab__content">
					<form id="mos-form-billing" action="">
						<div style="display:none!important" class="ds-grid ds-grid__col2 ds-grid__gap30">
							<div class="form-input mb-30">
								<label for="name-billing">NOMBRES</label>
								<input type="text" id="name-billing" name="name-billing" value="<?php echo $name_billing; ?>" placeholder="Ingrese tu nombre">
							</div>
							<div class="form-input mb-30">
								<label for="lastname-billing">APELLIDOS</label>
								<input type="text" id="lastname-billing" name="lastname-billing" value="<?php echo $lastname_billing; ?>" placeholder="Ingrese tu apellido">
							</div>
						</div>
						<div class="form-input mb-30">
							<label for="address-billing">DIRECCIÓN</label>
							<input type="text" id="address-billing" name="address-billing" placeholder="Ingrese tu dirección" value="<?php echo $address_billing; ?>">
						</div>
						<div class="ds-grid ds-grid__col3 ds-grid__gap30">
							<div class="form-input mb-30">
								<label for="departamento-billing">DEPARTAMENTO</label>
								<select name="departamento-billing" id="departamento-billing">
									<option value="">Seleccione departamento</option>
									<?php foreach ($data_departamento_billing as $key => $dep ) : ?>
										<option value="<?php echo $key; ?>" <?php selected( $key, $departamento_billing ); ?>>
											<?php echo $dep; ?>
										</option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="form-input mb-30">
								<label for="provincia-billing">PROVINCIA</label>
								<select name="provincia-billing" id="provincia-billing" data-provincia="<?php echo esc_attr($provincia_billing); ?>">
									<option value="">Seleccione provincia</option>
								</select>
							</div>
							<div class="form-input mb-30">
								<label for="distrito-billing">DISTRITO</label>
								<select name="distrito-billing" id="distrito-billing" data-distrito="<?php echo esc_attr($distrito_billing); ?>">
									<option value="">Seleccione distrito</option>
								</select>
							</div>
						</div>
						<button id="mos-form-billing-btn" class="mos__btn mos__btn--primary ds-block mt-auto-20">GUARDAR CAMBIOS</button>
						<div id="mos-form-billing-message" class="text-center"></div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
<input id="user-id" name="user-id" type="hidden" value="<?php echo $user_id; ?>">
<?php
	get_footer();
?>
