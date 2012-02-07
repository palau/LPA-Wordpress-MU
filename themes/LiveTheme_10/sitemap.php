<?php /* Template Name: Sitemap */ ?>
<?php get_header(); ?>
	<div id="content" class="col-full">
		<div id="main" class="col-<?php echo main_content_orientation(); ?>">
			<div class="post">
				<h2 class="title">
					<?php the_title(); ?>
				</h2>
				<div class="entry">
					<h3>
						<?php _e('Pages:','livetheme'); ?>
					</h3>
					<ul>
						<?php wp_list_pages('depth=0&sort_column=menu_order&title_li=' ); ?>
					</ul>
					<h3>
						<?php _e('Categories:','livetheme'); ?>
					</h3>
					<ul>
						<?php wp_list_categories('title_li=&hierarchical=0&show_count=1') ?>
					</ul>
					<h3>
						<?php _e('Posts Per Category:','livetheme'); ?>
					</h3>
					<?php 
					$cats = get_categories();
					foreach ($cats as $cat) { 
						query_posts('cat='.$cat->cat_ID);
					?>
						<h4>
							<?php echo $cat->cat_name; ?>
						</h4>
						<ul>
							<?php while (have_posts()) : the_post(); ?>
								<li style="font-weight:normal !important;">
									<?php the_time('Y, M j') ?> - <a href="<?php the_permalink() ?>"><?php the_title(); ?></a> - <?php _e('Comments','livetheme'); ?> (<?php echo $post->comment_count ?>)
								</li>
							<?php endwhile;	 ?>
						</ul>
					<?php } ?>
				</div>
			</div>
		</div>
	<?php get_sidebar(); ?>
	</div>
<?php get_footer(); ?>