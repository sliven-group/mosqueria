<?php
	/* Template Name: Quiz */

	if (!is_user_logged_in()) {
    $survey_url = home_url('?modal_login=true&url_encuesta=') . home_url('encuesta');
    wp_redirect($survey_url);
    exit;
	}

	global $wpdb;
	$table_name = $wpdb->prefix . 'quiz';
	$user_login = wp_get_current_user()->user_login;
	$ya_respondio = $wpdb->get_var( $wpdb->prepare(
		"SELECT COUNT(*) FROM $table_name WHERE user_wp = %s",
		$user_login
	));

	if ( $ya_respondio > 0 ) {
		wp_redirect( home_url('') );
		exit;
	}

	$user_id = get_current_user_id();
	$survey_start = get_user_meta($user_id, 'mos_survey_start_time', true);

	if (!$survey_start) {
		wp_redirect(home_url()); // No invitado
		exit;
	}

	$survey_timestamp = strtotime($survey_start);
	$now = current_time('timestamp');
	$diff_in_days = ($now - $survey_timestamp) / DAY_IN_SECONDS;

	if ($diff_in_days > 10) {
		wp_redirect(home_url()); // Tiempo expirado
		exit;
	}

	get_header();
?>
	<?php if ( have_posts()) : ?>
		<?php while ( have_posts()) : the_post(); ?>
			<?php the_content(); ?>
		<?php endwhile; ?>
	<?php endif; ?>
<?php
	get_footer();
?>
