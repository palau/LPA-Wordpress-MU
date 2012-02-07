<?php the_post(); ?>
<?php get_header(); ?>

<?php include(TEMPLATEPATH . '/includes/breadcrumbs.php'); ?>
<?php include(TEMPLATEPATH . '/includes/top_info.php'); ?>

<div id="content" class="clearfix">
	<div id="left-area">
		<div class="entry post clearfix">
			<?php if (get_option('chameleon_integration_single_top') <> '' && get_option('chameleon_integrate_singletop_enable') == 'on') echo(get_option('chameleon_integration_single_top')); ?>
			
			<?php if (get_option('chameleon_thumbnails') == 'on') { ?>
				<?php 
					$thumb = '';
					$width = 186;
					$height = 186;
					$classtext = 'post-thumb';
					$titletext = get_the_title();
					$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,false,'Entry');
					$thumb = $thumbnail["thumb"];
				?>
				
				<?php if($thumb <> '') { ?>
					<div class="post-thumbnail">
						<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
						<span class="post-overlay"></span>
					</div> 	<!-- end .post-thumbnail -->
				<?php } ?>
			<?php } ?>
			
			<?php the_content(); ?>
			<?php wp_link_pages(array('before' => '<p><strong>'.__('Pages','Chameleon').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
			<?php edit_post_link(__('Edit this page','Chameleon')); ?>			
		</div> <!-- end .entry -->
		
		<?php if (get_option('chameleon_integration_single_bottom') <> '' && get_option('chameleon_integrate_singlebottom_enable') == 'on') echo(get_option('chameleon_integration_single_bottom')); ?>		
					
		<?php if (get_option('chameleon_468_enable') == 'on') { ?>
				  <?php if(get_option('chameleon_468_adsense') <> '') echo(get_option('chameleon_468_adsense'));
				else { ?>
				   <a href="<?php echo(get_option('chameleon_468_url')); ?>"><img src="<?php echo(get_option('chameleon_468_image')); ?>" alt="468 ad" class="foursixeight" /></a>
		   <?php } ?>   
		<?php } ?>
		
		<?php if (get_option('chameleon_show_postcomments') == 'on') comments_template('', true); ?>
	</div> 	<!-- end #left-area -->

	<?php get_sidebar(); ?>
</div> <!-- end #content -->	
		
<?php get_footer(); ?>