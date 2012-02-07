<?php /* this is search.php */ ?>
<?php get_header(); ?>
	<div id="content" class="col-full">
		<div id="main" class="col-<?php echo main_content_orientation(); ?>">
			<?php if (have_posts()) : $count = 0; ?>
				<span class="archive_header">
					<?php _e('Search Results: '); printf(__('\'%s\''), $s) ?>
				</span>
				<?php while (have_posts()) : the_post(); $count++; ?>
					<div id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
						<?php edit_post_link('edit','<span class="the_edit_link">','</span>') ?>
						<h2 class="title">
							<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>">
								<?php the_title(); ?>
							</a>
						</h2>
						<p class="post-meta">
							<span class="the_time">
								<?php the_time('F j, Y'); ?>
							</span> <?php _e('in','standardtheme'); ?> 
							<span class="the_category">
								<?php the_category(', '); ?>
							</span> <?php _e('with','standardtheme'); ?> 
							<span class="the_comment_link">
								<?php comments_popup_link(__('0 Comments','standardtheme'), __('1 Comment','standardtheme'), __('% Comments','standardtheme')); ?>
							</span>
						</p>
						<div class="entry">
							<?php the_content(__('Continue Reading...','standardtheme')); ?>
							<div class="clear"></div>
						</div>
					</div>
				<?php endwhile; 
				else: ?>
					<div class="post">
						<h2 class="title">
							<?php _e('Sorry!','standardtheme'); ?>
						</h2>
						<p>
							<?php _e('Sorry! No posts match your criteria!','standardtheme'); ?>
						</p>
					</div>
			<?php endif; ?>
			<?php standard_pagination(); ?>
		</div>
		<?php get_sidebar(); ?>
	</div>
<?php get_footer(); ?>