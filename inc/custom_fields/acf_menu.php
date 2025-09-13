<?php
if( function_exists('acf_add_local_field_group') ):

	add_action( 'acf/include_fields', function() {
		if ( ! function_exists( 'acf_add_local_field_group' ) ) {
			return;
		}

		acf_add_local_field_group( array(
			'key' => 'group_64b376e4d3e95',
			'title' => 'CF Menu Header',
			'fields' => array(
				array(
					'key' => 'field_64b376e4c5e9d',
					'label' => 'Activar imagenes',
					'name' => 'menu_status',
					'aria-label' => '',
					'type' => 'true_false',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'message' => '',
					'default_value' => 0,
					'ui' => 0,
					'ui_on_text' => '',
					'ui_off_text' => '',
				),
				array(
					'key' => 'field_67e337586ed42',
					'label' => 'Titulo',
					'name' => 'menu_title',
					'aria-label' => '',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'maxlength' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
				),
				/*array(
					'key' => 'field_67e337236ed41',
					'label' => 'Galeria',
					'name' => 'menu_gallery',
					'aria-label' => '',
					'type' => 'gallery',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'return_format' => 'array',
					'library' => 'all',
					'min' => '',
					'max' => '',
					'min_width' => '',
					'min_height' => '',
					'min_size' => '',
					'max_width' => '',
					'max_height' => '',
					'max_size' => '',
					'mime_types' => '',
					'insert' => 'append',
					'preview_size' => 'medium',
				),*/
				array(
					'key' => 'field_6837866339745',
					'label' => 'Productos',
					'name' => 'menu_products',
					'aria-label' => '',
					'type' => 'post_object',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'post_type' => array(
						0 => 'product',
					),
					'post_status' => array(
						0 => 'publish',
					),
					'taxonomy' => '',
					'return_format' => 'object',
					'multiple' => 1,
					'allow_null' => 0,
					'bidirectional' => 0,
					'ui' => 1,
					'bidirectional_target' => array(
					),
				),
			),
			'location' => array(
				array(
					array(
						'param' => 'nav_menu_item',
						'operator' => '==',
						'value' => 'location/menu-primary',
					),
				),
			),
			'menu_order' => 0,
			'position' => 'normal',
			'style' => 'default',
			'label_placement' => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen' => '',
			'active' => true,
			'description' => '',
			'show_in_rest' => 0,
		));
	});

endif;
