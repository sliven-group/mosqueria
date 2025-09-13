<?php
	$labels = array(
		'name'               => _x( 'Services', 'ws' ),
		'singular_name'      => _x( 'Services', 'post type Services', 'ws' ),
		'menu_name'          => _x( 'Services', 'administration menu', 'ws' ),
		'name_admin_bar'     => _x( 'Services', 'add new in admin bar', 'ws' ),
		'add_new'            => _x( 'Add', 'Services', 'ws' ),
		'add_new_item'       => __( 'Add new', 'ws' ),
		'new_item'           => __( 'New Services', 'ws' ),
		'edit_item'          => __( 'Edit Services', 'ws' ),
		'view_item'          => __( 'View Services', 'ws' ),
		'all_items'          => __( 'All Services', 'ws' ),
		'search_items'       => __( 'Search Services', 'ws' ),
		'parent_item_colon'  => __( 'Parent Services:', 'ws' ),
		'not_found'          => __( 'Not found', 'ws' ),
		'not_found_in_trash' => __( 'No Services were found in the trash.', 'ws' )
	);

	$args = array(
		'labels'             => $labels,
		'description'        => __( 'Description.', 'ws' ),
		'public'             => true,
		'menu_icon'          => 'dashicons-welcome-add-page',
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_admin_bar'  => true,
		'show_in_rest' 		 	 => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'services' ),
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => 7,
		'supports'           => array( 'title','editor','excerpt','thumbnail' )
	);
	register_post_type( 'services', $args );
