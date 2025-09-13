<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.4.0
 */

defined( 'ABSPATH' ) || exit;
do_action( 'woocommerce_before_mini_cart' );

?>
<?php
	$pathCart = get_stylesheet_directory() . '/partials/cart/cart.php';
	if ( file_exists($pathCart) ) {
		include $pathCart;
	}
?>
<?php do_action( 'woocommerce_after_mini_cart' ); ?>
