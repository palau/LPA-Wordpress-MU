<?php get_header(); ?>	

		<?php while ( wptouch_have_posts() ) { ?>

		<?php wptouch_the_post(); ?>

		<div class="<?php wptouch_post_classes(); ?> rounded-corners-8px">

			<?php if ( classic_use_thumbnail_icons() && classic_thumbs_on_single() && get_post_meta($post->ID, 'embed') != '') { ?>
				<?php include('thumbnails.php');
					//echo get_post_meta($post->ID, 'img_poster', true);
				?>
			<?php } ?>	

			<h2><?php wptouch_the_title(); ?></h2>

			<div class="date-author-wrap">
				<?php if ( classic_show_date_single() ) { ?>
					<div class="<?php wptouch_date_classes(); ?>">
						<?php _e( "Published on", "wptouch-pro" ); ?> <?php wptouch_the_time( 'F jS, Y' ); ?>
					</div>			
				<?php } ?>	
				<?php if ( classic_show_author_single() ) { ?>
					<div class="post-author">
						<?php _e( "Written by", "wptouch-pro" ); ?>: <?php the_author(); ?> 
					</div>
				<?php } ?>	
			</div>
		</div>	
		
		<div class="<?php wptouch_post_classes(); ?> rounded-corners-8px">

		<!-- text for 'back and 'next' is hidden via CSS, and replaced with arrow images -->
			<div class="post-navigation nav-top">
				<div class="post-nav-fwd">
					<?php classic_get_next_post_link(); ?>
				</div>				
				<div class="post-nav-middle">
					<?php if ( wptouch_get_comment_count() > 0 ) echo '<a href="#comments-' . get_the_ID() . '" class="middle-link no-ajax">' . __( "Skip to Responses", "wptouch-pro" ) . '</a>' ; ?>
				</div>
				<div class="post-nav-back">
						<?php classic_get_previous_post_link(); ?>
				</div>
			</div>
			
			<div class="<?php wptouch_content_classes(); ?>">
			<?php
				// Get $post if you're inside a function
				//global $post;
			/*	

				if ( in_category( 'videos' ) ) {
				    echo ('there is video!');
				} else {
				    echo ('there is NO video!');
				}*/
			?>
		<?php if ( in_category( 'videos' ) ) {?>
			<!--
			<video src="<?php //echo get_post_meta($post->ID, "video_url", true); ?>" controls="controls" autoplay="autoplay" poster="http://i.tinysrc.mobi/<?php //echo get_post_meta($post->ID, "img_poster", true); ?>">
			</video>
			-->
		<?php // show the embed video field
		echo get_post_meta($post->ID, "embed", true); ?>
		<?php } else {?>
			<img src="http://i.tinysrc.mobi/-10/<?php echo get_post_meta($post->ID, "img_poster", true); ?>" width="100%" alt="<?php wptouch_the_title(); ?>" />
		<?php } ?>
				<?php wptouch_the_content(); ?>

				<?php if ( classic_show_cats_single() || classic_show_tags_single() || wp_link_pages('echo=0') ) { ?>
					<div class="single-post-meta-bottom">
						<?php wp_link_pages( 'before=<div class="post-page-nav">' . __( "Article Pages", "wptouch-pro" ) . ':&after=</div>&next_or_number=number&pagelink=page %&previouspagelink=&raquo;&nextpagelink=&laquo;' ); ?>          
	
						<?php if ( classic_show_cats_single() ) { ?>
							<div class="post-page-cats"><?php _e( "Categories", "wptouch-pro" ); ?>: <?php if ( the_category( ', ' ) ) the_category(); ?></div>
						<?php } ?>
	
						<?php if ( classic_show_tags_single() ) { ?>					
							<?php if ( function_exists( 'get_the_tags' ) ) the_tags( '<div class="post-page-tags">' . __( 'Tags', 'wptouch-pro' ) . ': ', ', ', '</div>'); ?>  
						<?php } ?>
					</div>   
				<?php } ?>

			</div>

			<div class="post-navigation nav-bottom">
				<div class="post-nav-fwd">
					<?php classic_get_next_post_link(); ?>
				</div>	
				<div class="post-nav-middle">
					<a href="#header" class="back-to-top"><?php _e( "Back to Top", "wptouch-pro" ); ?></a>
				</div>
				<div class="post-nav-back">
					<?php classic_get_previous_post_link(); ?>
				</div>
			</div>
		</div><!-- wptouch_posts_classes() -->

		<?php } // endwhile ?>

		<?php comments_template(); ?>

<?php get_footer(); ?>