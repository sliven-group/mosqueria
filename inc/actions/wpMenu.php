<?php

function get_header_data() {
	/*$key = 'mos_header';
	$data = get_cache_key($key);
	if( !empty( $data ) ) {
		return $data;
	}*/
	$data = [
		'message' => '',
		//'home_url' => get_site_url(),
		'status' => false,
		'menu' => get_menu_data(),
		'modal_promo' => get_modal_promo(),
		'products_total_sales' => get_products_total_sales(),
		'messages' => get_messages_promo()
	];
	/*if( function_exists('get_field') ){
		$data['message'] = get_field( 'header_promo_message', 'options' );
		$data['status'] = get_field( 'header_promo_active', 'options' );
		set_cache_key($key, $data);
	}*/
	return $data;
}

function get_menu_data() {
	/*$key = 'mos_menu_primary';
	$data = get_cache_key($key);
	if(!empty($data)){
		return $data;
	}*/

	$locations = get_nav_menu_locations();
	$menuPrimary = isset($locations['menu-primary']) ? wp_get_nav_menu_items($locations['menu-primary']) : null;
	$menu = [];
	//TODO: refactor function
	if (!empty($menuPrimary)) {
		foreach ( $menuPrimary as $primary ) {
			$primary = (array) $primary;
			if( $primary['menu_item_parent'] === '0' ) {
				$secondaryLevel = get_submenu_data($menuPrimary, $primary['ID']);
				if ( !empty($secondaryLevel) ) {
					foreach ($secondaryLevel as $second) {
						$thirdLevel = get_submenu_data($menuPrimary, $second->ID);
						$second = (array) $second;
						if ( !empty($thirdLevel) ) {
							foreach ($thirdLevel as $third) {
								$fourthLevel = get_submenu_data($menuPrimary, $third->ID);
								$third = (array) $third;
								if ( !empty($fourthLevel) ) {
									foreach ( $fourthLevel as $fourth ) {
										$third['sub_menu'][] = get_menu_item_reducer((array) $fourth);
									}
								}
								$second['sub_menu'][] = get_menu_item_reducer($third);
							}
						}
						$primary['sub_menu'][] = get_menu_item_reducer($second);
					}
				}

				$menu[] = get_menu_item_reducer($primary, true);
			}
		}
		//set_cache_key($key, $menu);
	}

	return $menu;
}

function get_submenu_data($menus, $id) {
	if(empty($menus)) return null;
	$submenus = null;
	foreach ($menus as $menu){
		if((int)$menu->menu_item_parent !== 0 && (int)$menu->menu_item_parent === $id){
			$submenus[] =  $menu;
		}
	}
	return $submenus;
}

function get_menu_item_gallery($id) {
	$activeGallery = get_field('menu_status', $id);
	if(!empty($activeGallery)) {
		return [
			'title' => get_field('menu_title', $id),
			'products' => get_field('menu_products', $id)
		];
	}
	return null;
}

function get_menu_item_reducer($item, $banner = false) {
	if($item['post_status'] === 'publish' ) {
		$menu = [
			'title' => $item['title'],
			'url' => $item['url'],
			'target' => $item['target'],
			'classes' => implode(' ', $item['classes']),
			'id' => $item['object_id']
		];
		if( !empty($item['sub_menu'])) {
			$menu['sub_menu'] = $item['sub_menu'];
		}
		if( !empty($banner)) {
			$menu['products'] = get_menu_item_gallery($item['ID']);
		}

		return $menu;
	}
	return null;
}

function get_products_total_sales() {
	$args = array(
		'limit'     => -1, // Traemos todos para filtrar luego
		'orderby'   => 'total_sales',
		'order'     => 'DESC',
		'return'    => 'objects',
	);

	$all_products = wc_get_products( $args );
	$filtered_products = [];

	foreach ( $all_products as $product ) {
		$has_discount = false;

		if ( $product->is_type( 'variable' ) ) {
			$variations = $product->get_children();
			foreach ( $variations as $variation_id ) {
				$sale_price = get_post_meta( $variation_id, '_sale_price', true );
				if ( $sale_price && floatval( $sale_price ) > 0 ) {
					$has_discount = true;
					break;
				}
			}
		} else {
			$sale_price = $product->get_sale_price();
			if ( $sale_price && floatval( $sale_price ) > 0 ) {
				$has_discount = true;
			}
		}

		if ( ! $has_discount ) {
			$filtered_products[] = $product;
		}

		// Salir si ya tenemos 5 sin descuento
		if ( count( $filtered_products ) >= 5 ) {
			break;
		}
	}

	return $filtered_products;
}

function get_modal_promo() {
	$activeModal = get_field('acf_option_modald_validate', 'options');
	if($activeModal) {
		return [
			'title' => get_field('acf_option_modald_title', 'options'),
			'desc' => get_field('acf_option_modald_desc', 'options'),
			'image' => get_field('acf_option_modald_img', 'options'),
		];
	}
	return null;
}

function get_messages_promo() {
	$message = get_field('acf_option_messages', 'options');
	if($message) {
		return [
			'items' => $message
		];
	}
	return null;
}
