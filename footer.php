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
<?php wp_footer();



	global $wpdb;
	$tabla = $wpdb->prefix . 'abandoned_carts';
	$ahora = current_time('mysql');
	$carritos = $wpdb->get_results("
		SELECT * FROM $tabla
		WHERE order_completed = 0
	");
	$headers = [
		'Content-Type: text/html; charset=UTF-8',
		'From: Mosqueira <mosqueiraonline@mosqueira.com.pe>',
	];
	$subject = '¿Olvidaste tu carrito?';

	var_dump($ahora);


	

	foreach ($carritos as $c) {

		$abandoned_at = strtotime($c->abandoned_at);
		$first_sent   = $c->first_email_sent ? strtotime($c->first_email_sent) : null;
		$to = "davis.v14@gmail.com";
		$user_id = $c->user_id;
		
		$name= "";
		if ( $user_id ) {			
			if(get_user_meta($user_id, 'billing_first_name', true)){
				$name=get_user_meta($user_id, 'billing_first_name', true);
			}else{
				$user = get_userdata( $user_id ); // Objeto WP_User
				$name=$user->first_name;				
			}
		}

		ob_start();
		include( get_stylesheet_directory() . '/woocommerce/emails/email-abandoned-cart.php' );
		$email_content = ob_get_contents();
		ob_end_clean();

		wp_mail($to, $subject, $email_content, $headers);

		//echo "<pre>"

	//	var_dump($cart);

		// Primer correo
		//if (!$first_sent && time() - $abandoned_at >= 2 * HOUR_IN_SECONDS) {
		//	ob_start();
		//	include( get_stylesheet_directory() . '/woocommerce/emails/email-abandoned-cart.php' );
		//	$email_content = ob_get_contents();
		//	ob_end_clean();

		//	wp_mail($to, $subject, $email_content, $headers);
		//	$wpdb->update($tabla, ['first_email_sent' => $ahora], ['id' => $c->id]);
		//}

		// Segundo correo
		/*if ($first_sent && !$c->second_email_sent && time() - $first_sent >= 24 * HOUR_IN_SECONDS) {
			ob_start();
			include( get_stylesheet_directory() . '/woocommerce/emails/email-abandoned-cart.php' );
			$email_content_2 = ob_get_contents();
			ob_end_clean();

			wp_mail($to, $subject, $email_content_2, $headers);
			$wpdb->update($tabla, ['second_email_sent' => $ahora], ['id' => $c->id]);
		}*/
	}

			$cart = maybe_unserialize('a:3:{s:32:"6d152b58c9f9579730f3c24b31b6c40a";a:12:{s:3:"key";s:32:"6d152b58c9f9579730f3c24b31b6c40a";s:10:"product_id";i:766;s:12:"variation_id";i:767;s:9:"variation";a:1:{s:18:"attribute_pa_talla";s:2:"xs";}s:8:"quantity";i:1;s:9:"data_hash";s:32:"31669b53b1ea407f9f7ca3432422a619";s:13:"line_tax_data";a:2:{s:8:"subtotal";a:0:{}s:5:"total";a:0:{}}s:13:"line_subtotal";d:79.9;s:17:"line_subtotal_tax";d:0;s:10:"line_total";d:79.9;s:8:"line_tax";d:0;s:4:"data";O:20:"WC_Product_Variation":1:{s:5:"*id";i:767;}}s:32:"3d218ce1b50d7a04a09049fd0feeb6c0";a:13:{s:8:"pa_color";s:5:"Negro";s:3:"key";s:32:"3d218ce1b50d7a04a09049fd0feeb6c0";s:10:"product_id";i:371;s:12:"variation_id";i:441;s:9:"variation";a:1:{s:18:"attribute_pa_talla";s:1:"m";}s:8:"quantity";i:1;s:9:"data_hash";s:32:"408ceed4886e559115472bfa7becf60e";s:13:"line_tax_data";a:2:{s:8:"subtotal";a:0:{}s:5:"total";a:0:{}}s:13:"line_subtotal";d:100;s:17:"line_subtotal_tax";d:0;s:10:"line_total";d:100;s:8:"line_tax";d:0;s:4:"data";O:20:"WC_Product_Variation":1:{s:5:"*id";i:441;}}s:32:"20ca583cf4c1439e0be2a2402aafafd3";a:7:{s:3:"key";s:32:"20ca583cf4c1439e0be2a2402aafafd3";s:10:"product_id";i:601;s:12:"variation_id";i:602;s:9:"variation";a:1:{s:18:"attribute_pa_talla";s:1:"s";}s:8:"quantity";i:1;s:4:"data";O:20:"WC_Product_Variation":1:{s:5:"*id";i:602;}s:9:"data_hash";s:32:"a5b5fa1d764b6f94572eaf1a6bdbd81d";}}');

			var_dump($cart);

?>

  	<table align="center" width="100%" bgcolor="#ffffff" style="max-width:600px;" border="0" cellspacing="0" cellpadding="0">
 <tr>
			<td>
           <table width="400" cellspacing="0" cellpadding="4" border="0" style="border-collapse: collapse;margin: 0 auto;">          
            <tbody>
              <?php
              foreach ($cart as $item_key => $item) {
                  $product_id = $item['product_id'];
                  $variation_id = $item['variation_id'];
                  $quantity = $item['quantity'];
                  // Obtener producto correcto (variación o simple)
                  $product = $variation_id ? wc_get_product($variation_id) : wc_get_product($product_id);
                  if (!$product) continue;
                  $image = $product->get_image('thumbnail');
                  $title = $product->get_name();
                  $price = wc_price($product->get_price());
				          $image_url = wp_get_attachment_image_url($product->get_image_id(), 'thumbnail'); ?>
                <tr>
                  <td style="text-align:center;"><img width="60" style="display: block" src="<?php echo $image_url; ?>"/></td>
                  <td style="text-align:center;"><b style="color: black;font-size: 12px"><?php echo esc_html($title); ?></b></td>
                  <td style="text-align:center;"><b style="color: black;font-size: 12px"><?php echo $price; ?></b></td>        
                </tr>	
              <?php } ?>
                <tr>
                  <td style="text-align:center;"></td>
                  <td style="text-align:center;"></td>
                  <td style="text-align:center;"><a style="border: 1px solid black;padding: 2px 0px;display: block;width: 94px;border-radius: 2px;font-size: 12px; margin: 0 auto;white-space: nowrap;color:black;font-weight: bold;text-decoration: none;" href="<?php echo home_url('carrito'); ?>" target="_blank" >Comprar ahora</a></td>        
                </tr>
                
            </tbody>
          </table>
      </td>
    </tr>
			  </table>

</body>
</html>
