<?php get_header(); ?>	

	<!-- This function figures out what type of archive it is and spits it out as the title in a div class="archive-text" -->
	<?php classic_archive_text(); ?>

	<?php while ( wptouch_have_posts() ) { ?>

		<?php wptouch_the_post(); $first++; ?>

		<div class="<?php wptouch_post_classes(); ?> rounded-corners-8px">

			<?php if ( is_sticky( $post_ID ) ) echo '<div class="sticky-pushpin"></div>'; ?>

		<?php if ( classic_use_calendar_icons() || classic_use_thumbnail_icons() ) { ?>
			<?php if ( wptouch_get_comment_count() ) { ?> 
				<div class="comment-bubble <?php if ( wptouch_get_comment_count() > 9 ) echo 'double'; elseif ( wptouch_get_comment_count() > 99 ) echo 'triple';  ?>">
					<?php comments_number('0','1','%'); ?>
				</div>
			<?php } ?>
		<?php } ?>

			<?php if ( classic_use_calendar_icons() ) { ?>
				<?php include('calendar-icons.php'); ?>	
			<?php } elseif ( classic_use_thumbnail_icons() ) { ?>
				<?php include('thumbnails.php'); ?>
			<?php } ?>		
			<?php if ( !classic_excerpts_open() ) { ?>
				<a href="javascript:return false;" rel="<?php the_ID(); ?>" class="excerpt-button no-ajax"></a>	
			<?php } ?>
			<h2><a href="<?php wptouch_the_permalink(); ?>"><?php wptouch_the_title(); ?></a></h2>
	
			<div class="date-author-wrap">
				<?php if ( !classic_use_calendar_icons() && classic_show_date_in_posts() ) { ?>
					<div class="<?php wptouch_date_classes(); ?>">
						<?php wptouch_the_time( 'F jS, Y' ); ?>
					</div>	
				<?php } ?>		
				<?php if ( classic_show_author_in_posts() ) { ?>
					<div class="post-author">
						by <?php the_author(); ?> 
					</div>
				<?php } ?>
			</div>
							
			<?php if ( wptouch_has_tags() && classic_show_tags_in_posts() ) { ?>
				<div class="tags-and-categories">
					<?php _e( "Tags", "wptouch-pro" ); ?>: <?php wptouch_the_tags(); ?>
				</div>
			<?php } ?>
			
			<?php if ( wptouch_has_categories() && classic_show_categories_in_posts() ) { ?>
				<div class="tags-and-categories">
					<?php _e( "Categories", "wptouch-pro" ); ?>: <?php wptouch_the_categories(); ?>
				</div>
			<?php } ?>			
			<div class="<?php wptouch_content_classes(); ?>">

					<?php the_excerpt(); ?>
					<a href="<?php wptouch_the_permalink(); ?>" class="read-entry"><?php _e( "Read This Article", "wptouch-pro" ); ?></a>

			</div>

		</div><!-- .wptouch_posts_classes() -->

	<?php } ?>

		<?php if ( wptouch_has_next_posts_link() ) { ?>
			<?php if ( !classic_is_ajax_enabled() ) { ?>	
				<div class="posts-nav post rounded-corners-8px">
					<div class="left"><?php previous_posts_link( __( "Back", "wptouch-pro" ) ) ?></div>
					<div class="right clearfix"><?php next_posts_link( __( "Next", "wptouch-pro" ) ) ?></div>
				</div>
			<?php } else { ?>
				<a class="load-more-link" href="javascript: return false;" rel="<?php echo get_next_posts_page_link(); ?>">
					<?php _e( "Load More Entries&hellip;", "wptouch-pro" ); ?>
				</a>
			<?php } ?>
		<?php } ?>

<?php get_footer(); ?>