<?php
/*
Template Name: Video Archive page
*/
?>
<?php get_header(); ?>
	<div id="content" class="col-full">
		<div id="main" class="full-width borders shadow">
			<div class="archive-container">
				<h1 class="title archive-title"><?php the_title(); ?></h1>
				<?php if (have_posts()) : $count = 0; 
					$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
					query_posts( array ( 'category_name' => 'video-archives', 'paged' => $paged, 'posts_per_page' => 9 ) ); ?>
					<?php while (have_posts()) : the_post(); $count++; ?>
						<div id="post-<?php the_ID(); ?>" class="archive-post">
								
								<a class="video-link video-fade" rel="prettyPhoto" href="#video-<?php the_ID(); ?>" title="" >
								<?php
									if(has_post_thumbnail()) :
									// Grab the Thumbnail URL
									$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'post-thumbnail' );
									$url = $thumb['0']; ?>
											<img src="<?php echo $url ?>" alt="<?php the_title(); ?>" />
									<?php else :?>
										<img src="<?php bloginfo('template_directory'); ?>/images/video-placeholder.jpg" alt="<?php the_title(); ?>" />
									<?php endif;?>
									</a>
								<h2><?php the_title(); ?></h2>
								<div id="video-<?php the_ID(); ?>" class="hide">
									<div class="video-content">
										<?php the_content(); ?>
									</div>
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
				<div class="clear"></div>
				<div class="archive-navigation"><?php posts_nav_link(); ?></div>
			</div>  <!-- /Archive-container -->
		</div>
	</div>
<?php get_footer(); ?>