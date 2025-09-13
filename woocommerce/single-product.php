<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function add_css_js() {
	wp_register_style( 'style-single-product', mix('assets/css/single-product.css'), [], false );
	wp_enqueue_style( 'style-single-product' );

	wp_register_script( 'script-single-product', mix('assets/js/single-product.js'), [], false, true );
	wp_enqueue_script( 'script-single-product' );
}
add_action('wp_enqueue_scripts', 'add_css_js');

get_header();
$current_product_id = $product->get_id();
$poster = get_the_post_thumbnail_url($current_product_id, 'large');
$type_product = $product->get_type();
$attributes = $product->get_attributes();
$attachment_ids = $product->get_gallery_image_ids();
//$precio_regular = $product->get_regular_price();
//$precio_descuento = $product->get_sale_price();
$precio_actual = $product->get_price();
$moneda_simbolo = get_woocommerce_currency_symbol();
$available_variations = $product->get_available_variations();

$product = wc_get_product( get_the_ID() );
$cross_sells = $product->get_cross_sell_ids();
$color_attribute = $product->get_attribute('pa_color');
$color_slug = '';

if ($color_attribute) {
	$attribute_taxonomies = wc_get_attribute_taxonomies();
	foreach ($attribute_taxonomies as $taxonomy) {
		if ('color' === $taxonomy->attribute_name) {
			$term = get_term_by('name', $color_attribute, 'pa_color');
			if ($term && !is_wp_error($term)) {
				$color_slug = $term->slug;
			}
			break;
		}
	}
}

$sizes = array();
$max_discount = 0;
$precio_regular = 0;
$precio_sale = 0;
foreach ($available_variations as $variation) {
	$size = $variation['attributes']['attribute_pa_talla'];
	$sizes[] = array(
		$size => $variation['variation_id'],
		'in_stock' => $variation['is_in_stock']
	);
	$regular = floatval( $variation['display_regular_price'] );
	$sale    = floatval( $variation['display_price'] );

	if ( $sale > 0 && $sale < $regular ) {
		$precio_regular = $regular;
		$precio_sale = $sale;
		$discount = round( ( ( $regular - $sale ) / $regular ) * 100 );
		if ( $discount > $max_discount ) {
			$max_discount = $discount;
		}
	}
}
$descuento = 0;
$size_modal = get_field('acf_ps_guia');
$items = get_field('acf_ps_items');
$video_banner = get_field('acf_ps_video');
$combine = get_field('acf_ps_combine');
$product_test = get_field('acf_ps_test');

foreach( $items as $item ) {
	$title = $item['acf_ps_items_title'];
	$slug = sanitize_title($title);
	$content = $item['acf_ps_items_content'];

	$processed_items[] = [
		'title'   => $title,
		'slug'    => $slug,
		'content' => $content,
	];
}

$product_cats = wp_get_post_terms($current_product_id, 'product_cat', array('fields' => 'ids'));

$args = array(
	'post_type'      => 'product',
	'posts_per_page' => 4,
	'post__not_in'   => array($current_product_id),
	'post_status'	 => 'publish',
	'orderby'        => 'rand',
	'tax_query'      => array(
		'relation' => 'AND',
		array(
			'taxonomy' => 'product_visibility',
			'field'    => 'name',
			'terms'    => array('exclude-from-catalog'),
			'operator' => 'NOT IN',
		),
		array(
			'taxonomy' => 'product_cat',
			'field'    => 'term_id',
			'terms'    => $product_cats,
		),
	),
);
$query = new WP_Query($args);
/*if ( $precio_regular && $precio_descuento ) {
	$descuento = round( ( ( $precio_regular - $precio_descuento ) / $precio_regular ) * 100 );
}*/
?>
	<section class="mos__prod-detail">
		<div class="mos__prod-detail__cols ds-flex justify-space-between align-start flex-wrap">
			<div class="mos__prod-detail__gallery">
				<div id="mos-prod-gallery" class="swiper">
					<div class="swiper-wrapper">
						<?php if ( $attachment_ids ) :
							$gallery_items = [];
							foreach ( $attachment_ids as $index => $attachment_id ) {
								$image = wp_get_attachment_image(
									$attachment_id,
									'full',
									false,
									array(
										'class' => '',
										'alt' => get_the_title(),
										'fetchPriority' => 'high'
									)
								);

								$gallery_items[] = [
									'index' => $index,
									'image' => $image,
								];
							}
						?>
							<?php foreach ( $gallery_items as $item ) : ?>
								<div class="swiper-slide">
									<div data-slide="<?php echo esc_attr( $item['index'] ); ?>" class="item-gallery">
										<?php echo $item['image']; ?>
									</div>
								</div>
							<?php endforeach; ?>
						<?php if(!empty($video_banner)): ?>
							<div class="swiper-slide">
								<video controls playsinline muted loading="lazy" poster="<?php echo esc_attr($poster); ?>">
									<source src="<?php echo esc_url($video_banner); ?>" type="video/mp4">
								</video>
							</div>
						<?php endif; ?>
					</div>
					<div class="swiper-scrollbar"></div>
				</div>
				<div id="mos-modal-gallery" class="mos__modal__gallery">
					<button class="mos__modal__gallery__close">
						<img width="15" height="15" src="<?php echo IMAGES . 'icon-close.svg'; ?>" alt="cerrar">
					</button>
					<div class="mos__modal__gallery__container">
						<div class="swiper">
							<div class="swiper-wrapper">
								<?php foreach ( $gallery_items as $item ) : ?>
									<div class="swiper-slide">
										<?php echo $item['image']; ?>
									</div>
								<?php endforeach; ?>
							</div>
							<div class="swiper-button-prev">
								<svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M0 24C0 10.7452 10.7452 0 24 0C37.2548 0 48 10.7452 48 24C48 37.2548 37.2548 48 24 48C10.7452 48 0 37.2548 0 24Z" fill="#011E41" ></path>
									<path d="M27 18L21 24L27 30" stroke="#FAFAFA" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
								</svg>
							</div>
							<div class="swiper-button-next">
								<svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M0 24C0 10.7452 10.7452 0 24 0C37.2548 0 48 10.7452 48 24C48 37.2548 37.2548 48 24 48C10.7452 48 0 37.2548 0 24Z" fill="#011E41" ></path>
									<path d="M21 18L27 24L21 30" stroke="#FAFAFA" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
								</svg>
							</div>
						</div>
						<div class="mos__zoom-img">
							<svg width="213" height="213" viewBox="0 0 213 213" fill="none">
								<path d="M71.0001 1.53333C46.6001 6.33333 27.8001 18.7333 14.3335 39.1333C-5.13322 68.7333 -3.93322 109 17.2668 137.667C43.5335 173.267 93.1335 183.267 130.467 160.6C134.467 158.2 139 155.267 140.733 154.333C143.533 152.467 144.733 153.4 174.067 182.733C190.733 199.4 205.267 213 206.467 213C209.267 213 213 208.733 213 205.667C213 204.2 200.6 190.733 182.867 172.867L152.733 142.6L156.867 136.467C168.333 119.8 173.667 101.133 172.6 81.6667C171.267 56.8667 160.467 35.4 141.4 19.5333C134.2 13.5333 116.733 4.73332 107.667 2.59999C97.1335 0.0666504 80.8668 -0.333344 71.0001 1.53333ZM103.533 15C128.6 21 151 43.1333 157.667 68.6C169.4 113.667 133.4 159.533 86.3335 159.667C42.8668 159.8 7.53345 118.733 14.0668 76.0667C20.7335 33.8 62.3335 5.39999 103.533 15Z" fill="white"></path>
								<path d="M82.3337 42.3333C79.9337 44.7333 79.667 46.7333 79.667 62.3333V79.6667H62.3337C46.7337 79.6667 44.7337 79.9333 42.3337 82.3333C40.867 83.8 39.667 85.5333 39.667 86.3333C39.667 87.1333 40.867 88.8667 42.3337 90.3333C44.7337 92.7333 46.7337 93 62.3337 93H79.667V110.333C79.667 125.933 79.9337 127.933 82.3337 130.333C85.5337 133.533 88.067 133.667 90.867 130.867C92.6003 129.267 93.0003 125.4 93.0003 110.867V93H110.867C129.8 93 133 92.0667 133 86.3333C133 80.6 129.8 79.6667 110.867 79.6667H93.0003V61.8C93.0003 47.2666 92.6003 43.4 90.867 41.8C88.067 39 85.5337 39.1333 82.3337 42.3333Z" fill="white"></path>
							</svg>
							<span>Zoom</span>
						</div>
					</div>
				</div>
				<?php endif; ?>
			</div>
			<div class="mos__prod-detail__info js-cart-product">
				<h1><?php the_title(); ?></h1>
				<?php if($max_discount > 0): ?>
					<div class="ds-flex align-center">
						<p class="price-desc">
							<?php echo $moneda_simbolo; ?><?php echo $precio_regular; ?>
						</p>
						<p class="price-normal">
							<?php echo $moneda_simbolo; ?><?php echo $precio_sale; ?>
						</p>
					</div>
					<div class="desc-box">
						<span>DESC <?php echo $max_discount; ?>%</span>
					</div>
				<?php else : ?>
					<p class="price-normal">
						<?php echo $moneda_simbolo; ?><?php echo $precio_actual; ?>
					</p>
				<?php endif; ?>
				<div class="ds-flex mos-selects">
					<?php /*
					<?php if ( isset( $attributes['pa_color'] ) ) : ?>
						<div class="form-input">
							<label for="">COLOR</label>
							<select class="variation-selector" name="attribute_pa_color">
								<?php
									$terms = wc_get_product_terms( $product->get_id(), 'pa_color', array( 'fields' => 'all' ) );
									foreach ( $terms as $term ) {
										echo '<option value="' . esc_attr( $term->slug ) . '">' . esc_html( $term->name ) . '</option>';
									}
								?>
							</select>
						</div>
					<?php endif; ?>
					*/ ?>
					<?php if (!empty($cross_sells)) : ?>
						<div class="form-input">
							<label for="variation-color">COLOR</label>
							<select id="variation-color" class="variation-selector" name="attribute_pa_color">
								<option value="<?php echo esc_attr($color_slug); ?>" selected><?php echo $color_attribute; ?></option>
								<?php foreach ($cross_sells as $cross_sell_id) :
									$cross_sell_product = wc_get_product($cross_sell_id);
								?>
									<?php if ($cross_sell_product) :
										$cross_sell_color = $cross_sell_product->get_attribute('pa_color');
									?>
										<?php if ($cross_sell_color) : ?>
											<option
												data-url="<?php echo esc_url(get_permalink($cross_sell_id)) ?>"
												value="<?php echo sanitize_title($cross_sell_color); ?>">
												<?php echo esc_html($cross_sell_color) ?>
											</option>
										<?php endif; ?>
									<?php endif; ?>
								<?php endforeach; ?>
							</select>
						</div>
					<?php else : ?>
						<?php if($color_attribute) : ?>
							<div class="form-input">
								<label for="variation-color">COLOR</label>
								<select id="variation-color" class="variation-selector" name="attribute_pa_color">
									<option value="<?php echo esc_attr($color_slug); ?>" selected><?php echo $color_attribute; ?></option>
								</select>
							</div>
						<?php endif; ?>
					<?php endif; ?>
					<?php if ( !empty($sizes) ) : ?>
						<div class="form-input">
							<label for="variation-talla">TALLA</label>
							<select id="variation-talla" class="variation-selector" name="attribute_pa_talla">
								<option value="">SELECCIONA TALLA</option>
								<?php
									foreach ( $sizes as $item ) {
										$size = array_keys($item)[0];
										$variation_id = $item[$size];
										$in_stock = $item['in_stock'];
										$disabled = $in_stock ? '' : 'disabled';
										echo '<option '. $disabled .' value="' . esc_attr( $variation_id ) . '">' . esc_html( $size ) . '</option>';
									}
								?>
							</select>
						</div>
					<?php endif; ?>
				</div>
				<div class="ds-flex align-center">
					<?php if (!empty($size_modal)) : ?>
						<button
							class="js-modal-trigger mos-size-guide" data-modal-target="mos-modal-size-guide" aria-label="Guía de tallas">
							<span>Guía de tallas</span>
						</button>
					<?php endif; ?>
					<?php if(!empty($combine)): ?>
						<button
							class="js-modal-trigger mos-combine" data-modal-target="mos-modal-combine" aria-label="Combinar con">
							<span>¿Con qué combinar?</span>
						</button>
					<?php endif; ?>
				</div>
				<input type="hidden" class="product-quantity" name="quantity" value="1" min="1" />
				<?php if($product_test) : ?>
					<a
						href="https://api.whatsapp.com/send/?phone=%2B51908900915&text&type=phone_number&app_absent=0"
						target="_blank"
						class="mos__btn mos__btn--primary"
					>
						PREVENTA
					</a>
				<?php else: ?>
					<button
						type="button"
						class="mos__btn mos__btn--primary js-add-cart"
						data-id="<?php echo $current_product_id; ?>"
						data-product-type="<?php echo $type_product; ?>"
						aria-label="AGREGAR AL CARRITO"
					>
						AGREGAR AL CARRITO
					</button>
				<?php endif; ?>
				<div id="message-product-single"></div>
				<a href="https://api.whatsapp.com/send/?phone=%2B51908900915&text&type=phone_number&app_absent=0" target="_blank" class="mos-contact-asesor">
					Contactar con un asesor
				</a>
				<?php if( $items ) : ?>
					<ul class="mos__prod-detail__items">
						<?php foreach( $processed_items as $p_item ) : ?>
							<li>
								<button class="js-modal-trigger ds-flex align-center justify-space-between"
										data-modal-target="mos-modal-<?php echo esc_attr($p_item['slug']); ?>"
										aria-label="<?php echo esc_attr($p_item['title']); ?>">
									<?php echo esc_html($p_item['title']); ?>
									<svg width="12" height="18" viewBox="0 0 12 18" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M0.128906 0.629507L10.0289 8.99999L0.128906 17.3705L1.22891 17.3705L11.1289 8.99999L1.22891 0.629507L0.128906 0.629507Z" fill="black"/>
									</svg>
								</button>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
		</div>
	</section>
	<?php if( $items ) : ?>
		<?php foreach( $processed_items as $p_item ) : ?>
			<div id="mos-modal-<?php echo esc_attr($p_item['slug']); ?>" class="mos__modal mos__modal--right-to-left">
				<div class="mos__modal__container mos__modal--sidebar m-right">
					<div class="mos__modal__header ds-flex justify-space-between">
						<h2><?php echo esc_html($p_item['title']); ?></h2>
						<button class="mos__modal__close">
							<img width="15" height="15" src="<?php echo IMAGES . 'icon-close.svg'; ?>" alt="cerrar">
						</button>
					</div>
					<div class="mos__modal__content">
						<?php echo $p_item['content']; ?>
					</div>
				</div>
				<div class="mos__modal__bg"></div>
			</div>
		<?php endforeach; ?>
	<?php endif; ?>
	<?php if (!empty($size_modal)) : ?>
		<div id="mos-modal-size-guide" class="mos__modal mos__modal--right-to-left">
			<div class="mos__modal__container mos__modal--sidebar m-right">
				<div class="mos__modal__header ds-flex justify-space-between">
					<h2>Guía de tallas</h2>
					<button class="mos__modal__close">
						<img width="15" height="15" src="<?php echo IMAGES . 'icon-close.svg'; ?>" alt="cerrar">
					</button>
				</div>
				<div class="mos__modal__content">
					<?php echo $size_modal; ?>
				</div>
			</div>
			<div class="mos__modal__bg"></div>
		</div>
	<?php endif; ?>
	<?php if(!empty($combine)): ?>
		<div id="mos-modal-combine" class="mos__modal mos__modal--right-to-left">
			<div class="mos__modal__container mos__modal--sidebar m-right">
				<div class="mos__modal__header ds-flex justify-space-between">
					<h2>¿Con qué combinar?</h2>
					<button class="mos__modal__close">
						<img width="15" height="15" src="<?php echo IMAGES . 'icon-close.svg'; ?>" alt="cerrar">
					</button>
				</div>
				<div class="mos__modal__content">
					<div class="ds-grid ds-grid__col2 ds-grid__gap30">
						<?php foreach( $combine as $post ):  ?>
							<?php
								$product = wc_get_product( $post->ID );
								$pathContentProduct = get_stylesheet_directory() . '/partials/product/product-item.php';
								if ( file_exists($pathContentProduct) ) {
									include $pathContentProduct;
								}
							?>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
			<div class="mos__modal__bg"></div>
		</div>
	<?php endif; ?>
	<?php if ($query->have_posts()) : ?>
		<section class="mos__prod-detail__recommend">
			<div class="mos__container">
				<h2 class="text-center">QUIZÁS TAMBIÉN LE GUSTE</h2>
				<div class="ds-grid ds-grid__col4 ds-grid__gap30">
					<?php while ($query->have_posts()) : ?>
						<?php
							$pathContentProduct = get_stylesheet_directory() . '/partials/product/product-item.php';
							if ( file_exists($pathContentProduct) ) {
								$query->the_post();
								$product = wc_get_product(get_the_ID());
								include $pathContentProduct;
							}
						?>
					<?php wp_reset_postdata(); endwhile; ?>
				</div>
			</div>
		</section>
	<?php endif; ?>
<?php
get_footer();
