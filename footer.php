	</main>
	<footer class="mos__footer">
		<div class="mos__footer__top">
			<div class="mos__container">
				<div class="mos__footer__items ds-flex justify-space-between">
					<div class="item">
						<h3>CONTÁCTESE CON NUESTRO EQUIPO</h3>
						<a href="https://api.whatsapp.com/send/?phone=%2B51908900915&text&type=phone_number&app_absent=0" target="_blank">COMUNÍQUESE CON NUESTROS ASESORES DE VENTA</a>
						<p>El equipo de asesores de venta está disponible de lunes a domingo de 09:00 am a 09:00 pm (Perú).</p>
						<div class="mt-30">
							<a href="https://api.whatsapp.com/send/?phone=%2B51908997621&text&type=phone_number&app_absent=0" target="_blank">ENVÍENOS UN MENSAJE VÍA WHATSAPP AL +51 908 997 621</a>
							<p>El equipo de atención al cliente está disponible de lunes a viernes de 08:00 am a 01:00 pm y de 2:00 pm a 6:00 pm y los sábados de 08:00 am a 01:00 pm (Perú).</p>
						</div>
					</div>
					<?php if (has_nav_menu('menu-footer-1')) : ?>
						<div class="item">
							<h3>LEGAL</h3>
							<?php
								$menuFooter = wp_nav_menu(
									array(
										'theme_location' => 'menu-footer-1',
										'menu' => 'menu-footer-1',
										'menu_class' => '',
										'container' => '',
										'depth' => 4,
										'echo' => false,
									)
								);
								echo $menuFooter;
							?>
						</div>
					<?php endif; ?>
					<?php if (has_nav_menu('menu-footer-2')) : ?>
						<div class="item">
							<h3>¿NECESITA AYUDA?</h3>
							<?php
								$menuFooter2 = wp_nav_menu(
									array(
										'theme_location' => 'menu-footer-2',
										'menu' => 'menu-footer-2',
										'menu_class' => '',
										'container' => '',
										'depth' => 4,
										'echo' => false,
									)
								);
								if (is_user_logged_in()) {
									$existing_email = validate_email_newsletter();
									if($existing_email) {
										$static_item = '<li class="menu-item static-item"><a href="'. home_url('unsubscribe') .'">Cancelar suscripción al newsletter</a></li>';
										$menuFooter2 = str_replace('</ul>', $static_item . '</ul>', $menuFooter2);
									}
								}
								echo $menuFooter2;
							?>
						</div>
					<?php endif; ?>
					<?php if (has_nav_menu('menu-footer-3')) : ?>
						<div class="item">
							<h3>EMPRESA</h3>
							<?php
								$menuFooter3 = wp_nav_menu(
									array(
										'theme_location' => 'menu-footer-3',
										'menu' => 'menu-footer-3',
										'menu_class' => '',
										'container' => '',
										'depth' => 4,
										'echo' => false,
									)
								);
								echo $menuFooter3;
							?>
							<ul class="ds-flex align-center mos__footer__items__redes">
								<li>
									<a href="https://www.instagram.com/mosqueira_brand/" target="_blank">
										<img loading="lazy" src="<?php echo IMAGES . 'icon-instagram.svg' ?>" width="25" alt="instagram">
									</a>
								</li>
								<li>
									<a href="https://www.facebook.com/share/1FF8mhqx9s/?mibextid=wwXIfr" target="_blank">
										<img loading="lazy" src="<?php echo IMAGES . 'icon-facebook.svg' ?>" width="25" alt="facebook">
									</a>
								</li>
								<li>
									<a href="https://www.linkedin.com/company/mosqueirabrand/" target="_blank">
										<img loading="lazy" src="<?php echo IMAGES . 'icon-linkedin.svg' ?>" width="25" alt="linkedin">
									</a>
								</li>
								<li>
									<a href="https://www.tiktok.com/@mosqueira_brand?_t=ZS-8z7b3RoDXCE&_r=1" target="_blank">
										<img loading="lazy" src="<?php echo IMAGES . 'icon-tiktok.svg' ?>" width="25" alt="tiktok">
									</a>
								</li>
							</ul>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<div class="mos__footer__bottom">
			<div class="mos__container">
				<p>© 2024 – 2029 Mosqueira & Villa Garcia S.A.C. - Todos los derechos reservados</p>
			</div>
		</div>
	</footer>
<?php wp_footer();?>
</body>
</html>
