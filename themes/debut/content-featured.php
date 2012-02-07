<?php
/**
 * The loop for displaying featured posts on home page.
 *
 * @package    WordPress
 * @subpackage Debut
 * @since      2.0
 */

global $is_page;


/**
 * The Loop
 *
 */
if ( have_posts() ) : ?>

	<section id="featured" role="contentinfo">
		
		<?php if ( $is_page !== 'template-post-gallery' ) : ?>
		
			<header id="featured-header" class="clearfix">
			  
				<h3 class="section-title">
			  
					<?php	  
					/**
					 * Section Title
					 *
					 */
					 
					// Get theme options
					$of_featured_section_title = ti_get_option( 'featured_section_title', 'Featured' );

					esc_html_e( $of_featured_section_title, 'theme-it' ); ?>
			  	
				</h3><!-- .section-title -->
			  
			</header><!-- #featured-header -->
		
		<?php endif; // end page template check ?>
	
		<div id="featured-content" class="clearfix">
		
			<?php while ( have_posts() ) : the_post(); ?>
				
				<?php $of_featured_hide = ti_get_option( 'featured_hide' ); ?>
				
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ) ?>>
					
					<?php
					/**
					 * Entry Thumbnail
					 *
					 */
					if ( $of_featured_hide['images'] == 0 || $is_page == 'template-post-gallery' ) : // Check if thumbnail is disabled in theme options ?>
						
						<?php locate_template( 'includes/entry-thumbnail.php', true, false ); ?>
					
					<?php endif; // end hide featured image check ?>
					

					<?php
					/**
					 * Entry Header
					 *
					 */
					if ( $of_featured_hide['titles'] == 0 || $is_page == 'template-post-gallery' ) : // Check if title is disabled in theme options ?>
					
						<header class="entry-header">
				  	  
							<h4><a href="<?php the_permalink() ?>" title="<?php ti_the_title_attribute(); ?>"><?php the_title(); ?></a></h4>
				  	
						</header><!-- .entry-header -->
					
					<?php endif; // end show title check ?>
					
					
					<?php
					/**
					 * Entry Summary
					 *
					 */
					if ( $of_featured_hide['content'] == 0 || $is_page == 'template-post-gallery' ) : // Check if content is disabled in theme options ?>
					
						<div class="entry-summary">
							
							<?php the_excerpt(); ?>
						
						</div><!-- .entry-summary -->
					
					<?php endif; // end show summary check ?>
					
					
					<?php
					/**
					 * More Link
					 *
					 */
					if ( $of_featured_hide['read_more'] == 0 || $is_page == 'template-post-gallery' ) : // Check if read more is disabled in theme options ?>
					
						<footer class="entry-footer">
							
							<a class="more-link" href="<?php the_permalink() ?>" title="<?php ti_the_title_attribute(); ?>"><span><?php _e( 'Read More &rarr;', 'theme-it' ); ?></span></a>
						
						</footer><!-- .entry-footer -->
					
					<?php endif; // end read more check ?>
					
				</article><!-- #post-## -->
				
				
				<?php 
				/**
				 * Instant View Modal Box
				 *
				 */
				if( 1 == ti_get_option( 'instant_view' ) )
					do_action( 'get_modal_box', $post->ID, true ); 
				?>

			
			<?php endwhile; // end while loop ?>
			
		</div><!-- .entry-container -->
		
		<?php
		/**
		 * Pagination
		 *
		 */
		 
		// Get theme options
		$featured_enable_pagination = ti_get_option( 'featured_enable_pagination', 0 );
		
		if ( ( $is_page == 'template-post-gallery' || $featured_enable_pagination == 1 ) && $wp_query->max_num_pages > 1 ) : // Check for pages ?>
		
			<div id="nav-below" class="pagenavi">
				
				<?php if ( function_exists( 'wp_pagenavi' ) ) : // Check for WP Page Navi Plugin ?>
				
					<?php wp_pagenavi(); ?>
				
				<?php else : ?>
					
					<div class="nav-previous"><?php next_posts_link( '<span class="meta-nav">&larr;</span>' . __( ' Older', 'theme-it' ) ); ?></div>
				  
					<div class="nav-next"><?php previous_posts_link( __( 'Newer ', 'theme-it' ) . '<span class="meta-nav">&rarr;</span>' ); ?></div>
				
				<?php endif; // End WP Page Navi plugin check ?>
			
			</div><!-- #nav-below -->
		
		<?php endif; // end page check ?>
		
	</section><!-- #featured -->
	
<?php endif; // end loop ?>



<?php wp_reset_query(); // reset query ?>
