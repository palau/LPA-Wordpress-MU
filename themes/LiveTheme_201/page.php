<?php /* this is page.php */ ?>
<?php get_header(); ?>
	<div id="content" class="col-full">
		<div id="main" class="full-width borders shadow">
			<?php if (have_posts()) : $count = 0; ?>
				<?php while (have_posts()) : the_post(); $count++; ?>
					<div class="post">
						<?php edit_post_link('edit','<span class="the_edit_link">','</span>') ?>
						<h1 class="title">
								<?php the_title(); ?>
						</h1>
						<div class="entry">
							<?php the_content(); ?>
						</div>
					</div>
				<?php endwhile; 
			else: ?>
				<div class="post">
					<h2 class="title">
						<?php _e('Sorry!','livetheme'); ?>
					</h2>
					<p>
						<?php _e('Whoops! Something broke. Please try again!','livetheme'); ?>
					</p>
				</div>
			<?php endif; ?>	
		</div>
	</div>
<?php get_footer(); ?>