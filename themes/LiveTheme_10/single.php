<?php /* this is single.php */ ?>
<?php get_header(); ?>
	<div id="content" class="col-full">
		<div id="main" class="col-left">
			<?php if (have_posts()) : $count = 0; ?>
			<?php while (have_posts()) : the_post(); $count++; ?>
				<div class="post">
					<?php edit_post_link('edit','<span class="the_edit_link">','</span>') ?>
					<h1 class="title">
						<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>">
							<?php the_title(); ?>
						</a>
					</h1>
					<p class="post-meta">
						<span class="the_time">
							<?php the_time('F j, Y'); ?>
						</span> <?php _e('in','livetheme'); ?> 
						<span class="the_category">
							<?php the_category(','); ?>
						</span> <?php _e('with','livetheme'); ?> 
						<span class="the_comment_link">
							<?php comments_popup_link(__('0 Comments','livetheme'), __('1 Comment','livetheme'), __('% Comments','livetheme')); ?>
						</span>
						<?php edit_post_link('edit','<span class="single_edit_link">','</span>') ?>
					</p>
					<div class="entry">
						<div id="video_archived"><?php $key="video"; echo get_post_meta($post->ID, $key, true); ?></div>
						<?php the_content(); ?>
					</div>
				</div>
			<?php comments_template('', true); ?>
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
	<?php get_sidebar(); ?>
	</div>
<?php get_footer(); ?>