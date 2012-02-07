<?php  
/**
 * The loop for displaying the archives information for template-archives.php,
 * when no posts are avaialable, 404 pages, or empty search results.
 *
 * @package    WordPress
 * @subpackage Debut
 * @since      2.0
 */
?>

<section id="entry-container" role="contentinfo">

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		
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
				the_content(); // Load the content ?>
				
				<?php 
				/**
				 * Archives
				 *
				 */
				locate_template( 'includes/archives.php', true ); // Get archives setup	?>
			
			</div><!-- .entry-content -->
			
		</article><!-- #post-## -->
	 
	<?php endwhile; ?>
	
	<?php else : ?>
			
		<article id="not-found" class="entry">
		
			<p class="message"><?php _e( 'Very sorry, but what you are looking for is not here. Maybe try one of the links below.', 'theme-it' ); ?></p>
			
			<?php 
			/**
			 * Entry Header
			 *
			 */
			locate_template( 'includes/entry-header.php', true ); ?>
			
			<?php
			/**
			 * Archives
			 *
			 */
			locate_template( 'includes/archives.php', true ); ?>
		
		</article><!-- #not-found -->
	
	<?php endif; ?>

</section><!-- #entry-container -->
