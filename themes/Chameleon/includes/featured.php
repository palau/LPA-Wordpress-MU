<?php $et_slider_type = apply_filters( 'et_slider_type', get_option('chameleon_slider_type') ); ?>

<div id="featured<?php if ( $et_slider_type == 'roundabout' ) echo '-modest'; ?>">
	<?php if ( $et_slider_type == 'cycle' ) { ?>
		<a id="left-arrow" href="#"><?php _e('Previous','Chameleon'); ?></a>
		<a id="right-arrow" href="#"><?php _e('Next','Chameleon'); ?></a>
	<?php } ?>
	
<?php if ( $et_slider_type <> 'roundabout' ) { ?>
	<div id="slides">
<?php } ?>
		<?php global $ids;
		$ids = array(); 
		$i=1;
		
		$featured_cat = get_option('chameleon_feat_cat'); 
		$featured_num = get_option('chameleon_featured_num'); 
	
		if (get_option('chameleon_use_pages') == 'false') query_posts("showposts=$featured_num&cat=".get_cat_ID($featured_cat));
		else {
			global $pages_number;
			
			if (get_option('chameleon_feat_pages') <> '') $featured_num = count(get_option('chameleon_feat_pages'));
			else $featured_num = $pages_number;
			
			query_posts(array
							('post_type' => 'page',
							'orderby' => 'menu_order',
							'order' => 'ASC',
							'post__in' => get_option('chameleon_feat_pages'),
							'showposts' => $featured_num
						));
		} ?>
		<?php if (have_posts()) : while (have_posts()) : the_post();
		global $post; ?>
		
			<?php if ( $et_slider_type == 'cycle' ) { ?>
				<div class="slide">
					<?php
					$width = 960;
					$height = 332;
					$titletext = get_the_title();
		
					$thumbnail = get_thumbnail($width,$height,'',$titletext,$titletext,false,'Featured');
					$thumb = $thumbnail["thumb"];
					print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, ''); ?>
					<div class="featured-top-shadow"></div>
					<div class="featured-bottom-shadow"></div>	
					
					<div class="featured-description">
						<h2 class="featured-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<p><?php truncate_post(225); ?></p>
						<a href="<?php the_permalink(); ?>" class="readmore"><?php _e('Read More', 'Chameleon'); ?></a>
					</div> <!-- end .featured-description -->
				</div> <!-- end .slide -->
			<?php } ?>
			
			<?php if ( $et_slider_type == 'nivo' ) { ?>
				<?php
				$width = 960;
				$height = 332;
				$titletext = get_the_title();

				$thumbnail = get_thumbnail($width,$height,'',$titletext,$titletext,false,'Featured');
				$thumb = $thumbnail["thumb"]; ?>
				<a href="<?php the_permalink(); ?>">
					<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, ''); ?>
				</a>
			<?php } ?>
			
			<?php if ( $et_slider_type == 'roundabout' ) { ?>
				<?php
					$et_link = get_post_meta($post->ID,'Link',true) ? get_post_meta($post->ID,'Link',true) : get_permalink();
			
					$et_slide_class = '';
					if ( $i == 1 ) $et_slide_class = ' active-block';
					if ( $i == 2 ) $et_slide_class = ' next-block';
					if ( $i == $featured_num ) $et_slide_class = ' prev-block';
					$width = 462;
					$height = 306;
				?>
				<div class="slide<?php echo $et_slide_class; ?>">
					<a href="<?php echo $et_link; ?>" class="main">
						<?php
							$post_title = get_the_title();
							
							$thumbnail = get_thumbnail($width,$height,'thumb',$post_title,$post_title);
							$thumb = $thumbnail["thumb"];
							
							print_thumbnail($thumb, $thumbnail["use_timthumb"], $post_title, $width, $height, 'Featured'); 
						?>
					</a>
					
					<h2 class="featured-title"><?php the_title(); ?></h2>
					<div class="description">
						<p><?php truncate_post(200); ?></p>
					</div> <!-- end .description -->
					
					<div class="shadow-left"></div>
					<div class="shadow-right"></div>
					<a class="featured-link" href="<?php echo $et_link; ?>"><?php _e('Read more','Chameleon'); ?></a>
					
					<img src="<?php bloginfo('template_directory'); ?>/images/active-bottom-shadow.png" alt="" class="bottom-shadow" />
					<a href="#" class="gotoslide"><span></span></a>
				</div> <!-- end .slide -->
			<?php } ?>
			
		<?php $ids[] = $post->ID; $i++; endwhile; endif; wp_reset_query(); ?>
<?php if ( $et_slider_type <> 'roundabout' ) { ?>
	</div> <!-- end #slides -->
<?php } ?>
</div> <!-- end #featured -->

<?php if ( $et_slider_type <> 'roundabout' ) { ?>
	<div id="controllers"></div>
<?php } ?>