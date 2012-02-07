<?php  
/**
 * The loop for displaying multiple posts (blog, search, categories, tags, etc).
 *
 * @package    WordPress
 * @subpackage Debut
 * @since      2.0
 */
?>

<section id="entry-container" role="contentinfo">
	
	<?php if( have_posts() ) : ?>
	
		<?php
		/**
		 * Page Header
		 *
		 */
		locate_template( 'includes/page-header.php', true ); ?>
		
		<?php while( have_posts() ) : the_post(); ?>
	
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ) ?>>
	  		
				<?php 
				/**
				 * Entry Thumbnail
				 *
				 */
				locate_template( 'includes/entry-thumbnail.php', true, false ); ?>
	  		
	  			<div class="entry-main-content">
	  			
					<?php
					/**
					 * Entry Header
					 *
					 */
					locate_template( 'includes/entry-header.php', true, false ); ?>
	  				
	  				
					<?php
					/**
					 * Entry Content/Summary
					 *
					 */
					if ( is_search() ) : // Check if this is an Archives and Search page ?>
	  	  			
						<div class="entry-summary">
							
							<?php the_excerpt(); ?>
							
							<a class="more-link" href="<?php the_permalink() ?>" title="<?php ti_the_title_attribute(); ?>"><?php _e( 'Read More &rarr;', 'theme-it' ); ?></a>
						
						</div><!-- .entry-summary -->
	  	  			
					<?php else : // If not Archives or Search page ?>
	  				
						<div class="entry-content">
	  	  			
							<?php global $more; $more = 0; // Needed for more tag to work ?>
							
							<?php the_content( __( 'Read More &rarr;', 'theme-it' ) ); // Show content ?>
							
							<?php do_action( 'get_page_links' ); // Show page links (custom function to wp_link_pages() - functions/theme-helpers.php ?>
	  	  			
						</div><!-- .entry-content -->
	  				
					<?php endif; // End Archive and Search page check ?>
				
				</div><!-- .entry-main-content -->
			
			</article><!-- #post-## -->
			
			
			<?php 
			/**
			 * Instant View Modal Box
			 *
			 */
			if( 1 == ti_get_option( 'instant_view' ) )
				do_action( 'get_modal_box', $post->ID, true ); 
			?>

	  	
			<?php 
			/**
			 * Entry Comments
			 *
			 */
			$of_disable_post_attributes = ti_get_option( 'disable_post_attributes' );
			if ( $of_disable_post_attributes['comments'] == 0 ) {
				comments_template( '', true );
			} ?>
	  	
		<?php endwhile; // end posts loop ?>
	  
	<?php else : // If there are not any posts ?>
		
		<?php
		/**
		 * Page Header
		 *
		 */
		locate_template( 'includes/page-header.php', true ); ?>
		
		
		<?php
		/**
		 * Archives
		 *
		 */
		get_template_part( 'content', 'archives' ); ?>
		

	<?php endif; // end loop ?>
	
	
	<?php
	/**
	 * Pagination
	 *
	 */
	if ( $wp_query->max_num_pages > 1 ) : // Check for pages ?>
	
		<div id="nav-below" class="pagenavi">
			
			<?php if ( function_exists( 'wp_pagenavi' ) ) : // Check for WP Page Navi Plugin ?>
			
				<?php wp_pagenavi(); ?>
			
			<?php else : ?>
				
				<div class="nav-previous"><?php next_posts_link( '<span class="meta-nav">&larr;</span>' . __( ' Older', 'theme-it' ) ); ?></div>
			  
				<div class="nav-next"><?php previous_posts_link( __( 'Newer ', 'theme-it' ) . '<span class="meta-nav">&rarr;</span>' ); ?></div>
			
			<?php endif; // End WP Page Navi plugin check ?>
		
		</div><!-- #nav-below -->
	
	<?php endif; // end page check ?>
	
</section><!-- #entry-container -->


