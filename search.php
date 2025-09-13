<?php
	get_header();
?>
	<section>
		<div class="mos__container">
			<h1>Search result: <?php echo get_search_query(); ?></h1>
			<?php if (have_posts()) : ?>
				<div class="ds-grid ds-grid__gap50 ds-grid__col3">
					<?php
						while ( have_posts() ) :
						$getExcerpt = get_the_excerpt();
						the_post();
					?>
						<a href="<?php the_permalink(); ?>">
							<h2>
								<?php echo get_the_title(); ?>
							</h2>
							<?php if(!empty($getExcerpt)) :
								$excerpt = wp_trim_words( $getExcerpt, 16, '...');
							?>
								<p><?php echo $excerpt; ?></p>
							<?php endif; ?>
						</a>
					<?php
						endwhile; // End of the loop.
					?>
				</div>
				<?php the_posts_pagination(); ?>
			<?php else : ?>
				<h2>No results found</h2>
			<?php endif; ?>
		</div>
	</section>
<?php
get_footer();
