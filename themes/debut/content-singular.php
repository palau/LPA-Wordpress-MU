<?php 
/**
 * The loop for displaying singular page content (single, page, attachements)
 *
 * @package    WordPress
 * @subpackage Debut
 * @since      2.0
 */

/**
 * The Loop
 *
 */ 
if ( have_posts() ) : ?>
	
	<section id="entry-container" role="contentinfo">
	
		<?php while( have_posts() ) : the_post(); ?>
	
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ) ?>>
				
				<?php 
				/**
				 * Entry Thumbnail
				 *
				 */
				locate_template( 'includes/entry-thumbnail.php', true ); ?>
				
				
				<?php
				/**
				 * Entry Header
				 *
				 */
				locate_template( 'includes/entry-header.php', true ); ?>
				
				<div class="entry-content">
					
					<?php 
					/**
					 * Entry Content
					 *
					 */
					the_content(); ?>
					
					
					<?php
					/**
					 * Page Links
					 *
					 */
					wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'theme-it' ) . '</span>', 'after' => '</div>' ) ); ?>
					
					
					<?php 
					/**
					 * Entry Utility
					 *
					 */
					$of_disable_post_attributes = ti_get_option( 'disable_post_attributes' );
					
					if( is_single() && $of_disable_post_attributes['posted_in'] == 0 ) : // Show entry utility if single page ?>
					
						<div class="entry-utility">
			  		
							<?php 
							/**
							 * Entry Utility
							 *
							 */
							ti_posted_in(); // Get post cateogry and comment information (functions.php) ?>
			  			
						</div><!-- .entry-utility -->
					
					<?php endif; // End single page check ?>
					
				</div><!-- .entry-content -->
			
			</article><!-- #post-## -->
		
			<?php 
			/**
			 * Entry Comments
			 *
			 */
			$of_disable_post_attributes = ti_get_option( 'disable_post_attributes' );
			
			if ( $of_disable_post_attributes['comments'] == 0 ) {
				comments_template( '', true );
			} ?>
		
		<?php endwhile; ?>
		
	</section><!-- #entry-container -->

<?php endif; // end of the loop ?>