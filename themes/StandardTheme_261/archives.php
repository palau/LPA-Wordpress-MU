<?php /* Template Name: Archives */ ?>
<?php get_header(); ?>
	<div id="content" class="col-full">
		<div id="main" class="col-<?php echo main_content_orientation(); ?>">
			<div class="post">
				<?php edit_post_link('edit','<span class="the_edit_link">','</span>') ?>
				<h2 class="title">
					<?php the_title(); ?>
				</h2>
				<div class="entry">
					<h3>
						<?php _e('The Last 30 Blog Posts:','standardtheme'); ?>
					</h3>
					<ul>
						<?php query_posts('showposts=30'); ?>
						<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
						<?php $wp_query->is_home = false; ?>
						<li>
							<?php the_time('Y, M j') ?> - <a href="<?php the_permalink() ?>"><?php the_title(); ?></a> - <?php echo $post->comment_count ?> <?php _e('Comments','standardtheme'); ?>
						</li>
						<?php endwhile; endif; ?>
					</ul>
					<h3>
						<?php _e('Categories:','standardtheme'); ?>
					</h3>
					<ul>
						<?php wp_list_categories('title_li=&hierarchical=0&show_count=1') ?>
					</ul>
					<h3>
						<?php _e('Monthly Archives:','standardtheme'); ?>
					</h3>
					<ul>
						<?php wp_get_archives('type=monthly&show_post_count=1') ?>	
					</ul>
				</div>
			</div>
		</div>
	<?php get_sidebar(); ?>
	</div>
<?php get_footer(); ?>