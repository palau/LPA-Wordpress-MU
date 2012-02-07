<?php /* this is archive.php */ ?>
<?php get_header(); ?>
	<div id="content" class="col-full">
		<div id="main" class="col-left">
			<?php if (have_posts()) : $count = 0; ?>
			<span class="archive_header">
				<?php if(is_category()): ?>
					<span class="fl cat">
						<?php standard_get_archive_title(); ?>
					</span>
					<span class="fr catrss">
						<?php echo standard_get_archive_rss_container($wp_query); ?>
					</span>
				<?php else:
					standard_archive_header(is_day(), is_month(), is_year(), is_author(), is_tag(), $wp_query);
				endif; ?>
			</span>
			<div class="fix"></div> 
			<?php while (have_posts()) : the_post(); $count++; ?>
				<div class="post">
				<?php edit_post_link('edit','<span class="the_edit_link">','</span>') ?>
					<h2 class="title">
						<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>">
							<?php the_title(); ?>
						</a>
					</h2>
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
					</p>
					<div class="entry">
						<?php the_content(); ?>
					</div>
				</div>
			 <?php endwhile; else: ?>
				<div class="post">
					<h2 class="title">
						<?php _e('Error 404 - Page Not Found!','livetheme'); ?>
					</h2>
					<p>
						<?php _e('Whoops! Something broke. Please try again!','livetheme'); ?>
					</p>
				</div>
			<?php endif; ?>	 
			<div class="more_entries">
					<div class="fl">
						<?php next_posts_link(__('&laquo; Older Entries','livetheme')) ?>
					</div>
					<div class="fr">
						<?php previous_posts_link(__('Newer Entries &raquo;','livetheme')) ?>
					</div>
				<div class="fix"></div>
			</div>
		</div>
	<?php get_sidebar(); ?>
	</div>
<?php get_footer(); ?>