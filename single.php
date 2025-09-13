<?php
	get_header();
?>
	<?php if (have_posts()) : ?>
		<section>
			<div class="mos__container">
				<h1><?php the_title(); ?></h1>
				<?php while (have_posts()) : the_post(); ?>
					<?php the_content(); ?>
					<?php wp_reset_postdata(); ?>
				<?php endwhile; ?>
			</div>
		</section>
	<?php endif; ?>
<?php get_footer(); ?>
