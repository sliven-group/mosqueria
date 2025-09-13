<?php

class Mos {
	public function __construct() {
		$this->init();
		$this->hideAdminBar();
		//$this->definePostTypeCodes();
		//$this->customPostTaxonomy();
		$this->mosRegisterACFs();
	}

	public function init() {
		add_action('admin_init', [$this,'restrict_wp_admin_access']);
		add_action('init', [$this, 'theme_register_menus']);
		add_action('widgets_init', [$this, 'theme_load_widgets']);
		add_action('init' , [$this, 'custom_logo']);
		add_filter('upload_mimes', [$this, 'set_mime_types']);
		add_filter('block_categories_all', [ $this, 'register_block_category' ], 10, 2);
		add_filter('init', [$this, 'register_acf_blocks']);
		add_action('enqueue_block_assets', [$this, 'register_acf_blocks_assets']);
		add_action('after_setup_theme', [ $this, 'create_bd_newsletter' ]);
		add_action('after_setup_theme', [ $this, 'create_bd_quiz' ]);
		add_action('after_setup_theme', [ $this, 'create_bd_abandoned_carts' ]);
		add_action('after_setup_theme', [ $this, 'create_bd_libro_lrq' ]);
		add_filter('query_vars', [$this, 'mos_query_vars']);
	}

	public function theme_register_menus() {
		register_nav_menus(
			array(
				'menu-primary'  => __('Menu principal', 'mos'),
				'menu-footer-1'  => __('Menu footer 1', 'mos'),
				'menu-footer-2'  => __('Menu footer 2', 'mos'),
				'menu-footer-3'  => __('Menu footer 3', 'mos'),
			)
		);
	}

	public function hideAdminBar() {
		show_admin_bar(false);
	}

	public function custom_logo() {
		add_theme_support( 'custom-logo', array(
			'height' => 218,
			'width'  => 46,
			'flex-height' => true,
			'flex-width'  => true,
		));
	}

	public function set_mime_types( $mimes ) {
		$mimes['svg'] = 'image/svg+xml';
		return $mimes;
	}

	/*public function customPostType() {
		$filepath = dirname(__FILE__) . '/custom_posts/';
		$files = scandir( $filepath );
		foreach ($files as $file) {
			if ( substr($file,-4,4) == '.php' ) {
				include_once( $filepath . $file );
			}
		}
	}*/

	/*public function customPostTaxonomy() {
		$filepath = dirname(__FILE__) . '/custom_taxonomy/';
		$files = scandir( $filepath );
		foreach ($files as $file) {
			if ( substr($file,-4,4) == '.php' ) {
				include_once( $filepath . $file );
			}
		}
	}*/

	public function mosRegisterACFs() {
		include_once 'custom_fields/settings.php';
		include_once 'custom_fields/acf_settings.php';
		include_once 'custom_fields/acf_menu.php';
		include_once 'custom_fields/acf_block_info_product.php';
		include_once 'custom_fields/acf_block_banner_principal.php';
		include_once 'custom_fields/acf_block_promotion.php';
		include_once 'custom_fields/acf_block_subscribe.php';
		include_once 'custom_fields/acf_block_latest_products.php';
		include_once 'custom_fields/acf_block_info_accordion.php';
		include_once 'custom_fields/acf_block_msc_banner.php';
		include_once 'custom_fields/acf_block_msc_steps.php';
		include_once 'custom_fields/acf_block_msc_interesting.php';
		include_once 'custom_fields/acf_block_msc_points.php';
		include_once 'custom_fields/acf_block_msc_benefits.php';
		include_once 'custom_fields/acf_block_unsubscribe.php';
	}

	/*public function definePostTypeCodes() {
		add_action('init', [$this, 'customPostType']);
	}*/

	public function theme_load_widgets() {
		register_sidebar(array(
			'name'          => __('Select currency', 'mos'),
			'id'            => 'change-currency',
			'description'   => __('demo widget', 'mos'),
			'before_widget' => '<div class="chw-widget">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="promoapp-title upper">',
			'after_title'   => '</h3>',
		));
	}

	public function register_block_category( $block_categories, $block_editor_context ) {
		return array_merge(
			$block_categories,
			array(
				array(
					'slug'  => 'mos-blocks',
					'title' => __( 'Mos blocks', 'mos' ),
					'icon'  => 'wordpress',
				),
			)
		);
	}

	public function register_acf_blocks() {
		$blocks = [
			'banner-principal',
			'subscribe',
			'promotion',
			'latest-products',
			'info-accordion',
			'msc-banner',
			'msc-steps',
			'msc-interesting',
			'msc-points',
			'msc-benefits',
			'unsubscribe',
			'quiz',
			'sale',
			'complaints-book'
		];

		foreach ($blocks as $block) {
			register_block_type(__DIR__ . '/blocks/' . $block);
		}
	}

	public function register_acf_blocks_assets() {
		$depStyle = ['style-se'];
		$depScript = ['jquery', 'manifest', 'script-se'];

		if ( function_exists( 'get_current_screen' ) ) {
			if( get_current_screen()->is_block_editor ) {
				$depStyle = [];
				$depScript = [];
			}
		}

		if ( has_block( 'acf/info-accordion' ) ) {
			wp_enqueue_style( 'block-info-accordion', mix('/assets/css/info-accordion.css'), $depStyle, false );
			wp_enqueue_script( 'block-info-accordion', mix('/assets/js/info-accordion.js'), $depScript, false, true );
		}

		if ( has_block( 'acf/subscribe' ) ) {
			wp_enqueue_style( 'block-subscribe', mix('/assets/css/subscribe.css'), $depStyle, false );
		}

		if ( has_block( 'acf/promotion' ) ) {
			wp_enqueue_style( 'block-promotion', mix('/assets/css/promotion.css'), $depStyle, false );
		}

		if ( has_block( 'acf/banner-principal' ) ) {
			wp_enqueue_style( 'block-banner-principal', mix('/assets/css/banner-principal.css'), $depStyle, false );
		}

		if ( has_block( 'acf/latest-products' ) ) {
			wp_enqueue_style( 'block-latest-products', mix('/assets/css/latest-products.css'), $depStyle, false );
		}

		if ( has_block( 'acf/msc-banner' ) ) {
			wp_enqueue_style( 'block-msc-banner', mix('/assets/css/msc-banner.css'), $depStyle, false );
		}

		if ( has_block( 'acf/msc-steps' ) ) {
			wp_enqueue_style( 'block-msc-steps', mix('/assets/css/msc-steps.css'), $depStyle, false );
		}

		if ( has_block( 'acf/msc-interesting' ) ) {
			wp_enqueue_style( 'block-msc-interesting', mix('/assets/css/msc-interesting.css'), $depStyle, false );
		}

		if ( has_block( 'acf/msc-points' ) ) {
			wp_enqueue_style( 'block-msc-points', mix('/assets/css/msc-points.css'), $depStyle, false );
		}

		if ( has_block( 'acf/msc-benefits' ) ) {
			wp_enqueue_style( 'block-msc-benefits', mix('/assets/css/msc-benefits.css'), $depStyle, false );
		}

		if ( has_block( 'acf/unsubscribe' ) ) {
			wp_enqueue_style( 'block-unsubscribe', mix('/assets/css/unsubscribe.css'), $depStyle, false );
			wp_enqueue_script( 'block-unsubscribe', mix('/assets/js/unsubscribe.js'), $depScript, false, true );
		}

		if ( has_block( 'acf/quiz' ) ) {
			wp_enqueue_style( 'block-quiz', mix('/assets/css/quiz.css'), $depStyle, false );
			wp_enqueue_script( 'block-quiz', mix('/assets/js/quiz.js'), $depScript, false, true );
		}

		if ( has_block( 'acf/sale' ) ) {
			wp_enqueue_style( 'block-sale', mix('/assets/css/sale.css'), $depStyle, false );
			wp_enqueue_script( 'block-sale', mix('/assets/js/sale.js'), $depScript, false, true );
		}

		if ( has_block( 'acf/complaints-book' ) ) {
			wp_enqueue_style( 'block-complaints-book', mix('/assets/css/complaints-book.css'), $depStyle, false );
			wp_enqueue_script( 'block-complaints-book', mix('/assets/js/complaints-book.js'), $depScript, false, true );
		}
	}

	public function restrict_wp_admin_access() {
    if (is_admin() && !current_user_can('administrator') && !(defined('DOING_AJAX') && DOING_AJAX)) {
			wp_redirect(home_url());
			exit;
    }
	}

	public function create_bd_newsletter() {
		global $wpdb;
		$table = $wpdb->prefix . 'newsletter';
		$sql = "CREATE TABLE IF NOT EXISTS $table (
			id int(9) NOT NULL AUTO_INCREMENT,
			fecha date NOT NULL,
			email varchar(200) NOT NULL,
			PRIMARY KEY (id)
		)";
		$wpdb->query($sql);
	}

	public function create_bd_quiz() {
		global $wpdb;
		$table = $wpdb->prefix . 'quiz';
		$sql = "CREATE TABLE IF NOT EXISTS $table (
			id int(9) NOT NULL AUTO_INCREMENT,
			user_wp varchar(70) NOT NULL,
			fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
			recommendation TINYINT(3),
			qualification VARCHAR(20),
			presentation VARCHAR(20),
			experience TINYINT(3),
			reasons TEXT,
			other_reason TEXT,
			channel VARCHAR(20),
			site_experience VARCHAR(20),
			site_navigation VARCHAR(20),
			site_improvement TEXT,
			advisor_experience VARCHAR(20),
			advisor_improvement TEXT,
			delivery_experience VARCHAR(20),
			delivery_improvement TEXT,
			comment TEXT,
			PRIMARY KEY (id)
		)";
		$wpdb->query($sql);
	}

	public function create_bd_abandoned_carts() {
		global $wpdb;
		$tabla = $wpdb->prefix . 'abandoned_carts';
		$sql = "CREATE TABLE IF NOT EXISTS $tabla (
			id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			email VARCHAR(191) NOT NULL,
			cart LONGTEXT NOT NULL,
			user_id BIGINT DEFAULT NULL,
			abandoned_at DATETIME NOT NULL,
			first_email_sent DATETIME DEFAULT NULL,
			second_email_sent DATETIME DEFAULT NULL,
			order_completed TINYINT(1) DEFAULT 0,
			created_at DATETIME DEFAULT CURRENT_TIMESTAMP
		)";
		$wpdb->query($sql);
	}

	public function create_bd_libro_lrq() {
		global $wpdb;
		$tabla = $wpdb->prefix . 'mos_libro_lrq';
		$sql = "CREATE TABLE IF NOT EXISTS $tabla (
		`libro_id` int(11) NOT NULL AUTO_INCREMENT,
		`nombres` varchar(100) DEFAULT NULL,
		`apellidos` varchar(100) DEFAULT NULL,
		`tipo_doc` varchar(100) DEFAULT NULL,
		`nro_documento` varchar(15) DEFAULT NULL,
		`celular` int(11) DEFAULT NULL,
		`departamento` varchar(100) DEFAULT NULL,
		`provincia` varchar(100) DEFAULT NULL,
		`distrito` varchar(100) DEFAULT NULL,
		`direccion` varchar(100) DEFAULT NULL,
		`referencia` varchar(100) DEFAULT NULL,
		`email` varchar(100) DEFAULT NULL,
		`flag_menor` varchar(5) DEFAULT NULL,
		`nombre_tutor` varchar(100) DEFAULT NULL,
		`email_tutor` varchar(100) DEFAULT NULL,
		`tipo_doc_tutor` int(5) DEFAULT NULL,
		`numero_documento_tutor` varchar(15) DEFAULT NULL,
		`tipo_reclamacion` varchar(50) DEFAULT NULL,
		`tipo_consumo` varchar(50) DEFAULT NULL,
		`nro_pedido` int(11) NOT NULL,
		`fch_reclamo` timestamp NULL DEFAULT NULL,
		`proveedor` varchar(100) DEFAULT NULL,
		`monto_reclamado` int(11) DEFAULT NULL,
		`descripcion` varchar(100) DEFAULT NULL,
		`fch_compra` timestamp NULL DEFAULT NULL,
		`fch_consumo` timestamp NULL DEFAULT NULL,
		`fch_vencimiento` timestamp NULL DEFAULT NULL,
		`detalle` text,
		`pedido_cliente` text,
		`acepta_contenido` int(5) DEFAULT NULL,
		`acepta_politica` int(5) DEFAULT NULL,
		`respuesta` text,
		`estado` int(5) DEFAULT NULL,
		PRIMARY KEY (`libro_id`)
		)";
		$wpdb->query($sql);
	}

	public function mos_query_vars($vars) {
		$vars[] = 'pedido-id';
		return $vars;
	}
}
