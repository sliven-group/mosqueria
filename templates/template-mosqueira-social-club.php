<?php
	/* Template Name: Mosqueira social club */

	if (!is_user_logged_in()) {
    wp_redirect(home_url());
    exit;
	}

	function add_css_js() {
		wp_register_style( 'style-template-mosqueira-social-club', mix('assets/css/template-mosqueira-social-club.css'), [], false );
		wp_enqueue_style( 'style-template-mosqueira-social-club' );

		/*wp_register_script( 'script-perfil', mix('assets/js/template-perfil.js'), [], false, true );
		wp_enqueue_script( 'script-perfil' );*/
	}
	add_action('wp_enqueue_scripts', 'add_css_js');
	get_header();

	$user = get_current_user_id();
	$data_user = get_userdata($user);
	$data_user_id = $data_user->ID;
	$categoria = get_user_meta($data_user_id, 'mosqueira_categoria', true);
	$puntos = get_user_meta($data_user_id, 'mosqueira_puntos', true);
	$valorMaximo = 30000;
	$proporcion = ($puntos / $valorMaximo) * 100;
	$puntosNext = 500;
	$puntosNextText = '';
	$puntosFinal = round($proporcion, 2) . '%';

	// if($puntos >= '5000' &&  $puntos < '5100') {
	// 	$puntosFinal = 20.5 . '%';
	// } elseif($puntos === '15000') {
	// 	$puntosFinal = 40.5 . '%';
	// } elseif($puntos >= '30000') {
	// 	$puntosFinal = 100.5 . '%';
	// } elseif($puntos === '500') {
	// 	$puntosFinal = 2.5 . '%';
	// } elseif($puntos >= '11000' && $puntos < '15000') {
	// 	$puntosFinal = round($proporcion, 2) - 10 . '%';
	// }
	if ($categoria === 'Gold') {
		$puntosNext = 30000;
		$puntosNextText = 'Platinum';
	} elseif ($categoria === 'Silver') {
		$puntosNext = 15000;
		$puntosNextText = 'Gold';
	} elseif ($categoria === 'Access') {
		$puntosNext = 5000;
		$puntosNextText = 'Silver';
	}
	$puntosFaltantes = $puntosNext - $puntos;
	$historial = get_user_meta($data_user_id, 'mosqueira_historial', true);
?>

<section class="mos__account">
	<div class="mos__container">
		<ul class="mos__account__nav ds-flex align-center justify-center">
			<li>
				<a href="<?php echo home_url('mi-cuenta/perfil'); ?>">Perfil</a>
			</li>
			<li>
				<a href="<?php echo home_url('mi-cuenta/pedidos'); ?>">Pedidos</a>
			</li>
			<li>
				<a class="active" href="<?php echo home_url('mi-cuenta/mosqueira-social-club'); ?>">Mosqueira Social Club</a>
			</li>
		</ul>
	</div>
</section>
<section class="mos__msc">
	<div class="mos__container">
		<div class="ds-flex justify-space-between align-start flex-wrap">
			<h2>Su nivel actual: <strong><?php echo $categoria; ?></strong></h2>
			<a href="<?php echo home_url('mosqueira-social-club/'); ?>" class="mos__btn mos__btn--primary upper">Sobre Mosqueira Social Club</a>
		</div>
		<div class="mos__msc__scroll mt-40">
			<h3><?php echo number_format($puntos); ?> puntos</h3>
			<div class="mos__msc__progress">
				<div class="mos__msc__progress__bar" role="progressbar" aria-label="points earned" aria-valuenow="<?php echo $puntos; ?>" aria-valuemin="0" aria-valuemax="<?php echo $valorMaximo; ?>" style="width: <?php echo $puntosFinal; ?>;"></div>
			</div>
			<ul class="mos__msc__levels ds-flex relative">
				<li>Access
					<span aria-hidden="true">0</span>
					<span class="sr-only">0 Puntos</span>
				</li>
				<li>Silver
					<span aria-hidden="true">5,000 +</span>
					<span class="sr-only">5,000 + Puntos</span>
				</li>
				<li>Gold
					<span aria-hidden="true">15,000 +</span>
					<span class="sr-only">15,000 + Puntos</span>
				</li>
				<li>Platinum
					<span aria-hidden="true">30,000 +</span>
					<span class="sr-only">30,000 + Puntos</span>
				</li>
			</ul>
		</div>
		<ul class="mos__msc__info">
			<li>Su nivel se basa en los puntos acumulados durante el año.</li>
			<li>No olvide usar su correo registrado al comprar en tienda, web o WhatsApp para acumular puntos por todas sus compras.</li>
		</ul>
		<?php if($puntos >= 5000): ?>
			<!--<div class="mos__msc__ben">
				<h3 class="mt-50">Beneficios Mensuales</h3>
				<div class="ds-grid ds-grid__gap10 ds-grid__col3 mt-30">
					<div class="item-msc ds-flex justify-center align-center">
						<div>
							<h4>PERU2025</h4>
							<p>Utilice el codigo PERU2025 y obtenga un 25% de descuento.</p>
						</div>
					</div>
					<div class="item-msc item-msc--img ds-flex justify-center align-center">
						<img loading="lazy" src="<?php echo IMAGES . 'promocion-imagen.webp'; ?>" alt="promoción">
					</div>
					<div class="item-msc item-msc--2 ds-flex justify-center align-center">
						<div>
							<h4>2x1</h4>
							<p>Contáctenos para poder acceder a una increible promoción.</p>
							<a href="https://api.whatsapp.com/send/?phone=%2B51908900915&text&type=phone_number&app_absent=0" target="_blank" class="mos__btn mos__btn--transparent-white">CONTACTAR</a>
						</div>
					</div>
				</div>
			</div> -->

			<div class="mos__msc__ben">
				<h3 class="mt-50">Beneficios Mensuales</h3>
				<div class="ds-grid ds-grid__gap10 ds-grid__col2 mt-30">
					<div class="item-msc item-msc--img ds-flex justify-center align-center">
						<a href="https://api.whatsapp.com/send/?phone=%2B51908900915&text=Hola%2C%20deseo%20sumar%20los%20puntos%20de%20mi%20compra%20por%20WhatsApp%20a%20mi%20cuenta%20de%20Mosqueira%20Social%20Club&type=phone_number&app_absent=0" target="_blank">
							<img loading="lazy" src="<?php echo IMAGES . 'beneficios_01.png'; ?>" alt="promoción">
						</a>
					</div>
					<div class="item-msc item-msc--img ds-flex justify-center align-center">
						<a href="https://api.whatsapp.com/send/?phone=%2B51908900915&text=Hola%2C%20deseo%20sumar%20los%20puntos%20de%20mi%20compra%20por%20WhatsApp%20a%20mi%20cuenta%20de%20Mosqueira%20Social%20Club&type=phone_number&app_absent=0" target="_blank">
							<img loading="lazy" src="<?php echo IMAGES . 'beneficios_02.png'; ?>" alt="promoción">
						</a>
					</div>
				</div>
			</div>

		<?php endif; ?>
		<?php if($historial) : ?>
			<div class="mos__msc__history">
				<h3 class="mt-50">Su Historial de Puntos</h3>
				<p class="mt-20">Usted alcanzó los <?php echo $puntos; ?> puntos.
				<?php if($puntosNextText !== ''): ?>
					¡Se encuentra a solo <?php echo $puntosFaltantes; ?> puntos de ser un cliente <?php echo $puntosNextText; ?>!
				<?php endif; ?>
				</p>
				<div class="mos__msc__history__header ds-flex justify-space-between flex-wrap">
					<h4>Detalles</h4>
					<h4>Puntos</h4>
				</div>
				<div class="mos__msc__history__items">
					<?php
						$historial = array_reverse($historial);
						foreach ($historial as $evento) :
					?>
						<div class="item ds-flex justify-space-between flex-wrap">
							<div class="item__col">
								<small><?php echo esc_html($evento['fecha']); ?></small>
								<p><?php echo esc_html($evento['title']); ?></p>
								<?php if( !empty($evento['descripcion']) ) : ?>
									<?php echo wp_kses_post($evento['descripcion']); ?>
								<?php endif; ?>
							</div>
							<div class="item__col">
								<?php if($evento['tipo'] === 'categoria') : ?>
									<span class="item__col__cat"><?php echo $evento['puntos_categoria']; ?></span>
								<?php else : ?>
									<span class="item__col__points"><?php echo $evento['puntos_categoria']; ?></span>
								<?php endif; ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>
		<div class="mos__msc__desc">
			<h3 class="mt-50">Cómo funcionan los puntos</h3>
			<div class="mos__msc__desc__cols ds-flex justify-space-between flex-wrap align-center">
				<div class="mos__msc__desc__col">
					<div class="pointCals">
						<h2 class="text-center">GANAR PUNTOS ES MUY FÁCIL</h2>
						<div class="circlenumber">
							<span class="getPoints">S/1</span>
						</div>
						<div class="equalSign">
							<span>=</span>
						</div>
						<div class="circlenumber">
							<span class="getPoints">
								<span>10</span>
								<span>Puntos</span>
							</span>
						</div>
						<div class="desc">
							<p>Por ejemplo, si realiza una compra por 200 soles, obtendrá 2000 puntos.</p>
						</div>
					</div>
				</div>
				<div class="mos__msc__desc__col">
					<div class="items ds-flex justify-center flex-wrap">
						<div class="item">
							<img decoding="async" width="127" height="99" loading="lazy" src="<?php echo home_url('/wp-content/uploads/453364.svg'); ?>" alt="imagen">
							<h3>500 puntos por ser parte de <br>Mosqueira Social Club</h3>
							<p>Le otorgamos automáticamente 500 puntos<br> por unirse a Mosqueira Social Club.</p>
						</div>
						<div class="item">
							<img decoding="async" width="127" height="99" loading="lazy" src="<?php echo home_url('/wp-content/uploads/1346812.svg'); ?>" alt="imagen">
							<h3>50 puntos al completar<br> la encuesta de satisfacción</h3>
							<p>Complete la encuesta de satisfacción<br> de sus compras recientes.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php
	get_footer();
?>
