<?php
/**
 * My Account page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

//defined( 'ABSPATH' ) || exit;

/**
 * My Account navigation.
 *
 * @since 2.6.0
 */
//do_action( 'woocommerce_account_navigation' ); ?>
<?php
	$current_user = wp_get_current_user();
	$nombre = $current_user->first_name;
	$apellido = $current_user->last_name;
?>
<div class="woocommerce-MyAccount-content">
	<?php
		/**
		 * My Account content.
		 *
		 * @since 2.6.0
		 */
		//do_action( 'woocommerce_account_content' );
	?>
</div>
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
				<a href="<?php echo home_url('mi-cuenta/mosqueira-social-club'); ?>">Mosqueira Social Club</a>
			</li>
		</ul>
		<div class="mos__account__current">
			<div class="ds-flex justify-space-between align-center">
				<h1 class="mos__account__current__title">
					<span>Bienvenido/a</span><br>
					<?php echo $nombre; ?> <?php echo $apellido; ?>
				</h1>
				<img width="435" height="433" src="<?php echo IMAGES . 'img-perfil.webp'; ?>" alt="perfil">
			</div>
		</div>
	</div>
</section>
