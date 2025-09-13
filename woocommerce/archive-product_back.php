<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

defined( 'ABSPATH' ) || exit;

function add_css_js() {
	wp_register_style( 'block-banner-principal', mix('assets/css/banner-principal.css'), [], false );
	wp_enqueue_style( 'block-banner-principal' );

	wp_register_style( 'style-store', mix('assets/css/template-store.css'), [], false );
	wp_enqueue_style( 'style-store' );

	wp_register_script( 'script-store', mix('assets/js/template-store.js'), [], false, true );
	wp_enqueue_script( 'script-store' );
}
add_action('wp_enqueue_scripts', 'add_css_js');

$category = get_queried_object();
$slugCategory = $category->slug ?? '';
$ID = $category->term_id;
$countItem = PER_PAGE;
$thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
$parent_slug = '';

if ($category && $category->taxonomy === 'product_cat') {
	$current_term = $category;
	while ($current_term->parent != 0) {
		$current_term = get_term($current_term->parent, 'product_cat');
	}
	$ID = $current_term->term_id;
	$parent_slug = $current_term->slug;
}

$categories = get_terms([
	'taxonomy'   => 'product_cat',
	'hide_empty' => false,
	'parent'		 => $ID
]);

$filters_color = get_terms([
	'taxonomy'   => 'pa_color',
	'hide_empty' => false
]);

$filters_talla = get_terms([
	'taxonomy'   => 'pa_talla',
	'hide_empty' => false
]);

if(!empty($slugCategory)) {
	$tax_query[] = [
		'taxonomy' => 'product_cat',
		'field'    => 'slug',
		'terms'    => $slugCategory
	];
}

$args = [
	'post_type'      	=> 'product',
	'post_status'	 		=> 'publish',
	'posts_per_page' 	=> $countItem,
	'orderby'					=> 'title',
	'order'					 	=> 'ASC',
	'tax_query'      	=> $tax_query,
	'meta_query'     	=> [
		'relation' => 'OR',
		[
			'key'     => 'acf_ps_desc',
			'value'   => '0',
			'compare' => '=',
			'type'    => 'CHAR',
		],
		[
			'key'     => 'acf_ps_desc',
			'compare' => 'NOT EXISTS',
		]
	],
	'fields' => 'ids'
];

$query = new WP_Query($args);

// Tallas permitidas si la categoría es "mujer"
$tallas_mujer = ['xs', 's', 'm', 'l', '28', '30', '32', '34'];

//categorias permitidas para mujeres
//$cat_mujer = ['bodies', 'pantalones-largos-y-cortos-mujeres'];

//categorias permitidas para hombres
$cat_hombre = ['polos-y-camisetas'];

get_header();
?>
<input type="hidden" id="product-current-category" name="product-current-category" value="<?php echo $slugCategory; ?>">
<section class="mos__block__banner">
	<?php if($thumbnail_id) :
		$image_url = wp_get_attachment_url($thumbnail_id);
	?>
		<?php if ($image_url) : ?>
			<img src="<?php echo esc_url($image_url) ?>" alt="<?php echo esc_attr($category->name); ?>" class="image m-auto" />
		<?php endif; ?>
	<?php else : ?>
		<img fetchpriority="high" decoding="async" width="1516" height="830" src="<?php echo IMAGES . 'promocion-imagen.webp'; ?>" class="image m-auto" alt="">
	<?php endif; ?>
	<div class="mos__container">
		<div class="mos__block__banner__content">
			<?php
				if ( is_shop() ) {
					echo '<h1>' . get_the_title( wc_get_page_id( 'shop' ) ) . '</h1>';
				} elseif ( is_product_category() ) {
					echo '<h1>' . single_cat_title( '', false ) . '</h1>';
				}
			?>
		</div>
	</div>
</section>
<?php	if ($query) : ?>
	<section class="mos__store pt-50 pb-50">
		<div class="mos__container">
			<div class="mos__store__filters ds-flex align-center">
				<?php if (!empty($categories) && !is_wp_error($categories)) : ?>
					<div class="mos__store__filters__item relative">
						<button class="ds-flex align-center">
							<span>CATEGORÍA</span>
							<svg width="19" height="11" viewBox="0 0 19 11" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M19 0L9.5 9.9L0 0V1.1L9.5 11L19 1.1V0Z" fill="black"/>
							</svg>
						</button>
						<ul class="mos__store__filters__item__content">
							<?php foreach ($categories as $category) :
								$name = $category->name;
								$id = $category->term_id;
								$slug = $category->slug;
								$count =  $category->count;
								$category_link = get_term_link($category);
								$class = "";

								/*if ($parent_slug === 'mujeres' && !in_array($slug, $cat_mujer)) {
									$class = 'no-active';
								}*/

								/*if ($parent_slug === 'hombres' && !in_array($slug, $cat_hombre)) {
									$class = 'no-active';
								}*/
								if($count < 1) {
									$class = 'no-active';
								}
							?>
								<li class="<?php echo $class; ?>">
									<a href="<?php echo esc_url($category_link); ?>"><?php echo $name; ?></a>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endif; ?>
				<?php if(!empty($filters_color) || !empty($filters_talla)) : ?>
					<div class="mos__store__filters__item relative">
						<button class="ds-flex align-center">
							<span>FILTROS</span>
							<svg width="19" height="11" viewBox="0 0 19 11" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M19 0L9.5 9.9L0 0V1.1L9.5 11L19 1.1V0Z" fill="black"/>
							</svg>
						</button>
						<div class="mos__store__filters__item__content filter-color-talla">
							<div class="custom-filters-top">
								<div class="ds-flex justify-space-between">
									<div class="attribute">
										<h3>COLOR</h3>
										<ul class="ds-flex justify-space-between flex-wrap">
											<li>
												<label class="mos-checkbox">
													<span class="mos-checkbox__text">Ver todos</span>
													<input type="checkbox" name="color[]" value="" checked>
													<span class="mos-checkbox__checkmark"></span>
												</label>
											</li>
											<?php foreach ($filters_color as $color) :
												$name = $color->name;
												$slug = $color->slug;

												if ($parent_slug === 'hombres' && in_array($slug, ['mocca', 'rosado', 'perla', 'celeste'])) {
													continue;
												}

												if ($parent_slug === 'mujeres' && in_array($slug, ['azul-acero', 'jardin-botanico', 'gris'])) {
													continue;
												}
											?>
												<li>
													<label class="mos-checkbox">
														<span class="mos-checkbox__text"><?php echo $name; ?></span>
														<input type="checkbox" name="color[]" value="<?php echo $slug; ?>">
														<span class="mos-checkbox__checkmark"></span>
													</label>
												</li>
											<?php endforeach; ?>
										</ul>
									</div>
									<div class="attribute">
										<h3>TALLA</h3>
										<ul class="ds-flex justify-space-between flex-wrap <?php echo $slugCategory; ?>">
											<li>
												<label class="mos-checkbox">
													<span class="mos-checkbox__text">Ver todos</span>
													<input type="checkbox" name="talla[]" value="" checked>
													<span class="mos-checkbox__checkmark"></span>
												</label>
											</li>
											<?php foreach ($filters_talla as $talla) :
												$name = $talla->name;
												$slug = $talla->slug;
												if ($slugCategory === 'mujeres' && !in_array(strtolower($slug), $tallas_mujer)) {
													continue;
												}
												if ($parent_slug === 'hombres' && in_array($slug, ['xs', '28'])) {
													continue;
												}
											?>
												<li>
													<label class="mos-checkbox">
														<span class="mos-checkbox__text"><?php echo $name; ?></span>
														<input type="checkbox" name="talla[]" value="<?php echo $slug; ?>">
														<span class="mos-checkbox__checkmark"></span>
													</label>
												</li>
											<?php endforeach; ?>
										</ul>
									</div>
								</div>
							</div>
							<div class="custom-filters-bottom">
								<p class="text-center">Puede seleccionar varias opciones a la vez.</p>
								<button id="mos-store-filters-btn" class="mos__btn mos__btn--primary">APLICAR</button>
							</div>
						</div>
					</div>
				<?php endif; ?>
				<div class="mos__store__filters__item relative">
					<button class="ds-flex align-center">
						<p>Ordenar por:</p>
						<span class="upper">ÚLTIMAS NOVEDADES</span>
						<svg width="19" height="11" viewBox="0 0 19 11" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M19 0L9.5 9.9L0 0V1.1L9.5 11L19 1.1V0Z" fill="black"/>
						</svg>
					</button>
					<ul class="mos__store__filters__item__content">
						<li data-orden="all" class="filter-order">Últimas novedades</li>						
						<li data-orden="DESC" class="filter-order">Descendente</li>
						<li data-orden="ASC" class="filter-order">Ascendente</li>
					</ul>
				</div>
			</div>
			<div id="mos-archive-product" class="ds-grid ds-grid__col4 ds-grid__gap30 relative">
				<?php while ( $query->have_posts() ) : ?>
					<?php
						$query->the_post();
						$product = wc_get_product( get_the_ID() );
						$pathContentProduct = get_stylesheet_directory() . '/partials/product/product-item.php';
						if ( file_exists($pathContentProduct) ) {
							include $pathContentProduct;
						}
					?>
				<?php endwhile; ?>
			</div>
			<button id="mos-load-more-product" class="mos__btn mos__btn--primary <?php echo $query->found_posts <= $countItem ? 'ds-none' : ''; ?>" data-page="1" data-cat="<?php echo $slugCategory; ?>">MOSTRAR MÁS</button>
			<input type="hidden" id="mos-filter-order">
		</div>
	</section>
<?php wp_reset_postdata(); endif; ?>
<?php
get_footer();
