<?php
function theme_setup() {
	add_theme_support('woocommerce');
	add_theme_support('html5', array('search-form', 'gallery'));
	add_theme_support('post-thumbnails');
	add_theme_support('editor-styles');
	add_editor_style('style-editor.css');
	add_theme_support('align-wide');
}

add_action('after_setup_theme', 'theme_setup', 11);
