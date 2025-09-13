<?php
//date_default_timezone_set('America/Lima');
require_once trailingslashit(get_stylesheet_directory()) . 'inc/defines.php';
require_once trailingslashit(get_stylesheet_directory()) . 'inc/mix.php';
require_once trailingslashit(get_stylesheet_directory()) . 'functions-config.php';
require_once trailingslashit(get_stylesheet_directory()) . 'inc/assets.php';
require_once trailingslashit(get_stylesheet_directory()) . 'inc/helpers.php';
require_once trailingslashit(get_stylesheet_directory()) . 'inc/mos.php';

// Required class Actions
require_once trailingslashit(get_stylesheet_directory()) . 'inc/actions/support-woocommerce.php';
require_once trailingslashit(get_stylesheet_directory()) . 'inc/actions/wcMsc.php';
require_once trailingslashit(get_stylesheet_directory()) . 'inc/actions/registerUser.php';
require_once trailingslashit(get_stylesheet_directory()) . 'inc/actions/loginUser.php';
require_once trailingslashit(get_stylesheet_directory()) . 'inc/actions/emailsProcess.php';
require_once trailingslashit(get_stylesheet_directory()) . 'inc/actions/abandonedCart.php';
require_once trailingslashit(get_stylesheet_directory()) . 'inc/actions/password.php';
require_once trailingslashit(get_stylesheet_directory()) . 'inc/actions/updateUser.php';
require_once trailingslashit(get_stylesheet_directory()) . 'inc/actions/updateAddress.php';
require_once trailingslashit(get_stylesheet_directory()) . 'inc/actions/filterProducts.php';
require_once trailingslashit(get_stylesheet_directory()) . 'inc/actions/newsletter.php';
require_once trailingslashit(get_stylesheet_directory()) . 'inc/actions/wcAddToCart.php';
require_once trailingslashit(get_stylesheet_directory()) . 'inc/actions/wcBillingDelivery.php';
require_once trailingslashit(get_stylesheet_directory()) . 'inc/actions/productSale.php';
//require_once trailingslashit(get_stylesheet_directory()) . 'inc/actions/wsProductWishlist.php';
//require_once trailingslashit(get_stylesheet_directory()) . 'inc/actions/booking.php';
require_once trailingslashit(get_stylesheet_directory()) . 'inc/actions/admin.php';
require_once trailingslashit(get_stylesheet_directory()) . 'inc/actions/wcSearchProduct.php';
require_once trailingslashit(get_stylesheet_directory()) . 'inc/actions/wpMenu.php';
require_once trailingslashit(get_stylesheet_directory()) . 'inc/actions/wpQuiz.php';
require_once trailingslashit(get_stylesheet_directory()) . 'inc/actions/libroLrq.php';

require_once trailingslashit(get_stylesheet_directory()) . 'inc/theme-support.php';

$mos = new Mos();
