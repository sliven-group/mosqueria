
<?php
	/* Template Name: Start */
	get_header();
?>
	<?php if ( have_posts()) : ?>
		<section>
			<div class="mos__container">
				<?php while ( have_posts()) : the_post(); ?>
					<?php the_content(); ?>
				<?php endwhile; ?>
			</div>
		</section>
	<?php endif; ?>
<?php
	get_footer();
?>
