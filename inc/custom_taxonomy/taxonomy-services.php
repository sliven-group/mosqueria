
<?php
add_action( 'init', 'taxonomies_services', 0 );
function taxonomies_services() {
	$labels = array(
		'name'             => _x( 'Category', 'taxonomy general name' ),
		'singular_name'    => _x( 'Category', 'taxonomy singular name' ),
		'search_items'     =>  __( 'Search for category' ),
		'all_items'        => __( 'All categories' ),
		'parent_item'      => __( 'Father category' ),
		'parent_item_colon'=> __( 'Father category:' ),
		'edit_item'        => __( 'Edit category' ),
		'update_item'      => __( 'Update category' ),
		'add_new_item'     => __( 'Add new category' ),
		'new_item_name'    => __( 'Name of the new Category' ),
	);

	register_taxonomy( 'category-services',
		array( 'services' ),
		array(
			'show_in_rest' => true,
			'show_admin_column' => true,
			'hierarchical' => true,
			'parent_item'  => null,
			'parent_item_colon' => null,
			'labels' => $labels,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => false,
		)
	);
}
