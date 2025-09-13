<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=11,IE=10,IE=9,IE=edge"/>
  <meta charset="<?php bloginfo('charset'); ?>"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5, user-scalable=yes">
  <title><?php the_title(); ?></title>
	<link rel="icon" type="image/x-icon" href="<?php echo IMAGES . 'favicon.ico'; ?>">
  <?php
		$is_logged_in = is_user_logged_in();
		$home_url = home_url();
		$headerData = get_header_data();
		$products = $headerData['products_total_sales'];
		$modalPromo = $headerData['modal_promo'];
		$cartEmpty = WC()->cart->is_empty();
		$cartCount = wc()->cart->get_cart_contents_count();
		$classCartEmpty = $cartEmpty ? 'cart-empty' : '';

		$nombre   = isset($_GET['nombre'])   ? sanitize_text_field($_GET['nombre'])   : '';
		$apellido = isset($_GET['apellido']) ? sanitize_text_field($_GET['apellido']) : '';
		$correo   = isset($_GET['correo'])   ? sanitize_email($_GET['correo'])        : '';


		wp_head();
	?>
</head>
<body <?php body_class(); ?>>
<header class="mos__header <?php echo !is_front_page() ? 'active' : ''; ?>">
	<?php if($headerData['messages']):
		$items = $headerData['messages']['items'];
	?>
		<div class="mos__header__top">
			<div class="mos__header__top__slider">
				<?php foreach( $items as $item ):
					$content = $item['acf_option_message'];
				?>
					<div class="mos__header__top__slide">
						<?php echo $content; ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endif; ?>
	<div class="mos__header__bottom">
		<div class="mos__header__principal">
			<div class="mos__container">
				<div class="ds-flex justify-space-between align-center">
					<button class="js-modal-trigger mos__header__contact" data-modal-target="mos-modal-contact" aria-label="Contactar con un asesor">
						Contactar con un asesor
					</button>
					<?php
						if ( has_custom_logo() ):
							the_custom_logo();
						else:
							echo '<a href="' . esc_url( $home_url ) . '">'. get_bloginfo('name') . '</a>';
						endif;
					?>
					<ul class="ds-flex align-center">
						<li>
							<button class="js-modal-trigger relative" aria-label="Mi Carrito" data-modal-target="mos-modal-carrito">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" >
									<path d="M18.0002 7H15.7502V5.75C15.7502 4.79 14.9702 4 14.0002 4H9.99023C9.03023 4 8.24023
										4.78 8.24023 5.75V7H5.99023C4.89023 7 3.99023 7.89 3.99023 9V18C3.99023 19.1 4.88023 20
										5.99023 20H17.9902C19.0902 20 19.9902 19.11 19.9902 18V9C19.9902 7.9 19.1002 7 17.9902
										7H18.0002ZM9.75023 5.75C9.75023 5.61 9.86023 5.5 10.0002 5.5H14.0102C14.1502 5.5 14.2602
										5.61 14.2602 5.75V7H9.76023V5.75H9.75023ZM18.5002 18.01C18.5002 18.28 18.2802 18.51 18.0002
										18.51H6.00023C5.73023 18.51 5.50023 18.29 5.50023 18.01V9.01C5.50023 8.74 5.72023 8.51 6.00023
										8.51H8.25023V10.01H9.75023V8.51H14.2502V10.01H15.7502V8.51H18.0002C18.2702 8.51 18.5002 8.73
										18.5002 9.01V18.01Z" fill="#fff"></path>
								</svg>
								<span class="cart-count <?php echo $cartCount > 0 ? '' : 'hidden' ?>"><?php echo $cartCount; ?></span>
							</button>
						</li>
						<li>
							<button class="js-modal-trigger" data-modal-target="mos-modal-search" aria-label="search">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
									<path d="M20 12C20 7.58 16.42 4 12 4C7.58 4 4 7.58 4 12C4 16.42 7.58 20 12 20C13.94 20 15.72 19.31 17.1 18.16L18.94 20L20 18.94L18.16 17.1C19.31 15.72 20 13.94 20 12ZM12 18.5C8.42 18.5 5.5 15.58 5.5 12C5.5 8.42 8.42 5.5 12 5.5C15.58 5.5 18.5 8.42 18.5 12C18.5 15.58 15.58 18.5 12 18.5Z" fill="#fff"></path>
								</svg>
							</button>
						</li>
						<li>
							<?php if (!$is_logged_in) : ?>
							<button aria-label="mi cuenta" class="js-modal-trigger" data-modal-target="mos-modal-account">
							<?php else : ?>
							<a href="<?php echo esc_url ($home_url . '/mi-cuenta'); ?>" area-label="mi cuenta">
							<?php endif; ?>
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
									<path class="_no-logged_1toe5_4" d="M12 14C14.76 14 17 11.76 17 9C17 6.24 14.76 4 12 4C9.24 4 7 6.24 7 9C7 11.76 9.24 14 12 14ZM12 5.5C13.93 5.5 15.5 7.07 15.5 9C15.5 10.93 13.93 12.5 12 12.5C10.07 12.5 8.5 10.93 8.5 9C8.5 7.07 10.07 5.5 12 5.5ZM18.75 18V20H17.25V18C17.25 17.31 16.69 16.75 16 16.75H8C7.31 16.75 6.75 17.31 6.75 18V20H5.25V18C5.25 16.48 6.48 15.25 8 15.25H16C17.52 15.25 18.75 16.48 18.75 18Z" fill="#fff"></path>
								</svg>
							</a>
							<?php if (!$is_logged_in) : ?>
								</button>
							<?php else : ?>
							</a>
							<?php endif; ?>
						</li>
						<li class="menu-mobile">
							<button class="js-open-menu" aria-label="menu">
								<img class="menu-mobile-burger" width="24" height="15" src="<?php echo IMAGES . 'icon-hamburger.svg' ?>" alt="hamburger">
								<img class="menu-mobile-close" width="21" height="24" src="<?php echo IMAGES . 'icon-close-menu.svg' ?>" alt="close">
							</button>
						</li>
						<?php if ($is_logged_in) : ?>
							<li>
								<a href="<?php echo wp_logout_url('/'); ?>" area-label="cerrar sesión">
									<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M5.32336 5.0872C4.44047 5.28934 3.3878 6.20426 3.13878 6.99152C2.94636 7.57665 2.95768 17.4493 3.1501 17.9387C3.39912 18.577 3.96507 19.1834 4.59894 19.5132C5.19885 19.8324 5.24412 19.8324 7.1344 19.8643C8.96808 19.8962 9.08127 19.8962 9.37557 19.6728C9.79437 19.3643 9.80569 18.8217 9.38689 18.5132C9.11523 18.311 8.93413 18.2898 7.39474 18.2898C5.54974 18.2898 5.24412 18.2153 4.85928 17.6834C4.65553 17.3961 4.64421 17.1195 4.64421 12.4385C4.64421 7.7575 4.65553 7.4809 4.85928 7.19366C5.24412 6.66172 5.54974 6.58725 7.39474 6.58725C8.93413 6.58725 9.11523 6.56598 9.38689 6.36384C9.60195 6.20426 9.68118 6.04468 9.68118 5.78935C9.68118 5.53403 9.60195 5.37445 9.38689 5.21487C9.10391 5.01273 8.94545 4.99146 7.3721 5.00209C6.43262 5.01273 5.51578 5.04465 5.32336 5.0872Z" fill="white"/>
										<path d="M15.1368 7.65098C14.9783 7.78929 14.8878 8.00206 14.8878 8.21483C14.8878 8.51272 15.0915 8.74677 16.4724 10.0447C17.344 10.8639 18.0571 11.566 18.0571 11.6086C18.0571 11.6618 16.0423 11.6937 13.5861 11.6937C9.2622 11.6937 9.10373 11.7043 8.88867 11.9064C8.58305 12.1937 8.59437 12.7682 8.89999 13.0341C9.12637 13.2256 9.39803 13.2363 13.62 13.2682L18.091 13.3001L16.4951 14.8214C15.0349 16.1938 14.8878 16.3747 14.8878 16.7151C14.8878 17.1726 15.2047 17.4705 15.6914 17.4705C15.9857 17.4705 16.3705 17.1619 18.5212 15.1406C20.8076 12.9916 21 12.7788 21 12.4384C21 12.0979 20.8076 11.8852 18.5325 9.75744C16.4158 7.76801 16.0083 7.43821 15.7254 7.43821C15.5329 7.43821 15.2726 7.53396 15.1368 7.65098Z" fill="white"/>
									</svg>
								</a>
							</li>
						<?php endif; ?>
						<?php /*
						<?php if($is_logged_in) : ?>
							<li>
								<a href="<?php echo esc_url( $home_url . '/lista-de-deseos') ?>">
									<svg width="38" height="23" viewBox="0 0 38 23" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M9.87298 11.8027C7.27189 8.6661 10.478 4.10317 14.3106 5.48716L17.1773 6.52235C18.0334 6.83151 18.9694 6.83942 19.8306 6.54479L23.2908 5.36104C27.1689 4.03434 30.2956 8.70496 27.5913 11.7849L20.1476 20.2625C19.736 20.7313 19.1424 21 18.5185 21V21C17.8733 21 17.2617 20.7126 16.8498 20.216L9.87298 11.8027Z" style="fill:transparent" />
										<path d="M28.2606 4.74853C25.9415 2.41774 22.1809 2.41774 19.8606 4.74853L18.4997 6.11622L17.1389 4.74853C14.8191 2.41716 11.0585 2.41716 8.73936 4.74853C6.42021 7.07932 6.42021 10.8588 8.73936 13.1908L10.1002 14.5585L18.4997 23.0007L26.8998 14.5585L28.2606 13.1908C30.5798 10.8594 30.5798 7.0799 28.2606 4.74853ZM26.6196 11.5421L18.4997 19.7028L10.3798 11.5415C8.96907 10.1231 8.96907 7.81563 10.3798 6.39722C11.0631 5.71046 11.9721 5.3321 12.9385 5.3321C13.9049 5.3321 14.8145 5.71046 15.4984 6.3978L18.4997 9.41418L21.5016 6.39722C22.1849 5.71046 23.0945 5.3321 24.0609 5.3321C25.0273 5.3321 25.9363 5.71046 26.6196 6.39722C28.0304 7.81505 28.0304 10.1231 26.6196 11.5415V11.5421Z" fill="#000"/>
									</svg>
								</a>
							</li>
						<?php endif; ?>
						*/ ?>
					</ul>
				</div>
			</div>
		</div>
		<div class="mos__header__nav">
			<div class="mos__container">
				<?php
					if(!empty($headerData['menu'])) :
					$class = !empty($menu['sub_menu']) ? 'menu-item-has-children' : '';
					$subMenuClassic = !empty($menu['products']) ? '' : 'submenu--classic';
				?>
					<ul class="mos__header__menu ds-flex align-center justify-center">
					<?php
						foreach ($headerData['menu'] as $menu ) :
						$class = !empty($menu['sub_menu']) ? 'menu-item-has-children' : '';
						$subMenuClassic = !empty($menu['products']) ? '' : 'submenu--classic';
						$link = $menu['url'];
						if($is_logged_in) {
							if( $menu['title'] === 'Mosqueira Social Club' ) {
								$link = $home_url . '/mi-cuenta/mosqueira-social-club/';
							}
						}
					?>
						<li class="<?php echo $class; ?> <?php echo $subMenuClassic; ?>">
							<a class="menu-item-has-children-a" href="<?php echo $link; ?>" target="<?php echo $menu['target']; ?>">
								<?php echo $menu['title']; ?>
								<?php if(!empty($class)) : ?>
									<svg width="7" height="14" viewBox="0 0 7 14" fill="none" xmlns="http://www.w3.org/2000/svg">
										<g clip-path="url(#clip0_3754_25)">
											<path d="M1 13L6 7L1 1" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
										</g>
										<defs>
											<clipPath id="clip0_3754_25">
												<rect width="7" height="14" fill="white"/>
											</clipPath>
										</defs>
									</svg>
								<?php else: ?>
										<svg width="7" height="14" viewBox="0 0 7 14" fill="none" xmlns="http://www.w3.org/2000/svg">
										<g clip-path="url(#clip0_3754_25)">
											<path d="M1 13L6 7L1 1" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
										</g>
										<defs>
											<clipPath id="clip0_3754_25">
												<rect width="7" height="14" fill="white"/>
											</clipPath>
										</defs>
									</svg>
								<?php endif; ?>
							</a>
							<?php if(!empty($class)) : ?>
								<div class="mos__header__menu__full">
									<div class="mos__container">
										<div class="ds-flex justify-space-between flex-wrap">
											<button class="prev-menu-full">
												<img loading="lazy" width="12" height="24" src="<?php echo IMAGES . 'icon-prev.svg'; ?>" alt="PREV">
											</button>
											<ul class="menu-categories">
												<?php foreach ($menu['sub_menu'] as $submenu ) :
												?>
													<li class="<?php echo $submenu['classes']; ?>">
														<a href="<?php echo $submenu['url']; ?>" target="<?php echo $submenu['target']; ?>">
															<?php echo $submenu['title']; ?>
														</a>
													</li>
												<?php endforeach; ?>
											</ul>
											<?php
												if (isset($menu['products']) && !empty($menu['products']['products'])) :
												$title = $menu['products']['title'];
											?>
												<div class="menu-gallery">
													<h3><?php echo $title; ?></h3>
													<?php if($menu['products']) : ?>
														<?php if($menu['products']['products']) :
														?>
															<ul class="ds-grid ds-grid__gap20 ds-grid__col4">
																<?php foreach( $menu['products']['products'] as $item ):
																	$id = $item->ID;
																	$title = get_the_title($id);
																	$link = get_the_permalink($id);
																	$img = get_the_post_thumbnail( $id, 'medium', [
																		'alt' => $title,
																		//'loading' => 'lazy'
																	]);
																	setup_postdata($item);
																?>
																	<?php if(!empty($img)) : ?>
																		<li>
																			<a href="<?php echo esc_url($link); ?>">
																				<?php echo $img; ?>
																			</a>
																		</li>
																	<?php endif; ?>
																<?php endforeach; ?>
															</ul>
														<?php wp_reset_postdata(); endif; ?>
													<?php endif; ?>
												</div>
											<?php endif; ?>
										</div>
									</div>
								</div>
							<?php endif; ?>
						</li>
					<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
		</div>
	</div>
</header>
<main>
<div id="mos-modal-search" class="mos__modal mos__modal--top-to-bottom">
	<div class="mos__modal__container">
		<button class="mos__modal__close">
			<img width="15" height="15" src="<?php echo IMAGES . 'icon-close.svg'; ?>" alt="cerrar">
		</button>
		<img loading="lazy" width="282" height="42" src="<?php echo IMAGES . 'logo-blue.svg'; ?>" alt="Mosqueira" class="logo-search m-auto">
		<div class="form-input mt-30">
			<input id="mos-search" type="text" placeholder="Buscar...">
		</div>
		<div class="mos__container">
			<h2 class="title-search">Productos más vendidos</h2>
		</div>
		<div class="relative">
			<div id="mos-result-search-products" class="items-search ds-grid ds-grid__col5">
				<?php	foreach ( $products as $product ) : ?>
					<?php
						$pathContentProduct = get_stylesheet_directory() . '/partials/product/product-item.php';
						if ( file_exists($pathContentProduct) ) {
							include $pathContentProduct;
						}
					?>
				<?php endforeach; ?>
			</div>
			<button id="mos-load-search" class="mos__btn mos__btn--primary mt-auto-30 ds-block" style="display: none;">
				MOSTRAR MÁS
			</button>
		</div>
		<div class="ds-flex justify-center items-search__footer">
			<p class="text-center">Servicio de atención al cliente disponible, en el <a href="https://api.whatsapp.com/send/?phone=%2B51908997621&text&type=phone_number&app_absent=0" target="_blank">+51 908997621</a><a href="<?php echo home_url('preguntas-frecuentes'); ?>">Preguntas frecuentes</a></p>
		</div>
	</div>
	<div class="mos__modal__bg"></div>
</div>
<div id="mos-modal-contact" class="mos__modal mos__modal--left-to-right">
	<div class="mos__modal__container mos__modal--sidebar">
		<div class="mos__modal__header ds-flex justify-space-between">
			<h2>Contactar con un asesor</h2>
			<button class="mos__modal__close">
				<img width="15" height="15" src="<?php echo IMAGES . 'icon-close.svg'; ?>" alt="cerrar">
			</button>
		</div>
		<div class="mos__modal__content">
			<p>Los asesores de Mosqueira estarán a su disposición ante cualquier consulta.</p>
			<ul class="socials">
				<li class="ds-flex align-center">
					<img width="20" height="20" src="<?php echo IMAGES . 'icon-phone.svg'; ?>" alt="cerrar">
					<a href="tel:+51 908 900 915">+51 908 900 915</a>
				</li>
				<li class="ds-flex align-center">
					<img width="20" height="20" src="<?php echo IMAGES . 'icon-whatsapp.svg'; ?>" alt="cerrar">
					<a href="https://api.whatsapp.com/send/?phone=%2B51908900915&text&type=phone_number&app_absent=0" target="_blank">Whatsapp</a>
				</li>
				<li class="ds-flex align-center">
					<img width="20" height="20" src="<?php echo IMAGES . 'icon-instagram.svg'; ?>" alt="cerrar">
					<a href="https://www.instagram.com/mosqueira_brand" target="_blank">Instagram</a>
				</li>
				<li class="ds-flex align-center">
					<img width="20" height="20" src="<?php echo IMAGES . 'icon-email.svg'; ?>" alt="cerrar">
					<a href="mailto:ventapersonalizada@mosqueira.com.pe" target="_blank">Enviar un correo</a>
				</li>
			</ul>
			<a href="<?php echo home_url('preguntas-frecuentes'); ?>">Preguntas frecuentes</a>
		</div>
	</div>
	<div class="mos__modal__bg"></div>
</div>
<div id="mos-modal-subscribe" class="mos__modal mos__modal--right-to-left">
	<div class="mos__modal__container mos__modal--sidebar m-right">
		<div class="mos__modal__header ds-flex justify-space-between">
			<h2>Manténgase al día con la Newsletter de Mosqueira</h2>
			<button class="mos__modal__close">
				<img width="15" height="15" src="<?php echo IMAGES . 'icon-close.svg'; ?>" alt="cerrar">
			</button>
		</div>
		<div class="mos__modal__content">
			<p>Reciba en su correo las últimas novedades, eventos exclusivos y contenido personalizado según sus intereses.</p>
			<small>Al suscribirse, confirma haber leído y aceptado nuestra <a href="<?php echo home_url('politica-de-privacidad'); ?>">Política de Privacidad</a>, y autoriza el envío de comunicaciones sobre colecciones, servicios y experiencias de Mosqueira.</small>
			<form id="mos-form-newsletter" action="">
				<div class="form-input mt-50">
					<label for="email-sub">CORREO ELECTRONICO</label>
					<input type="email" id="email-newsletter" name="email-newsletter" placeholder="Ingrese su correo electronico">
				</div>
				<button id="mos-form-newsletter-btn" class="mos__btn mos__btn--primary mt-20">SUSCRIBIRSE</button>
				<div id="mos-form-newsletter-message"></div>
			</form>
		</div>
	</div>
	<div class="mos__modal__bg"></div>
</div>
<div id="mos-modal-account" class="mos__modal mos__modal--right-to-left">
	<div class="mos__modal__container mos__modal--sidebar m-right">
		<div class="mos__modal__header ds-flex justify-space-between">
			<h2>Acceder</h2>
			<button class="mos__modal__close">
				<img width="15" height="15" src="<?php echo IMAGES . 'icon-close.svg'; ?>" alt="cerrar">
			</button>
		</div>
		<div class="mos__modal__content">
			<form id="mos-form-login" action="">
				<div class="form-input mt-50">
					<label for="email-login">CORREO ELECTRONICO</label>
					<input type="email" id="email-login" name="email-login" placeholder="Ingrese su correo electronico" autocomplete="off">
				</div>
				<div class="form-input mt-20">
					<label for="password-login">CONTRASEÑA</label>
					<input type="password" id="password-login" name="password-login" placeholder="Ingrese su contraseña" autocomplete="off">
				</div>
				<div class="form-input mt-20">
					<label class="mos-checkbox">
						<span class="mos-checkbox__text">Acuérdese de mí</span>
						<input type="checkbox" id="remember-login" name="remember-login">
						<span class="mos-checkbox__checkmark"></span>
					</label>
				</div>
				<div class="ds-flex justify-center align-center flex-wrap mt-50">
					<button id="mos-form-login-btn" class="mos__btn mos__btn--transparent ">INICIAR SESIÓN</button>
					<button data-modal-target="mos-modal-account-password" class="mos__btn mos__btn--text js-modal-trigger">Olvidé la contraseña</button>
				</div>
				<div id="mos-form-login-message"></div>
			</form>
			<h2 class="mt-50">Crear una cuenta</h2>
			<ul>
				<li>Guarde su información de contacto para facilitar el proceso de compra</li>
				<li>Compruebe el estado de su pedido</li>
				<li>Disfrute los beneficios de Mosqueira Social Club</li>
			</ul>
			<button data-modal-target="mos-modal-account-create" class="js-modal-trigger mos__btn mos__btn--primary mt-20">CREAR UNA CUENTA</button>
		</div>
	</div>
	<div class="mos__modal__bg"></div>
</div>
<div id="mos-modal-account-create" class="mos__modal mos__modal--right-to-left">
	<div class="mos__modal__container mos__modal--sidebar m-right">
		<div class="mos__modal__header ds-flex justify-space-between">
			<h2>Crear una cuenta</h2>
			<button class="mos__modal__close">
				<img width="15" height="15" src="<?php echo IMAGES . 'icon-close.svg'; ?>" alt="cerrar">
			</button>
		</div>
		<div class="mos__modal__content">
			<form id="mos-form-register" action="">
				<div class="form-input mt-20">
					<label for="name-create">NOMBRES</label>
					<input type="text" id="name-create" name="name-create" placeholder="Ingrese tu nombre" value="<?php echo esc_attr($nombre); ?>">
				</div>
				<div class="form-input mt-20">
					<label for="lastname-create">APELLIDOS</label>
					<input type="text" id="lastname-create" name="lastname-create" placeholder="Ingrese tu apellido" value="<?php echo esc_attr($apellido); ?>">
				</div>
				<div class="form-input mt-20">
					<label for="email-create">CORREO ELECTRONICO</label>
					<input type="email" id="email-create" name="email-create" placeholder="Ingrese su correo electronico" value="<?php echo esc_attr($correo); ?>">
				</div>
				<div class="form-input mt-20">
					<label for="password-create">CONTRASEÑA</label>
					<input type="password" id="password-create" name="password-create" placeholder="Ingrese su contraseña" autocomplete="off">
				</div>
				<div class="form-input mt-20">
					<label for="genero-create">¿Cuál es su género?</label>
					<select name="genero-create" id="genero-create">
						<option value="">Seleccione un género</option>
						<option value="Mujer">Mujer</option>
						<option value="Hombre">Hombre</option>
					</select>
				</div>
				<div class="form-input mt-40">
					<label class="mos-checkbox">
						<span class="mos-checkbox__text">Suscríbase al newsletter de Mosqueira para recibir las últimas novedades</span>
						<input type="checkbox" id="subscribe-create" name="subscribe-create">
						<span class="mos-checkbox__checkmark"></span>
					</label>
				</div>
				<div class="form-input mt-20">
					<label class="mos-checkbox">
						<span class="mos-checkbox__text">Al crear una cuenta acepta nuestros <a target="_blank" href="<?php echo $home_url . '/terminos-y-condiciones'; ?>">términos y condiciones</a>, y confirma que ha leído nuestra <a target="_blank" href="<?php echo $home_url . '/politica-de-privacidad'; ?>">política de privacidad</a></span>
						<input type="checkbox" id="term-cond-create" name="term-cond-create">
						<span class="mos-checkbox__checkmark"></span>
					</label>
				</div>
				<div class="ds-flex justify-center align-center flex-wrap mt-50">
					<input type="hidden" id="nickname-create" name="nickname-create">
					<button id="mos-form-create-btn" class="mos__btn mos__btn--primary">CREAR CUENTA</button>
					<button data-modal-target="mos-modal-account" class="mos__btn mos__btn--text js-modal-trigger">Ya tengo una cuenta</button>
				</div>
				<div id="mos-form-create-message" class="text-center mt-20"></div>
			</form>
		</div>
	</div>
	<div class="mos__modal__bg"></div>
</div>
<div id="mos-modal-account-password" class="mos__modal mos__modal--right-to-left">
	<div class="mos__modal__container mos__modal--sidebar m-right">
		<div class="mos__modal__header ds-flex justify-space-between">
			<h2>Olvidé la contraseña</h2>
			<button class="mos__modal__close">
				<img width="15" height="15" src="<?php echo IMAGES . 'icon-close.svg'; ?>" alt="cerrar">
			</button>
		</div>
		<div class="mos__modal__content">
			<form id="mos-form-password" action="">
				<div class="form-input mt-50">
					<label for="email-password">CORREO ELECTRONICO</label>
					<input type="email" id="email-password" name="email-password" placeholder="Ingrese su correo electronico" autocomplete="off">
				</div>
				<button id="mos-form-password-btn" class="mt-40 mos__btn mos__btn--transparent upper">Obtener una contraseña nueva</button>
				<div id="mos-form-password-message" class="mt-20"></div>
			</form>
		</div>
	</div>
	<div class="mos__modal__bg"></div>
</div>
<div id="mos-modal-carrito" class="mos__modal mos__modal--right-to-left <?php echo $classCartEmpty; ?>">
	<div class="mos__modal__container mos__modal--sidebar m-right">
		<div class="mos__modal__header ds-flex justify-space-between">
			<h2>Bolsa de compras</h2>
			<button class="mos__modal__close">
				<img width="15" height="15" src="<?php echo IMAGES . 'icon-close.svg'; ?>" alt="cerrar">
			</button>
		</div>
		<div id="mos-carrito-result" class="mos__modal__content">
			<?php
				$pathCart = get_stylesheet_directory() . '/partials/cart/cart.php';
				if ( file_exists($pathCart) ) {
					include $pathCart;
				}
			?>
		</div>
	</div>
	<div class="mos__modal__bg"></div>
</div>
<?php if (
	$modalPromo &&
	!isset($_COOKIE['modalPromoClosed']) &&
	!$is_logged_in
) : ?>
	<div id="mos-modal-discount" class="mos__modal">
		<div class="mos__modal__container ds-flex align-start">
			<img fetchPriority="high" src="<?php echo $modalPromo['image']; ?>" alt="Descuento" width="382" height="359">
			<div class="mos__modal__discount">
				<div class="mos__modal__header">
					<div class="ds-flex justify-space-between align-start relative">
						<div>
							<?php echo $modalPromo['title']; ?>
						</div>
						<button class="mos__modal__close">
							<img width="15" height="15" src="<?php echo IMAGES . 'icon-close.svg'; ?>" alt="cerrar">
						</button>
					</div>
				</div>
				<div class="mos__modal__content">
					<?php echo $modalPromo['desc']; ?>
					<button class="mos__btn mos__btn--primary js-modal-trigger" data-modal-target="mos-modal-account-create">CREAR CUENTA</button>
				</div>
			</div>
		</div>
		<div class="mos__modal__bg"></div>
	</div>
<?php endif; ?>
