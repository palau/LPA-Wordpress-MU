<?php /* this is single.php */ ?>
<?php get_header(); ?>
	<div id="content" class="col-full">
		<div id="main" class="col-<?php echo main_content_orientation(); ?>">
			<?php standard_sharers(); ?>
			<?php standard_breadcrumbs(); ?>
			<?php if (have_posts()) : $count = 0;
				while (have_posts()) : the_post(); $count++;
					get_template_part( 'loop', get_post_format() );
					standard_author_box();
					comments_template('', true);
				endwhile; 
				else: ?>
				<div class="post">
					<h2 class="title">
						<?php _e('Sorry!','standardtheme'); ?>
					</h2>
					<p>
						<?php _e('Whoops! Something broke. Please try again!','standardtheme'); ?>
					</p>
				</div>
			<?php endif; ?>
		</div>
	<?php get_sidebar(); ?>
	</div>
<?php get_footer(); ?>