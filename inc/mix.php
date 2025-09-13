<?php
/**
 * Gets the path to a versioned Mix file in a theme.
 *
 * Use this function if you want to load theme dependencies. This function will cache the contents
 * of the manifest files for you.
 *
 * If you want to use mix in a child theme, use `mix_child()`.
 * If you want to use mix outside of your theme folder, you can use `mix_any()`.
 *
 * Inspired by <https://www.sitepoint.com/use-laravel-mix-non-laravel-projects/>.
 *
 * @since 1.0.0
 *
 * @param string $path The relative path to the file.
 * @param string $args {
 *     Optional. An array of arguments for the function.
 *
 *     @type bool   $is_child           Whether to check the child directory first. Default `false`.
 *     @type string $manifest_directory Custom relative path to manifest directory. Default `build`.
 * }
 *
 * @return string The versioned file URL.
 */
if (!function_exists('mix')) {
	function mix( $path, $args = [] ) {
		// Manifest content cache.
		static $manifests = [];

		/**
		 * Backwards compatibility.
		 *
		 * @todo Remove in 2.x
		 */
		if ( is_string( $args ) ) {
			$args = [
				'manifest_directory' => $args,
			];
		}

		$defaults = [
			'is_child'           => false,
			'manifest_directory' => 'assets',
		];

		/**
		 * Filters the default arguments used for the mix function
		 *
		 * @since 1.2.0
		 *
		 * @param array $defaults An array of default values.
		 */
		$defaults = apply_filters( 'theme/mix/args/defaults', $defaults );

		$args = wp_parse_args( $args, $defaults );

		$manifest_directory = $args['manifest_directory'];

		if ( $args['is_child'] ) {
			$base_path = trailingslashit( get_theme_file_path() );
		} else {
			$base_path = trailingslashit( get_parent_theme_file_path() );
		}

		$manifest_path = $base_path . trailingslashit( $manifest_directory ) . 'mix-manifest.json';

		// Bailout if manifest couldn’t be found.
		if ( ! file_exists( $manifest_path ) ) {
			return $base_path . $path;
		}

		if ( ! isset( $manifests[ $manifest_path ] ) ) {
			// @codingStandardsIgnoreLine
			$manifests[ $manifest_path ] = json_decode( file_get_contents( $manifest_path ), true );
		}

		$manifest = $manifests[ $manifest_path ];

		// Remove manifest directory from path.
		$path = str_replace( $manifest_directory, '', $path );
		// Make sure there’s a leading slash.
		$path = '/' . ltrim( $path, '/' );

		// Bailout with default theme path if file could not be found in manifest.
		if ( ! array_key_exists( $path, $manifest ) ) {
			if ( $args['is_child'] ) {
				return get_theme_file_uri( $path );
			}

			return get_parent_theme_file_uri( $path );
		}

		// Get file URL from manifest file.
		$path = $manifest[ $path ];
		// Make sure there’s no leading slash.
		$path = ltrim( $path, '/' );

		if ( $args['is_child'] ) {
			$file = trailingslashit( $manifest_directory ) . $path;

			/**
			 * We don’t use get_theme_file_uri(), because that function uses file_exists() to check if a
			 * file exists. If we pass in a full path including an ?id URL parameter, the file_exists()
			 * check will fail.
			 */
			$url = get_stylesheet_directory_uri() . '/' . $file;

			/**
			 * Pass in the URL to the theme_file_uri filter, because with the line above, we simulate
			 * the same functionality as get_theme_file_uri(). This should improve compatibility,
			 * because we use get_theme_file_uri() and get_parent_theme_file_uri() everywhere else.
			 *
			 * @see get_theme_file_uri()
			 */
			return apply_filters( 'theme_file_uri', $url, $file );
		}

		return get_parent_theme_file_uri( trailingslashit( $manifest_directory ) . $path );
	}
}